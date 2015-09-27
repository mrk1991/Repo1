<?php

include_once("php/model/Database.php");
include_once("php/model/Utente.php");

/**
    Questa classe permette di gestire le operazioni di registrazione, login e logout del sito. 
*/
class ControllerLogin extends ControllerBase{

    public function gestisciOperazioni(&$request){
        
        $pagina = $request['page'];
        
        $vista = ImpostaPagina::creaIstanza();
        
        switch($pagina){
            case 'login':
                if(!isset($_SESSION['loggedIn'])){ //si può accedere solo se non si è già loggati
                    if(isset($request['validazione'])){ //se $request['validazione'] non è null significa che ho ricevuto una richiesta ajax
                        $errore = ""; //variabile utilizzata per salvare eventuali messaggi d'errore durante il login
                        $conferma = ""; //variabile utilizzata per salvare eventuali messaggi di conferma durante il login 
                        $username = $request['username']; //imposta nella variabile $username il nome utente inserito
                        $password = $request['password']; //imposta nella variabile $password la password inserita
                        $utente = $this->login($username, $password); /*richiama il metodo che effettua il login. La variabile $utente
                                                                        conterrà l'istanza che rappresenta l'utente che si è loggato*/
                        if(!isset($utente)){ //se la variabile $utente è null significa che si è verificato un errore con il database
                            $errore = "Si è verificato un errore durante il login";
                        } else if($utente == false){ /*se la variabile $utente è false significa che le credenziali inserite per il login non
                                                       hanno generato risultati nel database*/
                                $errore = "Nome utente o password non corretti";
                            } else if($utente->getRuolo() == Utente::Bannato){ /*se l'utente che sta cercando di loggarsi è stato bannato, il
                                                                                 login gli viene impedito*/
                                    $errore = "Sei stato bannato";
                                } else{ //se tutti i controlli vanno a buon fine, l'utente si può loggare
                                        $_SESSION['loggedIn'] = true;
                                        $_SESSION['userId'] = $utente->getId();
                                        $_SESSION['userLogged'] = $utente->getUsername();
                                        $_SESSION['userRole'] = $utente->getRuolo();
                                        $conferma = "Login effettuato con successo.";
                                    }
                        $ajax = true; //la variabile $ajax ha il compito di informare la master page della richiesta ajax
                        $vista->setContent("php/view/json-content.php"); //si imposta solo il content della pagina con il json
                    } else{ //se non è stata ricevuta una richiesta ajax viene visualizzata la pagina normale con il form per loggarsi
                        $this->mostraPaginaLogin($vista); /*visualizza la pagina del login. Questa istruzione viene eseguita solo quando si
                                                            cerca di entrare nella pagina del forum senza essersi loggati*/
                    }
                } else{ //se si cerca di accedere alla pagina di login essendo già loggati viene mostrata una pagina d'errore
                    include("php/view/accessoNonConsentito.php"); //visualizza la pagina d'errore
                    exit(); //esce per evitare che venga richiamata la master page
                }
                break;
            case 'registrazione':
                if(!isset($_SESSION['loggedIn'])){ //si può accedere solo se non si è già loggati
                    if(isset($request['validazione'])){ //se $request['validazione'] non è null significa che ho ricevuto una richiesta ajax
                        $errore = ""; //variabile utilizzata per salvare eventuali messaggi d'errore durante la registrazione
                        $conferma = ""; //variabile utilizzata per salvare eventuali messaggi di conferma durante la registrazione
                        $utente = new Utente();
                        $utente->setUsername($request['username']);
                        $utente->setEmail($request['email']);
                        $risultato = $utente->cercaPerUsername(); //verifica se nel database esiste già un utente con lo stesso username
                        if(!isset($risultato)){ //errore con il database
                            $errore = "Si è verificato un errore";
                        } else if($risultato){
                                $errore = "Lo username inserito risulta già in uso";
                            } else{
                                $risultato = $utente->cercaPerEmail(); /*verifica se nel database esiste già un utente registrato con una certa
                                                                         email*/
                                if(!isset($risultato)){ //errore con il database
                                    $errore = "Si è verificato un errore";
                                } else if($risultato){
                                        $errore = "L'e-mail inserita risulta già registrata";
                                    } else{
                                            $request['ruolo'] = Utente::User; //tutti i nuovi utenti vengono registrati come utenti generici
                                            //verifica che l'utente abbia inserito un numero nel campo Età del form
                                            if(!filter_var($request['eta'], FILTER_VALIDATE_INT)){
                                                $errore = "Inserisci un valore numerico nel campo età";
                                            } else if(!($request['eta'] <= 150 && $request['eta'] >= 10)){ /*verifica che l'età per registrarsi
                                                                                                             al sito sia compresa tra 10 e 150
                                                                                                             anni*/
                                                $errore = "La tua età non rispetta i limiti previsti dal forum";
                                            } else{
                                                $utente = Utente::creaUtenteDaArray($request); /*partendo dai dati raccolti tramite il form,
                                                                                                viene creata un'istanza di tipo Utente che
                                                                                                rappresenta l'utente da registrare*/
                                                if(!isset($utente)){ /*se la variabile $utente è null significa che nel form sono stati inseriti 
                                                                       dati non validi*/
                                                    $errore = "E-mail non valida";
                                                } else{ //avendo superato tutti i controlli si può procedere con la vera registrazione
                                                    if($this->registra($utente)){ //richiama funzione di registrazione. Se rende true è tutto ok
                                                        $conferma = "Registrazione avvenuta con successo";
                                                    } else{
                                                        $errore = "Si è verificato un errore durante la registrazione";
                                                    }
                                                }
                                            }
                                        }
                                }
                        $ajax = true; //la variabile $ajax ha il compito di informare la master page della richiesta ajax
                        $vista->setContent("php/view/json-content.php"); //si imposta solo il content della pagina con il json
                    } else{ //se non è stata ricevuta una richiesta ajax viene visualizzata la pagina normale con il form per registrarsi
                            $this->mostraPaginaRegistrazione($vista); //compila i campi necessari alla master page per visualizzare il form
                    } 
                } else{ //se si cerca di accedere alla pagina di registrazione essendo loggati, viene mostrata una pagina d'errore
                    include("php/view/accessoNonConsentito.php"); //visualizza la pagina d'errore
                    exit(); //esce per evitare che venga richiamata la master page
                }
                break;
            case 'logout':
                $this->logout(); //richiama il metodo per poter effettuare il logout
                $this->mostraPaginaLogin($vista); //visualizza la pagina del login
                break;
        }
        
        include "php/view/master.php"; //includo la masterPage per poter visualizzare la pagina richiesta
        
    }
    
