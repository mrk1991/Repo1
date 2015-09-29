-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Set 29, 2015 alle 15:40
-- Versione del server: 5.5.41-0ubuntu0.14.04.1
-- Versione PHP: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amm15_faddaMirko`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nome`) VALUES
(1, 'Regolamento'),
(2, 'Presentiamoci'),
(3, 'Eventi nel cielo'),
(4, 'Consigli strumentazione');

-- --------------------------------------------------------

--
-- Struttura della tabella `discussioni`
--

CREATE TABLE IF NOT EXISTS `discussioni` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data` datetime DEFAULT NULL,
  `titolo` varchar(128) DEFAULT NULL,
  `categoria_id` bigint(20) unsigned DEFAULT NULL,
  `creatore_id` bigint(20) unsigned DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `creatore_fk` (`creatore_id`),
  KEY `categoria_fk` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `discussioni`
--

INSERT INTO `discussioni` (`id`, `data`, `titolo`, `categoria_id`, `creatore_id`) VALUES
(1, '2015-09-21 18:57:36', 'Regolamento generale', 1, 1),
(2, '2015-09-28 15:18:38', 'Salve gente', 2, 2),
(3, '2015-09-28 21:27:09', 'Raduno per astrofili all''osservatorio di Cagliari il 12/10/2015', 3, 7);

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data` datetime DEFAULT NULL,
  `testo` varchar(8192) DEFAULT NULL,
  `discussione_id` bigint(20) unsigned DEFAULT NULL,
  `creatore_id` bigint(20) unsigned DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `discussione_fk` (`discussione_id`),
  KEY `creatore_fk` (`creatore_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`id`, `data`, `testo`, `discussione_id`, `creatore_id`) VALUES
(1, '2015-09-21 18:57:36', 'Il forum &egrave; un luogo in cui utenti accomunati da una stessa passione si incontrano per scambiarsi opinioni ed esperienze riguardanti\n    l''astronomia in tutte le sue forme. Il rispetto delle regole &egrave; importante, sopratutto per la tutela dei partecipanti.</br>\n    </br>Di seguito sono elencate alcune regole basilari per l''uso di questo forum che sarai tenuto ad osservare per dare il tuo contributo alla\n    comunit&agrave;.\n<p>\n    <strong>Staff</strong></br></br>\n    Il forum &egrave; gestito da uno staff, un gruppo di utenti che ha il compito di garantire la serenit&agrave; e il corretto svolgersi delle discussioni,\n    facendo rispettare il Regolamento e adoperandosi per rendere la piattaforma il pi&ugrave; possibile funzionale ed efficiente.\n    <u>Le decisioni prese dallo staff sono insindacabili</u>.\n</p>\n<p>\n    <strong>Responsabilit&agrave; e rispetto</strong></br></br>\n    <u>Accetti di essere l''unico responsabile del contenuto dei tuoi messaggi</u> e accetti altres&igrave; di rivolgerti con rispetto ed educazione agli\n    utenti del Forum e allo staff in qualunque circostanza. Ci riserviamo il diritto di utilizzare qualsiasi informazione in nostro possesso nei\n    tuoi riguardi in caso di complicazioni con la legge.</br>\n    </br>I messaggi inseriti non sono sotto la responsabilit&agrave; dei gestori del Forum, i quali non sono responsabili per il contenuto o\n    l''accuratezza di ogni tuo messaggio. Ci riserviamo il diritto di cancellare o moderare qualunque contenuto che riterremo opportuno, anche\n    senza particolare motivazione. Al fine di rendere le discussioni facilmente fruibili e comprensibili, &egrave; inoltre vietato modificare in maniera\n    sostanziale il contenuto di un proprio post stravolgendone il significato.\n</p>\n<p>\n    <strong>Contenuti e Privacy</strong></br>\n    </br>Accetti e sei consapevole che questo forum non va usato per inserire materiale volgare, osceno, diffamatorio, dannoso, di odio,\n    minatorio, a sfondo sessuale, invadente la privacy di altri o che violi la legge. Inserendo messaggi di questo tipo verrai immediatamente e\n    permanentemente escluso.</br>\n    </br>Come utente concordi che ogni informazione che &egrave; stata inserita verr&agrave; conservata in un database. Poich&egrave; queste informazioni non verranno\n    cedute a terzi senza il tuo consenso, lo Staff non &egrave; ritenuto responsabile per attacchi di hackering che possano comprometterne l''integrit&agrave;.\n    Non puoi inserire, senza specifica autorizzazione, materiale protetto da copyright di qualunque tipo.</br>\n    </br>Ogni utente decidendo di rendere pubblici i propri interventi (post) inviandoli al forum, non potr&agrave; pi&ugrave; considerare i suoi scritti\n    "privati", e purch&eacute; conformi agli originali ne autorizza la riproduzione su qualsiasi altro supporto. Per ulteriori informazioni: Diritti\n    d''Autore Legge del 22 aprile 1941 n&deg; 633 alla voce OPERE COLLETTIVE.</br>\n    </br>Questo Forum usa i cookies per conservare informazioni sul tuo computer locale. Questi cookies non contengono le informazioni che hai\n    inserito, servono soltanto per velocizzarne il processo.\n</p>\n<p>\n    <strong>Nicknames</strong></br></br>\n    Durante la registrazione ti verr&agrave; chiesto di inserire alcune informazioni, tutto quello che inserisci, <u>escluso l''indirizzo e-mail</u>, deve\n    essere considerato come informazione pubblica. Non &egrave; consentito registrarsi con pi&ugrave; di un nickname con mail diverse facenti riferimento ad\n    un''unica identit&agrave; (persona fisica). Le norme sull''utilizzo dei forum richiedono che ci sia l''approvazione dei familiari prima di poter\n    consentire l''uso del servizio da parte di bambini sotto i 13 anni di et&agrave;.</br>\n    </br>Qualora un utente venga bannato o sospeso dal forum non pu&ograve; re-iscriversi con altro nickname.\n</p>\n<p>\n    <strong>Spam e pubblicit&agrave;</strong></br></br>\n    E'' vietato l''invio continuo di messaggi (post) che rimandino al proprio sito web o una qualunque attivit&agrave; atta a promuovere il proprio sito\n    web o un qualunque sito di natura commerciale. A discrezione dello staff, tale attivit&agrave; potr&agrave; essere riconosciuta come spam e l''utente\n    segnalato come spammer.\n</p>\n<p>\n    <strong>Modifiche al Regolamento</strong></br></br>\n    Il presente Regolamento Generale pu&ograve; essere aggiornato in qualsiasi momento a totale discrezione dello staff di AstroWorld, senza che vi sia\n    necessariamente una notifica agli utenti registrati. L''accettazione di tale regolamento implica anche l''accettazione di tutti successivi\n    aggiornamenti che saranno apportati.</br>\n    </br>Chiunque non rispetti il suddetto regolamento sar&agrave; punibile con il ban dell''account. \n</p>', 1, 1),
(2, '2015-09-28 15:18:38', 'Ciao io sono sharon e sono un&#039;astrofila :)', 2, 2),
(3, '2015-09-28 15:20:33', '<div class="quote"> <em>Originariamente scritto da: Sharon</em></br>Ciao io sono sharon e sono un&#039;astrofila :)</div>\n\nBenvenuta su AstroWorld Sharon :)', 2, 1),
(100, '2015-09-28 21:27:09', 'Ciao in tale data ci sar&agrave; questo evento', 3, 7),
(101, '2015-09-28 21:28:38', 'ank io sn della zona quasi quasi facc 1 salto', 3, 18),
(102, '2015-09-28 21:29:23', '<div class="quote"> <em>Originariamente scritto da: pietro</em></br>Ciao in tale data ci sar&agrave; questo evento</div>\n\nculo pene pip&igrave;', 3, 8),
(103, '2015-09-28 21:31:42', '<div class="quote"> <em>Originariamente scritto da: kekko</em></br>culo pene pip&igrave;</div>\n\nu dragu deu seu a piscai', 3, 9),
(104, '2015-09-28 21:32:15', 'si &egrave; andausu a bar', 3, 11),
(105, '2015-09-28 21:33:36', '<div class="quote"> <em>Originariamente scritto da: Andrea</em></br>si &egrave; andausu a bar</div>\n\nio vi ragg cn l&#039;ape mallossi pollini', 3, 6),
(106, '2015-09-28 21:34:20', '<div class="quote"> <em>Originariamente scritto da: ricky</em></br>io vi ragg cn l&#039;ape mallossi pollini</div>\n\nki ti cassanta mancai siasta babbu, filli...', 3, 11),
(107, '2015-09-28 21:36:37', 'eoi messaggiusu coddais&igrave;', 3, 20),
(108, '2015-09-28 21:38:01', '<div class="quote"> <em>Originariamente scritto da: kappa</em></br>eoi messaggiusu coddais&igrave;</div>\n\na mimm&#039;oh???', 3, 10),
(109, '2015-09-28 21:38:55', 'ztc io volevo andare :(', 3, 7),
(110, '2015-09-28 21:41:43', 'seisi arrobball&#039;a gallera, CHIUDO', 3, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `eta` int(11) DEFAULT NULL,
  `sesso` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `ruolo` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `password`, `eta`, `sesso`, `email`, `citta`, `ruolo`) VALUES
(1, 'mirko', 'fadda', 24, 'uomo', 'ciao@live.it', 'Las Vegas', 1),
(2, 'Sharon', 'carta', 28, 'donna', 'salve@gmail.com', 'San Gavino Monreale', 1),
(6, 'ricky', 'cioko', 25, 'uomo', 'oroCiok@live.net', 'Porpoli', 2),
(7, 'pietro', 'ruspa', 25, 'uomo', 'paolo90@ashavin.it', 'Cagliari', 2),
(8, 'kekko', 'cappai', 25, 'uomo', 'frillo@gmail.com', 'Cagliari', 2),
(9, 'fabio', 'biori', 26, 'uomo', 'bio@tiscali.it', 'Serrenti', 2),
(10, 'Michael', 'pinna', 34, 'uomo', 'pinna91@hotmail.it', 'Sidney', 2),
(11, 'Andrea', 'zonca', 10, 'uomo', 'zonca@live.com', 'Porpoli', 2),
(18, 'RobyCorda', 'roby', 10, 'uomo', 'we@gmail.it', 'Detroit', 2),
(20, 'kappa', 'ortu', 26, 'uomo', 'kappa@live.it', 'Samassi', 2);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `discussioni`
--
ALTER TABLE `discussioni`
  ADD CONSTRAINT `discussioni_ibfk_1` FOREIGN KEY (`creatore_id`) REFERENCES `utenti` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `discussioni_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorie` (`id`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`discussione_id`) REFERENCES `discussioni` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`creatore_id`) REFERENCES `utenti` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
