<?php

include_once("php/model/Database.php");
include_once("php/model/Utente.php");
include_once("php/model/Categoria.php");
include_once("php/model/Discussione.php");
include_once("php/model/Post.php");

/**
    Questa classe permette di gestire le richieste inerenti al forum del sito.
*/
class ControllerForum extends ControllerBase{

    public function gestisciOperazioni(&$request){
        
        $vista = ImpostaPagina::creaIstanza();
        
        if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false){ //se non si è loggati si viene rimandati alla pagina di login
            header("Location: index.php?page=login"); //redirect verso la pagina di login
            exit(); //esce in modo da non generare altro codice non inerente al reindirizzamento, come la include della master page
        }
        
        if(isset($request['subpage'])){ //se è stata richiesta una sottopagina del forum la si visualizza
            switch($request['subpage']){
                case 'listaUtenti':
                    if($_SESSION['userRole'] == Utente::Amministratore){ //accedono alla pagina solo gli amministratori
                        $listaUtenti = $this->mostraListaUtenti($vista); /*permette di visualizzare la pagina e carica anche la lista degli
                                                                           utenti registrati sul sito*/
                        $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                        sidebar. $listaCategorie è un array con tutte le categorie salvate nel
                                                                        database*/
                    } else{ //se non si è amministratori
                        include("php/view/accessoNegato.php"); //includo la pagina di accesso negato
                        exit(); //esce in modo da evitare l'inclusione della master page che genererebbe un errore
                    }
                    break;
                case 'cambiaRuolo_Banna':
                    if($_SESSION['userRole'] == Utente::Amministratore){ //accedono alla pagina solo gli amministratori
                        $listaUtenti = $this->mostraCambiaRuoloBanna($vista); /*permette di visualizzare la pagina e carica anche la lista degli
                                                                                utenti registrati sul sito*/
                        $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                        sidebar. $listaCategorie è un array con tutte le categorie salvate nel
                                                                        database*/
                    } else{ //se non si è amministratori
                        include("php/view/accessoNegato.php"); //includo la pagina di accesso negato
                        exit(); //esce in modo da evitare l'inclusione della master page che genererebbe un errore
                    }
                    break;
                case 'categoria':
                    if(isset($request['submit-newdisc'])){ //verifica se è stato premuto il pulsante "Nuova discussione"
                        $id_categoria = $request['idCategoria']; //variabile che verrà utilizzata per la creazione della discussione
                        $nome_categoria = $request['nomeCategoria']; //variabile utilizzata per la compilazione della pagina
                        $this->mostraCreaDiscussione($vista); //mostra la pagina relativa alla creazione di una nuova discussione
                        $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                        sidebar. $listaCategorie è un array con tutte le categorie salvate nel
                                                                        database*/
                    } else{ //se non è stato premuto il pulsante "Nuova discussione"
                        if(!isset($request['id'])){ //se non è stato specificato l'id della categoria da visualizzare...
                            include("php/view/contenutoNonTrovato.php"); //...carica la pagina di errore per pagina non trovata
                            exit(); //esce per evitare l'inclusione della master page che darebbe un errore
                        } else{ //altrimenti visualizza la categoria richiesta
                            $categoria = $this->mostraCategoria($vista, $request['id']); /*permette di visualizzare la pagina e carica anche la
                                                                                           lista delle discussioni inerenti alla categoria
                                                                                           richiesta*/
                            if(!$categoria){ /*se categoria vale null o false, significa o che si è verificato un errore in fase di caricamento,
                                               oppure che non esiste una categoria con l'id specificato*/
                                include("php/view/contenutoNonTrovato.php"); //carica la pagina di errore per pagina non trovata
                                exit(); //esce per evitare l'inclusione della master page che darebbe un errore
                            }
                            $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                            sidebar. $listaCategorie è un array con tutte le categorie salvate
                                                                            nel database*/
                        }
                    }
                    break;
                case 'discussione':
                    //verifica se è stato premuto il tasto "Rispondi" o "Rispondi quotando" per poter scrivere un post
                    if(isset($request['submit-reply']) || isset($request['submit-repQuote'])){ 
                        $id_discussione = $request['id_discussione']; //variabile che verrà utilizzata per la creazione del post
                        $titolo_discussione = $request['titolo_discussione']; //variabile utilizzata per la compilazione della pagina
                        if(isset($request['submit-repQuote'])){ /*nel caso in cui si sia scleto "Rispondi quotando" occorre impostare il testo
                                                                  del post che si vuole quotare*/
                            $nome_utente = $request['nome_utente']; //$nome_utente contiene il nome dell'utente che ha scritto il post da quotare
                            $testo = $request['testo']; //$testo contiene il testo del post
                            $mod1 = explode('<div class="quote">', $testo); //rimuove la prima parte della vecchia quotatura qualora ci sia
                            if(isset($mod1[1])){ //se era presente una vecchia quotatura
                                $mod2 = explode('</div>', $mod1[1]); //rimuove la seconda parte della vecchia quotatura
                                $testo = $mod2[1]; //salva la stringa in $testo
                                $testo = trim($testo); //elimina gli spazi dalla stringa
                            }
                        }
                        $this->mostraCreaPost($vista); //mostra la pagina relativa alla creazione di un post
                        $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                        sidebar. $listaCategorie è un array con tutte le categorie salvate
                                                                        nel database*/
                    } else{ //se non si è premuto su uno dei due tasti per rispondere
                        if(!isset($request['id'])){ //se non è stato specificato l'id della discussione da visualizzare
                            include("php/view/contenutoNonTrovato.php"); //carica la pagina di errore per pagina non trovata
                            exit(); //esce per evitare l'inclusione della master page che darebbe un errore
                        } else{ //altrimenti visualizza la discussione
                            $discussione = $this->mostraDiscussione($vista, $request['id']);
                            if(!$discussione){ /*se discussione vale null o false, significa o che si è verificato un errore in fase di
                                                 caricamento, oppure che non esiste una discussione con l'id specificato*/
                                include("php/view/contenutoNonTrovato.php"); //carica la pagina di errore per pagina non trovata
                                exit(); //esce per evitare l'inclusione della master page che darebbe un errore
                            }
                            $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                            sidebar. $listaCategorie è un array con tutte le categorie salvate
                                                                            nel database*/
                        }
                    }
                    break;
                default: //in caso la sottopagina richiesta abbia un nome diverso da quelli presenti nei case sopra
                    include("php/view/contenutoNonTrovato.php"); //carica la pagina di errore per pagina non trovata
                    exit(); //esce per evitare l'inclusione della master page che darebbe un errore
            }
        } else{ //altrimenti se non si è richiesta una sottopagina si deve visualizzare la home in base all'utente che utilizza il forum
            switch($_SESSION['userRole']){ //verifica qual'è il tipo di utente che sta accedendo al forum
                case Utente::User: //se è un utente generico
                    //mostra la sezione "Regolamento" del forum
                    $categoria = $this->mostraCategoria($vista, 1); /*permette di visualizzare la pagina e carica anche la lista delle
                                                                      discussioni inerenti alla categoria richiesta. 1 è l'id della categoria
                                                                      "Regolamento" presente di default sul sito*/
                    $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                    sidebar. $listaCategorie è un array con tutte le categorie salvate
                                                                    nel database*/
                    break;
                case Utente::Amministratore: //se è un amministratore
                    $this->mostraHomeAmministratore($vista); /*setta la vista per visualizzare nel content del forum la home
                                                               dell'amministratore.*/
                    $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                    sidebar. $listaCategorie è un array con tutte le categorie salvate
                                                                    nel database*/
                    break;
                default: //se l'utente per qualche motivo non appartiene a una delle due categorie sopra
                    include("php/view/accessoNegato.php"); //si mostra la pagina d'errore che indica l'accesso negato
                    exit(); //esce per evitare l'inclusione della master page che darebbe un errore
            }
        }
        
