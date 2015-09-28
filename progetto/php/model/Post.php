<?php

/**
    Questa classe rappresenta un post di una discussione.
*/
class Post{
    
    private $id; //indica l'id con cui il post è registrato sul database
    private $id_discussione; //l'id della discussione a cui si riferisce
    private $id_utente; //l'id dell'utente che ha creato il post
    private $nome_utente; //il nome dell'utente che ha scritto il post
    private $dataOra; //data e ora scrittura post
    private $testo; //il testo del post
    
    /**
        Costruisce un'istanza vuota del tipo Post.
    */
    private function _constructor(){
    
    }
    
    /**
	    Imposta l'id del post.
	    @param $id indica l'id da impostare.
	*/
	public function setId($id){
	    if(filter_var($id, FILTER_VALIDATE_INT)){
            //valore id valido
            $this->id = $id;
        }
	}
	
	/**
	    Rende l'id del post.
	    @return l'id.
	*/
	public function getId(){
	    return $this->id;
	}
    
    /**
        Imposta l'id della discussione a cui si riferisce il post.
        @param $id_discussione indica l'id della discussione.
    */
    public function setIdDiscussione($id_discussione){
        if(filter_var($id_discussione, FILTER_VALIDATE_INT)){
            //valore id valido
            $this->id_discussione = $id_discussione;
        }
    }
    
    /**
        Rende l'id della discussione a cui si riferisce il messaggio.
        @return l'id della discussione.
    */
    public function getIdDiscussione(){
        return $this->id_discussione;
    }
    
    /**
        Imposta l'id dell'utente che ha scritto il post.
        @param $id_utente indica l'id dell'utente.
    */
    public function setIdUtente($id_utente){
        if(filter_var($id_utente, FILTER_VALIDATE_INT)){
            //valore valido
            $this->id_utente = $id_utente;
        }
    }
    
    /**
        Rende l'id dell'utente che ha scritto il post.
        @return l'id dell'utente.
    */
    public function getIdUtente(){
        return $this->id_utente;
    }
    
    /**
        Imposta il nome dell'utente che ha scritto il post.
        @param $nome_utente indica il nome dell'utente.
    */
    public function setNomeUtente($nome_utente){
        $this->nome_utente = $nome_utente;
    }
    
    /**
        Rende il nome dell'utente che ha scritto il post.
        @return il nome dell'utente.
    */
    public function getNomeUtente(){
        return $this->nome_utente;
    }
    
    /**
        Imposta la data e l'ora di scrittura del post, secondo il seguente formato: gg/mm/yyyy hh:mm:ss.
        @param $dataOra indica la data e l'ora.
    */
    public function setDataOra($dataOra){
        $this->dataOra = $dataOra;
    }
    
    /**
        Rende la data e l'ora di scrittura del post, secondo il seguente formato: gg/mm/yyyy hh:mm:ss.
        @return la data e l'ora.
    */
    public function getDataOra(){
        return $this->dataOra;
    }
    
    /**
        Imposta il testo del messaggio.
        @param $testo indica il testo del messaggio.
    */
    public function setTesto($testo){
        $this->testo = $testo;
    }
    
    /**
        Rende il testo del post.
        @return il testo.
    */
    public function getTesto(){
        return $this->testo;
    }
    
    /**
	    Permette di creare un'istanza di tipo Post partendo da un array.
	    @param $array indica l'array da cui creare l'istanza.
	    @return l'istanza creata.
	*/
    public static function creaPostDaArray($array){
        $post = new Post();
	    
	    if(isset($array['id'])){
	        $post->setId($array['id']);
	    }
	    if(isset($array['id_discussione'])){ /*effettuo il controllo perchè in fase di caricamento non ho bisogno dell'id_discussione e quindi
	                                         risulta indefinito nell'array. Serve invece quando si va a creare un post che poi deve
	                                         essere salvato sul database*/
	        $post->setIdDiscussione($array['id_discussione']);
	    }
	    if(isset($array['id_utente'])){ /*effettuo il controllo perchè in fase di caricamento non ho bisogno dell'id_utente e quindi
	                                      risulta indefinito nell'array. Serve invece quando si va a creare un post che poi deve
	                                      essere salvato sul database*/
	        $post->setIdUtente($array['id_utente']);
	    }
	    $post->setNomeUtente($array['nome_utente']);
	    $post->setDataOra($array['data']);
	    $post->setTesto($array['post']);
	    
	    return $post;
    }
    
