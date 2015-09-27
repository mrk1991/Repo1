<?php

include("php/Settings.php");

/**
    Questa classe fornisce i metodi per accedere a un database.
*/
class Database{

    private $database; //attributo che rappresenta un oggetto di tipo database
    
    /**
        Costruttore privato in modo da poter creare un solo esemplare di database. Cosi facendo si accede al database sempre tramite la stessa
        istanza.
    */
    private function _construct(){
    
    }
    
    /**
        Permette di creare un'istanza del tipo Database qualora essa non sia gia' stata creata.
        @return l'istanza di tipo Database.
    */
    public static function caricaDatabase(){
        if(!isset($database)){ //se la variabile $database non è stata ancora settata...
            $database = new Database(); //...viene creata l'istanza di tipo database
        }
        
        return $database; //rende un'istanza di tipo database
    }
    
    /**
        Effettua l'accesso al database.
        @return null in caso di errore.
        @return Il client con cui si è effettuato l'accesso al database.
    */
    public function connetti(){
        $client = new mysqli(); //istanzia un oggetto della classe mysqli
        $client->connect(Settings::$db_host, Settings::$db_user, Settings::$db_pass, Settings::$db_name); /*se non ci sono stati errori, ora
                                                                                                            $client è un client connesso al
                                                                                                            database*/
        //verifica la presenza di errori in fase di connessione
        if($client->connect_errno != 0)
            return null; //si è verificato un errore e quindi non si rende nessun client
        else return $client; //altrimenti si rende il client
    }
}

?>
