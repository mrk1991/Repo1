<?php

/**
    Questa classe rappresenta un utente.
*/
class Utente{
	
	private $id; //indica l'id con cui l'utente è salvato sul database
	private $username; //username utente
	private $password; //password utente
	private $eta; //età utente
	private $sesso; //sesso utente
	private $email; //email utente
	private $citta; //citttà utente
	private $ruolo; //ruolo utente
	
	/**
	    Queste costanti rappresentano i possibili ruoli che un utente può assumere.
	*/
	const Amministratore = 1;
	const User = 2;
	const Bannato = 3;
	
	/**
	    Costruisce un'istanza vuota del tipo Utente.
	*/
	public function _construct(){
	
	}
	
	/**
	    Rende l'id utente.
	    @return l'id.
	*/
	public function getId(){
	    return $this->id;
	}
	
	/**
	    Imposta l'id che l'utente possiede sul database.
	    @param $id indica l'id da impostare.
	*/
	public function setId($id){
	    if(filter_var($id, FILTER_VALIDATE_INT)){
            //valore id valido
            $this->id = $id;
        }
	}
	
	/**
	    Rende lo username dell'utente.
	    @return lo username.
	*/
	public function getUsername(){
		return $this->username;	
	}
	
	/**
	    Imposta lo username dell'utente.
	    @param $username indica lo username da impostare.
	*/
	public function setUsername($username){
		$this->username = $username;
	}
	
	/**
	    Rende la password dell'utente.
	    @return la password.
	*/
	public function getPassword(){
		return $this->password;
	}
	
	/**
	    Imposta la password dell'utente.
	    @param $password indica la password da impostare.
	*/
	public function setPassword($password){
		$this->password = $password;
	}
	
	/**
	    Rende l'eta' dell'utente.
	    @return l'eta'.
	*/
	public function getEta(){
        return $this->eta;
    }
    
    /**
	    Imposta l'eta' dell'utente.
	    @param $eta indica l'eta' da impostare.
	    @return false se il valore non è valido, true altrimenti.
	*/
	public function setEta($eta){
        if(filter_var($eta, FILTER_VALIDATE_INT)){
            //valore di $eta valido
            $this->eta = $eta;
            return true;
        } else return false; //valore di $eta non valido
    }
    
    /**
	    Rende il sesso dell'utente.
	    @return il sesso.
	*/
    public function getSesso(){
        return $this->sesso;
    }
    
    /**
	    Imposta il sesso dell'utente.
	    @param $sesso indica il sesso da impostare.
	*/
    public function setSesso($sesso){
        $this->sesso = $sesso;
    }
    
    /**
	    Rende l'e-mail dell'utente.
	    @return l'e-mail.
	*/
    public function getEmail(){
        return $this->email;
    }
    