    /**
        Permette di caricare tutti i post presenti sul database inerenti a una certa discussione.
        @param $id_discussione indica l'id della discussione a cui devono riferirsi i post.
        @return l'elenco dei post.
        @return false se non sono presenti post per discussione.
        @return null in caso di errore con il database.
    */
    public static function caricaElencoPost($id_discussione){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[caricaElencoPost] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        //stringa che rappresenta la query da eseguire
        $query = "SELECT post.id, DATE_FORMAT(post.data, '%d/%m/%Y %H:%i') as data_it, post.testo, utenti.username ";
        $query .= "FROM post ";
        $query .= "JOIN utenti ON utenti.id = post.creatore_id ";
        $query .= "JOIN discussioni ON discussioni.id = post.discussione_id ";
        $query .= "WHERE discussioni.id = ? ";
        $query .= "ORDER BY post.data";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[caricaElencoPost] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("i", $id_discussione)){ //collega i parametri con il loro tipo
            error_log("[caricaElencoPost] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[caricaElencoPost] Errore nell'esecuzione della query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        $risultato = array(); //crea un array in cui verrà salvato il risultato della ricerca
        
        //collega i risultati della query con i parametri espliciti passati al metodo
        if(!$statement->bind_result($risultato['id'], $risultato['data'],  $risultato['post'], $risultato['nome_utente'])){ 
            error_log("[caricaElencoPost] Errore nel binding dei risultati");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($statement->fetch()){ /*se il metodo fetch() rende true significa che la query ha generato dei risultati, quindi con essi creo
                                   un'istanza della classe Post*/
            do{
                $post = Post::creaPostDaArray($risultato); //dai risultati della query creo istanza di tipo Post
                $listaPost[] = $post; //aggiungo l'istanza creata in fondo all'array $listaPost
            } while($statement->fetch()); //continuo finchè il metodo fetch() rende true e quindi ci sono risultati da leggere
            
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return $listaPost;
        } else{ //se il metodo fetch() richiamato nell'if sopra rende false, significa che la query non ha generato risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return false;
        }
    }
      
    /**
        Permette di salvare un post sul database.
        @param $client è un parametro opzionale di tipo mysqli che viene utilizzato quando si implementano le transazioni. Se non viene ricevuto
               un parametro di questo tipo, il metodo esegue un normale inserimento, altrimenti sfrutta la connessione al database ricevuta
               per permettere la transazione.
        @return null in caso di errore con il database.
        @retun true se il salvataggio va a buon fine.
	*/
    public function salvaPost(mysqli $client = null){
        if(!isset($client)){
            $mod_transazione = false;
            //connessione al database
            $db = Database::caricaDatabase();
            $client = $db->connetti();
            if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
                error_log("[salvaPost] Errore di connessione al database");
                return null;
            }
        } else $mod_transazione = true;
        
        $statement = $client->stmt_init(); //inizializza il prepared statement

        //stringa che rappresenta la query da eseguire
        $query = "INSERT INTO post (data, testo, discussione_id, creatore_id) ";
        $query .= "VALUES (STR_TO_DATE(?, '%d/%m/%Y %H:%i:%s'), ?, ?, ?)";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[salvaPost] Errore d'inizializzazione dello statement");
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        //collega i parametri con il loro tipo
        if(!$statement->bind_param("ssii", $this->getDataOra(), $this->getTesto(), $this->getIdDiscussione(), $this->getIdUtente())){ 
            error_log("[salvaPost] Errore nel binding dei parametri nella query");
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[salvaPost] Errore nell'esecuzione della query");
            $statement->close(); //libera le risorse dello statement
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        } else{
            $statement->close(); //libera le risorse dello statement
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return true;
        }
    }
    
    /**
        Permette di eliminare un post avente un determinato id dal database.
        @param $id indica l'id del post dal eliminare.
        @param $client è un parametro opzionale di tipo mysqli che viene utilizzato quando si implementano le transazioni. Se non viene ricevuto
               un parametro di questo tipo, il metodo esegue una normale eliminazione, altrimenti sfrutta la connessione al database ricevuta
               per permettere la transazione.
        @return null in caso di errore con il database.
        @retun true se l'eliminazione va a buon fine.
    */
    public function eliminaPost(mysqli $client = null){
        if(!isset($client)){
            $mod_transazione = false;
            //connessione al database
            $db = Database::caricaDatabase();
            $client = $db->connetti();
            if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
                error_log("[eliminaPost] Errore di connessione al database");
                return null;
            }
        } else $mod_transazione = true;
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        $query = "DELETE FROM post WHERE id = ?";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[eliminaPost] Errore d'inizializzazione dello statement");
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        //collega i parametri con il loro tipo
        if(!$statement->bind_param("i", $this->getId())){
            error_log("[eliminaPost] Errore nel binding dei parametri nella query");
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[eliminaPost] Errore nell'esecuzione della query");
            $statement->close(); //libera le risorse dello statement
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        } else{
            $statement->close(); //libera le risorse dello statement
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return true;
        }
    }
}

?>