        if(isset($request['azione'])){
            switch($request['azione']){
                case 'addCategory':
                    if($_SESSION['userRole'] == Utente::Amministratore){ //solo un amministratore può eseguire quest'azione
                        if(isset($request['validazione'])){ /*se $request['validazione'] non è null significa che ho ricevuto una richiesta
                                                              ajax*/
                            $errore = ""; /*variabile utilizzata per salvare eventuali messaggi d'errore durante l'inserimento di una
                                            categoria*/
                            $conferma = ""; /*variabile utilizzata per salvare eventuali messaggi di conferma durante l'inserimento di una
                                              categoria*/
                            $categoria = new Categoria();
                            $categoria->setNome($request['nomeCategoria']);
                            $risultato = $categoria->cercaPerNome(); //cerca se nel database esiste già una categoria con quel nome
                            if(!isset($risultato)){ //errore con il database
                                $errore = "Si è verificato un errore";
                            } else if($risultato)
                                    $errore = "La categoria inserita esiste già";
                                else{
                                    if(!$categoria->salvaCategoria()) /*salva la categoria nel database. Se il salvataggio rende null significa
                                                                        che si è verificato un errore con il database, se rende true tutto ok*/
                                        $errore = "Si è verificato un errore";
                                    else $conferma = "Categoria inserita correttamente";
                                }
                            $ajax = true; //la variabile $ajax ha il compito di informare la master page della richiesta ajax
                            $vista->setContent("php/view/json-content.php"); //si imposta solo il content della pagina con il json
                        }
                    } else{ //se non si è amministratore
                        include("php/view/accessoNegato.php"); //si mostra la pagina d'errore che indica l'accesso negato
                        exit(); //esce per evitare l'inclusione della master page che darebbe un errore
                    }
                    break;
                case 'cambiaRuolo':
                    if($_SESSION['userRole'] == Utente::Amministratore){ //solo un amministratore può eseguire quest'azione
                        Utente::modificaRuoloUtente($request['utente'], $request['ruolo']); //invoca il metodo per cambiare il ruolo all'utente
                        $listaUtenti = $this->mostraCambiaRuoloBanna($vista); //riporta alla pagina dove si può modificare il ruolo di un utente
                        $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                        sidebar. $listaCategorie è un array con tutte le categorie salvate
                                                                        nel database*/
                    } else{ //se non si è amministratore
                        include("php/view/accessoNegato.php"); //si mostra la pagina d'errore che indica l'accesso negato
                        exit(); //esce per evitare l'inclusione della master page che darebbe un errore
                    }
                    break;
                case 'banna': //banna utente
                    if($_SESSION['userRole'] == Utente::Amministratore){ //solo un amministratore può eseguire quest'azione
                        Utente::modificaRuoloUtente($request['utente'], Utente::Bannato); //invoca il metodo per cambiare il ruolo all'utente
                        $listaUtenti = $this->mostraCambiaRuoloBanna($vista); //riporta alla pagina dove si può modificare il ruolo di un utente
                        $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                        sidebar. $listaCategorie è un array con tutte le categorie salvate
                                                                        nel database*/
                    } else{ //se non si è amministratore
                        include("php/view/accessoNegato.php"); //si mostra la pagina d'errore che indica l'accesso negato
                        exit();  //esce per evitare l'inclusione della master page che darebbe un errore
                    }
                    break;
                case 'sblocca': //rimuove ban
                    if($_SESSION['userRole'] == Utente::Amministratore){ //solo un amministratore può eseguire quest'azione
                        Utente::modificaRuoloUtente($request['utente'], Utente::User); //invoca il metodo per cambiare il ruolo all'utente
                        $listaUtenti = $this->mostraCambiaRuoloBanna($vista); //riporta alla pagina dove si può modificare il ruolo di un utente
                        $listaCategorie = $this->mostraForum($vista); /*permette di visualizzare le restanti parti del forum cioè header e
                                                                        sidebar. $listaCategorie è un array con tutte le categorie salvate
                                                                        nel database*/
                    } else{ //se non si è amministratore
                        include("php/view/accessoNegato.php"); //si mostra la pagina d'errore che indica l'accesso negato
                        exit(); //esce per evitare l'inclusione della master page che darebbe un errore
                    }
                    break;
                case 'crea_discussione':
                    if(isset($request['validazione'])){ //se $request['validazione'] non è null significa che ho ricevuto una richiesta ajax
                        $errore = ""; /*variabile utilizzata per salvare eventuali messaggi d'errore durante l'inserimento di una nuova
                                        discussione*/
                        $conferma = ""; /*variabile utilizzata per salvare eventuali messaggi di conferma durante l'inserimento di una nuova
                                          discussione*/
                        $discussione = new Discussione();
                        $discussione->setTitolo($request['titolo']);
                        $discussione->setIdCategoria($request['id_categoria']);
                        $risultato = $discussione->cercaPerTitoloECategoria(); /*cerca se nel database ci sono altre discussioni appartenenti
                                                                                 alla stessa categoria e con lo stesso titolo*/
                        if(!isset($risultato)){ //errore con l'utilizzo del database
                            $errore = "Si è verificato un errore";
                        } else if($risultato){ //discussione già presente nel database
                                $errore = "Questa discussione esiste già";
                            } else{
                                $discussione = Discussione::creaDiscussioneDaArray($request); //crea un'istanza di tipo Discussione
                                /*sostituisce nel testo scritto dall'utente le html entities quando necessario e permette di non convertire
                                  eventuali tag html presenti*/
                                $request['post'] = htmlspecialchars_decode(htmlentities($request['post'], ENT_QUOTES, 'UTF-8'), ENT_NOQUOTES);
                                $request['post'] = str_replace('&quot;', "\"", $request['post']); /*sostituisce la conversione degli
                                                                                                    apici doppi con il relativo simbolo.
                                                                                                    In questo modo viene correttamente
                                                                                                    riconosciuta la classe del div che
                                                                                                    contiene un eventuale quotatura*/
                                $post = Post::creaPostDaArray($request);
                                if(!$discussione->salvaDiscussione($post)) //salva la discussione sul database e verifica il risultato
                                    $errore = "Si è verificato un errore"; //la discussione non è  stata salvata
                                else $conferma = "Discussione creata con successo";
                            }
                        $ajax = true; //la variabile $ajax ha il compito di informare la master page della richiesta ajax
                        $vista->setContent("php/view/json-content.php"); //si imposta solo il content della pagina con il json
                    }
                    break;
                case 'elimina_discussione':
                    if($_SESSION['userRole'] == Utente::Amministratore){ //solo un amministratore può eseguire quest'azione
                        if(isset($request['validazione'])){ //se $request['validazione'] non è null significa che ho ricevuto una richiesta ajax
                            $errore = ""; /*variabile utilizzata per salvare eventuali messaggi d'errore durante l'eliminazione di una
                                            discussione*/
                            $conferma = ""; /*variabile utilizzata per salvare eventuali messaggi di conferma durante l'eliminazione di una
                                              discussione*/
                            $discussione = Discussione::caricaDiscussione($request['id']); //carica la discussione con quel particolare id
                                                                                             
                            if(!isset($discussione)){ //non è stato possibile caricare la discussione
                                $errore = "Si è verificato un errore";
                            } else if($discussione == false){
                                    $errore = "Discussione non trovata";
                                } else{
                                    $discussione->setListaPost(Post::caricaElencoPost($request['id'])); //carica i post inerenti alla discussione
                                    if($discussione->eliminaDiscussione()) //invoca il metodo per eliminare la discussione
                                        $conferma = "Discussione eliminata con successo";
                                    else $errore = "Si è verificato un errore";
                                }
                            $ajax = true; //la variabile $ajax ha il compito di informare la master page della richiesta ajax
                            $vista->setContent("php/view/json-content.php"); //si imposta solo il content della pagina con il json
                        }
                    } else{ //se non si è amministratori
                        include("php/view/accessoNegato.php"); //viene visualizzata la pagina d'errore che indica accesso negato
                        exit(); //esce per evitare l'inclusione della master page che genererebbe un errore
                    }
                    break;
                case 'crea_post':
                    if(isset($request['validazione'])){ /*se $request['validazione'] non è null significa che ho ricevuto una
                                                          richiesta ajax*/
                        $errore = ""; /*variabile utilizzata per salvare eventuali messaggi d'errore durante l'inserimento di un
                                        nuovo post*/
                        $conferma = ""; /*variabile utilizzata per salvare eventuali messaggi di conferma durante l'inserimento
                                          di un nuovo post*/
                        /*sostituisce nel testo scritto dall'utente le html entities quando necessario e permette di non convertire eventuali
                          tag html presenti*/
                        $request['post'] = htmlspecialchars_decode(htmlentities($request['post'], ENT_QUOTES, 'UTF-8'), ENT_NOQUOTES);
                        $request['post'] = str_replace('&quot;', "\"", $request['post']); /*sostituisce la conversione degli apici doppi con il
                                                                                            relativo simbolo. In questo modo viene correttamente
                                                                                            riconosciuta la classe del div che contiene un
                                                                                            eventuale quotatura*/
                        $post = Post::creaPostDaArray($request);
                        if(!$post->salvaPost()) //invoca il metodo per il salvataggio del post
                           $errore = "Si è verificato un errore";
                        else $conferma = "Post inserito correttamente";
                                       
                        $ajax = true; //la variabile $ajax ha il compito di informare la master page della richiesta ajax
                        $vista->setContent("php/view/json-content.php"); //si imposta solo il content della pagina con il json 
                    }
                    break;
                case 'elimina_post':
                    if($_SESSION['userRole'] == Utente::Amministratore){ //solo un amministratore può eseguire quest'azione
                        if(isset($request['validazione'])){ //se $request['validazione'] non è null significa che ho ricevuto una richiesta ajax
                            $errore = ""; //variabile utilizzata per salvare eventuali messaggi d'errore durante l'eliminazione di un post
                            $conferma = ""; //variabile utilizzata per salvare eventuali messaggi di conferma durante l'eliminazione di un post
                            $post = new Post();
                            $post->setId($request['id']);
                            if(!$post->eliminaPost()) //invoca il metodo per l'eliminazione di un post avente un particolare id
                                $errore = "Si è verificato un errore";
                            else $conferma = "Post eliminato con successo";
                            $ajax = true; //la variabile $ajax ha il compito di informare la master page della richiesta ajax
                            $vista->setContent("php/view/json-content.php"); //si imposta solo il content della pagina con il json
                        }
                    } else{ //se non si è amministratore
                        include("php/view/accessoNegato.php"); //viene mostrata la pagina d'errore indcante accesso negato
                        exit(); //esce per evitare l'inclusione della master page che genererebbe un errore
                    }
                    break;
                default: //se si richiede un'azione diversa da quelle su elencate
                    include("php/view/contenutoNonTrovato.php"); //si visualizza la pagina d'errore per pagina non trovata
                    exit(); //esce per evitare l'iclusione della master page che genererebbe un errore
            }
        }
        