    /**
	    Imposta l'e-mail dell'utente.
	    @param $email indica l'e-mail da impostare.
	    @return true se il valore è valido, falso altrimenti.
	*/
    public function setEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            //valore di $email valido
            $this->email = $email;
            return true;
        } else return false; //valore di $email non valido
    }
    
    /**
	    Rende la citta' dell'utente.
	    @return la citta'.
	*/
    public function getCitta() {
        return $this->citta;
    }
    
    /**
	    Imposta la citta' dell'utente.
	    @param $citta indica la citta' da impostare.
	*/
	public function setCitta($citta) {
        $this->citta = $citta;
    }
    
    /**
	    Rende il ruolo dell'utente.
	    @return il ruolo.
	*/
    public function getRuolo(){
        return $this->ruolo;
    }
    
    /**
	    Imposta il ruolo dell'utente.
	    @param $ruolo indica il ruolo da impostare.
	    @return true in caso il valore di ruolo sia corretto, false altrimenti.
	*/
    public function setRuolo($ruolo){
        switch($ruolo){
            case self::Amministratore:
            case self::User:
            case self::Bannato:
                $this->ruolo = $ruolo;
                return true; //valore di $ruolo valido
            default:
                return false;
        }
    }
    
    /**
        Permette di creare un'istanza di tipo Utente partendo da un array.
        @param $array indica l'array contenente i dati relativi a un utente.
        @return l'utente creato.
        @return null in caso di errore.
    */
    public static function creaUtenteDaArray($array){
        $utente = new Utente(); //crea istanza Utente
        
        if(isset($array['id'])){
            $utente->setId($array['id']);
        }
        $utente->setUsername($array['username']); //imposta username
        $utente->setPassword($array['password']); //imposta password
        if(!$utente->setEta($array['eta'])){ //imposta l'età
            return null; //nel caso in cui il metodo rileva che il valore dell'età non è valido, viene reso null per indicare l'errore
        }
        $utente->setSesso($array['sesso']); //imposta il sesso
        if(!$utente->setEmail($array['email'])){ //imposta l'email
            return null; //nel caso in cui il metodo rileva che l'email non è valida, viene reso null per indicare l'errore
        }
        $utente->setCitta($array['citta']); //imposta la città
        if(!$utente->setRuolo($array['ruolo'])){ //imposta il ruolo utente
            return null; //nel caso in cui il metodo rileva che il valore passato per impostare il ruolo non è valido, viene reso null
        }
        return $utente; //se non ci sono errori, rende l'utente creato
    }
    
    /**
        Permette di verificare se nel database è presente un utente con un determinato username.
        @return true se lo username e' in uso, false altrimenti.
        @return null in caso di errore.
    */
    public function cercaPerUsername(){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[cercaPerUsername] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        $query = "SELECT username FROM utenti WHERE username = ?"; //stringa che rappresenta la query da eseguire
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[cercaPerUsername] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("s", $this->getUsername())){ //collega i parametri con il loro tipo
            error_log("[cercaPerUsername] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[cercaPerUsername] Errore nell'esecuzione della query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($statement->fetch()){ //se il metodo fetch() rende true significa che la query ha generato dei risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return true;
        } else{ //se il metodo fetch() richiamato nell'if sopra rende false, significa che la query non ha generato risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return false;
        }
    }
    
    /**
        Permette di verificare se nel database esiste un utente registrato con una certa e-mail.
        @return true se l'e-mail risulta gia' registrata, false altrimenti.
        @return null in caso di errore.
    */
    public function cercaPerEmail(){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[cercaPerEmail] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        $query = "SELECT email FROM utenti WHERE email = ?"; //stringa che rappresenta la query da eseguire
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[cercaPerEmail] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("s", $this->getEmail())){ //collega i parametri con il loro tipo
            error_log("[cercaPerEmail] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[cercaPerEmail] Errore nell'esecuzione della query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($statement->fetch()){ //se il metodo fetch() rende true significa che la query ha generato dei risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return true;
        } else{ //se il metodo fetch() richiamato nell'if sopra rende false, significa che la query non ha generato risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return false;
        }
    }
    
    /**
        Permette, in base allo username, di caricare il ruolo del relativo utente direttamente dal database.
        @param $username indica lo username dell'utente di cui si vuol sapere il ruolo.
        @return il ruolo.
        @return false se la ricerca non genera risultati.
        @return null in aso d'errore con il database.
    */
    public static function caricaRuolo($username){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[caricaRuolo] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        $query = "SELECT ruolo FROM utenti WHERE username = ?"; //stringa che rappresenta la query da eseguire
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[caricaRuolo] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("s", $username)){ //collega i parametri con il loro tipo
            error_log("[caricaRuolo] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[caricaRuolo] Errore nell'esecuzione della query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_result($ruolo)){ //collega i risultati della query con i parametri espliciti passati al metodo
            error_log("[caricaRuolo] Errore nel binding dei risultati");
            return null;
        }
        
        if($statement->fetch()){ //se il metodo fetch() rende true significa che la query ha generato dei risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return $ruolo;
        } else{ //se il metodo fetch() richiamato nell'if sopra rende false, significa che la query non ha generato risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return false;
        }
    }
    
    /**
        Permette di caricare un'istanza di tipo Utente sulla base dei risultati ottenuti da una ricerca sul database.
        @param $username indica il nome utente da caricare.
        @param $password indica la password dell'utente da caricare.
        @return null in caso di errore.
        @return l'utente caricato o false se la ricerca non produce risultati.
    */
    public static function caricaUtente($username, $password){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[caricaUtente] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        $query = "SELECT id, username, password, eta, sesso, email, citta, ruolo FROM utenti WHERE username = ? AND password = ?";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[caricaUtente] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        $statement->bind_param("ss", $username, $password); //collega i parametri con il loro tipo
        if(!$statement){
            error_log("[caricaUtente] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[caricaUtente] Errore nell'esecuzione della query");
            return null;
        }
        
        $risultato = array(); //crea un array in cui verrà salvato il risultato della ricerca
        
        if(!$statement->bind_result($risultato['id'], $risultato['username'], $risultato['password'], $risultato['eta'], $risultato['sesso'],
                                    $risultato['email'], $risultato['citta'], $risultato['ruolo'])){ /*collega i risultati della query con i
                                                                                                       parametri espliciti passati al metodo*/
            error_log("[caricaUtente]] Errore nel binding dei risultati");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($statement->fetch()){ /*se il metodo fetch() rende true significa che la query ha generato dei risultati, quindi con essi creo
                                 un'istanza della classe Utente*/
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return self::creaUtenteDaArray($risultato); //rende l'utente creato
        } else{
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return false; //rendeno false indica che la ricerca sul database non ha prodotto risultati
        }
    }
    
    /**
        Permette di caricare dal database tutti gli utenti registrati.
        @return la lista degli utenti in caso di successo.
        @return false se la ricerca non genera risultati.
        @return null in caso di errore.
    */
    public static function caricaElencoUtenti(){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[caricaElencoUtenti] Errore di connessione al database");
            return null;
        }
        
        $query = "SELECT * FROM utenti"; //stringa che rappresenta la query da eseguire
        
        $risultato = $client->query($query); //esegue la query e in $risultato ne salva il risultato
        
        if($client->errno > 0){ //se errno > 0 significa che si è verificato un errore
            error_log("[caricaElencoUtenti] Errore nell'esecuzione della query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($risultato->num_rows > 0){ //se è vero significa che la query ha prodotto risultati
            while($utente = $risultato->fetch_array()){ /*$utente è un array in cui vengono salvate, tramite la funzione fetch_array(), le
                                                          informazioni relative a un utente caricato*/
                $listaUtenti[] = Utente::creaUtenteDaArray($utente); //$listaUtenti è un array di oggetti di tipo Utente
            }
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return $listaUtenti; //si rende la lista degli utenti caricati
        } else{
        $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return false; //si rende false perchè la query non ha prodotto risultati
        }
        
        
    }
    
    /**
        Permette di salvare i dati relativi a un'istanza di tipo Utente sul database.
        @return null in caso di errore.
        @return true se il salvataggio va a buon fine, false altrimenti.
    */
    public function salvaUtente(){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[salvaUtente] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        $query = "INSERT INTO utenti (username, password, eta, sesso, email, citta, ruolo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[salvaUtente] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        $statement->bind_param("ssisssi", $this->getUsername(), $this->getPassword(), $this->getEta(), $this->getSesso(),
                                          $this->getEmail(), $this->getCitta(), $this->getRuolo()); //collega i parametri con il loro tipo
        if(!$statement){
            error_log("[salvaUtente] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[salvaUtente]] Errore nell'esecuzione della query");
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return null;
        } else{
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return true;
        }
    }
    
    /**
        Permette di modificare il ruolo di un utente sul database.
        Questa operazione è disponibile solamente se si è loggati al sito come Amministratore.
        @param $nomeUtente indica il nome dell'utente di cui si vuole modificare il nome.
        @param $ruolo indica il ruolo che si vuole impostare.
        @return null in caso di errore.
        @return true se l'operazione viene eseguita con successo.
        
    */
    public static function modificaRuoloUtente($nomeUtente, $ruolo){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[modificaRuoloUtente] Errore di connessione al database");
            return null;
        }
            
        $statement = $client->stmt_init(); //inizializza il prepared statement
           
        $query = "UPDATE utenti SET ruolo = ? WHERE username = ?";
           
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[modificaRuoloUtente] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
          
        $statement->bind_param("is", $ruolo, $nomeUtente); //collega i parametri con il loro tipo
        if(!$statement){
            error_log("[modificaRuoloUtente] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
            
        if(!$statement->execute()){ //esegue la query
            error_log("[modificaRuoloUtente] Errore nell'esecuzione della query");
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return null;
        } else{
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return true;
        }
    }
}

?>
