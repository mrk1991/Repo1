<?php

include_once("php/controller/ControllerBase.php");
include_once("php/controller/ControllerLogin.php");
include_once("php/controller/ControllerForum.php");
include_once("php/model/Utente.php");

ControllerGenerico::smista($_REQUEST);

/**
    Questa classe permette di gestire il punto unico d'accesso all'applicazione.
*/
class ControllerGenerico{
    
    /**
        Tramite questo metodo e' possibile smistare le varie richieste agli opportuni controller.
    */
    public static function smista(&$request){
        
        session_start(); //inizializza la sessione
        
        if(isset($_SESSION['loggedIn'])){ //verifica se c'è un utente loggato
            $ruolo = Utente::caricaRuolo($_SESSION['userLogged']); //se c'è, verifica quale sia il suo attuale ruolo nel database
            if(!$ruolo) //se la verifica fallisce, l'utente dovrà loggarsi nuovamente
                $request['page'] = 'logout';
            else{ /*altrimenti si verifica se il suo ruolo è sempre lo stesso rispetto al momento in cui ha effettuato il login (potrebbe essere
                    stato modificato da un amministratore)*/
                if($ruolo == Utente::Bannato) //se l'utente è stato bannato si effettua immediatamente il logout
                    $request['page'] = 'logout';
                else if($ruolo != $_SESSION['userRole']) //se il ruolo è cambiato
                    $_SESSION['userRole'] = $ruolo; //si aggiorna la relativa informazione di sessione
            }
        }
        
        $pagina = isset($request['page']) ? $request['page'] : 'home'; /*se $request['page'] risulta true allora $pagina = $request['page',
		                                                                 altrimenti $pagina = 'home'*/
        switch($pagina){
            case 'home':
            case 'articoli':
            case 'strumenti':
            case 'link':
                $controllo = new ControllerBase();
                $controllo->gestisciOperazioni($request);
                break;
            case 'forum':
                $controllo = new ControllerForum();
                $controllo->gestisciOperazioni($request);
                break;
            case 'login':
            case 'registrazione':
            case 'logout':
                $controllo = new ControllerLogin();
                $controllo->gestisciOperazioni($request);
                break;
            default:
                include("php/view/contenutoNonTrovato.php"); //carica la pagina di errore per la pagina non trovata
                break;
        }
    }
}