    /**
        Questo metodo permette di effettuare il login.
        @param $username indica il nome utente digitato dall'utente che vuole loggarsi.
        @param $password indica la password inserita dall'utente che vuole loggarsi.
        @return l'utente loggato.
    */
    protected function login($username, $password){
        return Utente::caricaUtente($username, $password);
    }
    
    /**
        Questo metodo permette di effettuare il logout.
    */
    protected function logout(){
        $_SESSION = array(); //reset dell'array $_SESSION che contine i dati della sessione
        //terminazione validità del cookie con l'id di sessione
        if(session_id() != "" || isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time() - 2592000, '/'); //imposta il termine della validità del cookie al mese scorso
        session_destroy(); //distrugge il file di sessione
    }
    
    /**
        Questo metodo permette di effettuare la registrazione.
        @param $user indica un istanza della classe Utente che rappresenti l'utente da registrare.
        @return true se la registrazione ha esito positivo, null altrimenti.
    */
    protected function registra(Utente $user){
        return $user->salvaUtente();
    }
    
    /**
        Questo metodo permette di visualizzare la pagina per il login.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
    */
    protected function mostraPaginaLogin(ImpostaPagina $vista){
		$vista->setTitolo("Login");
		$vista->setHeader("php/view/login/header.php");
		$vista->setSidebar("php/view/login/sidebar.php");
		$vista->setContent("php/view/login/content.php");
    }
    
    /**
        Questo metodo permette di visualizzare la pagina per effettuare la registrazione.
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
    */
    protected function mostraPaginaRegistrazione(ImpostaPagina $vista){
        $vista->setTitolo("Registrazione");
		$vista->setHeader("php/view/registrazione/header.php");
		$vista->setSidebar("php/view/registrazione/sidebar.php");
		$vista->setContent("php/view/registrazione/content.php");
    }
    
}
?>