        include ("php/view/master.php"); //includo la masterPage per poter visualizzare la pagina richiesta
    }
    
    
    /**
        Questo metodo permette di visualizzare la pagina contenente il form per la creazione di un post.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
    */
    protected function mostraCreaPost($vista){
	    $vista->setContent("php/view/forum/crea-post.php");
	}
	
    /**
        Questo metodo permette di visualizzare la pagina contenente il form per la creazione di una nuova discussione.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
    */
    protected function mostraCreaDiscussione($vista){
	    $vista->setContent("php/view/forum/crea-discussione.php");
	}
	
    /**
	    Questo metodo permette di visualizzare la pagina contenente la lista dei post inerenti alla discussione scelta.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
        @param $id indica l'id della discussione di cui si vogliono visualizzare i post.
        @return la discussione richiesta.
	*/
	protected function mostraDiscussione(ImpostaPagina $vista, $id){
	    $discussione = Discussione::caricaDiscussione($id);
	    if($discussione) //se $discussione è null si è verificato un errore, mentre se è false significa che non è stata trovata sul database
	        $discussione->setListaPost(Post::caricaElencoPost($id));
	    $vista->setContent("php/view/forum/discussione-content.php");
	    return $discussione;
	}
	
	/**
        Questo metodo permette di visualizzare la pagina contenente la lista delle discussioni inerenti alla categoria scelta.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
        @param $id indica l'id della categoria di cui si vogliono visualizzare le discussioni.
        @return la categoria richiesta.
    */
	protected function mostraCategoria(ImpostaPagina $vista, $id){
	    $categoria = Categoria::caricaCategoria($id);
	    if($categoria) //se $categoria è null si è verificato un errore, mentre se è false significa che non è stata trovata sul database
            $categoria->setListaDiscussioni(Discussione::caricaElencoDiscussioni($id));
        $vista->setContent("php/view/forum/categoria-content.php");
        return $categoria;
    }
    
    /**
        Questo metodo esegue il caricamento della lista degli utenti registrati sul sito e setta la pagina che permette a un amministratore di
        cambiare il ruolo di un utente, di bannarlo oppure di rimuovere il ban.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
        @return la lista degli utenti registrati sul forum.
    */
    protected function mostraCambiaRuoloBanna($vista){
        $vista->setContent("php/view/forum/cambiaRuolo-content.php");
        return Utente::caricaElencoUtenti(); /*carica la lista degli utenti registrati sul sito in modo che sia visualizzabile
                                               dall'amministratore*/
    }
    
    /**
        Questo metodo esegue il caricamento della lista degli utenti registrati sul sito e setta il content della pagina per visualizzarla.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
        @return la lista degli utenti registrati sul forum.
    */
    protected function mostraListaUtenti(ImpostaPagina $vista){
        $vista->setContent("php/view/forum/listaUtenti-content.php");
        return Utente::caricaElencoUtenti(); /*carica la lista degli utenti registrati sul sito in modo che sia visualizzabile
                                               dall'amministratore*/
    }
    
    /**
        Questo metodo permette di visualizzare la home del forum per un amministratore, che equivale alla lista delle operazioni speciali che può
        eseguire.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
    */
	protected function mostraHomeAmministratore(ImpostaPagina $vista){
	    $vista->setContent("php/view/forum/amm-content.php");
	    
	}
	
    /**
        Questo metodo permette di visualizzare le parti del forum comuni a tutti gli utenti. Permette inoltre di caricare la lista delle
        categorie di discussione presenti sul database.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
        @retun la lista delle categorie.
    */
    protected function mostraForum(ImpostaPagina $vista){
        $vista->setTitolo("Forum");
	    $vista->setHeader("php/view/forum/header.php");
	    $vista->setSidebar("php/view/forum/sidebar.php");
	    return Categoria::caricaElencoCategorie(); /*carica la lista delle categorie registrate sul sito in modo che siano visualizzabili nella
	                                              // sidebar*/
    }
}

?>
