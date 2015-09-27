<?php

/**
    Questa classe rappresenta una discussione sul forum.
*/
class Discussione{
    
    private $id; //l'id con cui la discussione è salvata nel database
	private $titolo; //titolo della discussione
	private $id_categoria; //l'id della categoria a cui appartiene la discussione. Serve per il salvataggio sul database
	private $id_utente; //l'id dell'utente che ha creato la discussione. Serve per il salvataggio sul database
	private $nome_utente; //il nome dell'utente che ha creato la discussione.
	private $dataOra; //la data e l'ora di creazione della discussione
	private $listaPost; //lista dei messaggi inerenti alla discussione. È un'istanza del tipo ElencoPost
	
	/**
	    Costruisce un'istanza vuota del tipo Discussione.
	*/
	public function _construct(){
	
	}
	
	/**
	    Imposta l'id della discussione.
	    @param $id indica l'id da impostare.
	*/
	public function setId($id){
	    if(filter_var($id, FILTER_VALIDATE_INT)){
            //valore id valido
            $this->id = $id;
        }
	}
	
	/**
	    Rende l'id della discussione.
	    @return l'id.
	*/
	public function getId(){
	    return $this->id;
	}
	
	/**
	    Imposta l'id della categoria alla quale appartiene la discussione.
	    @param $id_categoria indica l'id della categoria.
	*/
	public function setIdCategoria($id_categoria){
	    if(filter_var($id_categoria, FILTER_VALIDATE_INT)){
            //valore id valido
            $this->id_categoria = $id_categoria;
        }
	}
	
	/**
	    Rende l'id della categoria della discussione.
	    @return l'id della categoria.
	*/
	public function getIdCategoria(){
		return $this->id_categoria;
	}
	
	/**
	    Imposta l'id dell'utente che ha creato la discussione.
	    @param $id_utente indica l'id dell'utente.
	*/
	public function setIdUtente($id_utente){
	    if(filter_var($id_utente, FILTER_VALIDATE_INT)){
            //valore id valido
            $this->id_utente = $id_utente;
        }
	}
	
	/**
	    Rende l'id dell'utente che ha creato la discussione.
	    @return l'id dell'utente.
	*/
	public function getIdUtente(){
		return $this->id_utente;
	}
	
	/**
	    Imposta il nome dell'utente che ha creato la discussione.
	    @param $nome indica il nome dell'utente.
	*/
	public function setNomeUtente($nome){
		$this->nome_utente = $nome;
	}
	
	/**
	    Rende il nome dell'utente che ha creato la discussione.
	    @return il nome dell'utente.
	*/
	public function getNomeUtente(){
		return $this->nome_utente;
	}
	
	/**
	    Imposta la data e l'ora di creazione della discussione, secondo il seguente formato: gg/mm/yyyy hh:mm:ss.
	    @param $dataOra indica la data e l'ora.
	*/
	public function setDataOra($dataOra){
		$this->dataOra = $dataOra;
	}
	
	/**
	    Rende la data in cui e' stata creata la discussione, secondo il seguente formato: gg/mm/yyyy hh:mm:ss.
	    @return la data.
	*/
	public function getDataOra(){
		return $this->dataOra;
	}
		
	/**
	    Imposta il titolo della discussione.
	    @param $titolo indica il titolo della discussione.
	*/
	public function setTitolo($titolo){
		$this->titolo = $titolo;
	}
	
	/**
	    Rende il titolo della discussione.
	    @return il titolo.
	*/
	public function getTitolo(){
		return $this->titolo;
	}
	
	/**
	    Imposta la lista dei post relativi alla discussione.
	    @param $lista indica l'array contenente i post.
	*/
	public function setListaPost($lista){
		$this->listaPost = $lista;
	}
	
	/**
	    Rende la lista dei post relativi alla discussione.
	    @return la lista.
	*/
	public function getListaPost(){
		return $this->listaPost;
	}
	
	/**
	    Permette di creare un'istanza di tipo Discussione partendo da un array.
	    @param $array indica l'array da cui creare l'istanza.
	    @return l'istanza creata.
	*/
	public static function creaDiscussioneDaArray($array){
	    $discussione = new Discussione();
	    
	    if(isset($array['id'])){
	        $discussione->setId($array['id']);
	    }
	    
	    $discussione->setTitolo($array['titolo']);
	    
	    if(isset($array['id_categoria'])){ /*effettuo il controllo perchè in fase di caricamento non ho bisogno dell'id_categoria e quindi
	                                         risulta indefinito nell'array. Serve invece quando si va a creare una discussione che poi deve
	                                         essere salvata sul database*/
	        $discussione->setIdCategoria($array['id_categoria']);
	    }
	    if(isset($array['id_utente'])){ /*effettuo i controllo perchè in fase di caricamento non ho bisogno dell'id_utente e quindi risulta
	                                      indefinito nell'array. Serve invece quando si va a creare una discussione che poi deve essere salvata
	                                      sul database*/
	        $discussione->setIdUtente($array['id_utente']);
	    }
	    $discussione->setNomeUtente($array['nome_utente']);
	    $discussione->setDataOra($array['data']);
	    if(isset($array['listaPost'])){ /*effettuo i controllo perchè in fase di caricamento non ho bisogno della listaPost e quindi risulta
	                                      indefinito nell'array. Serve invece quando l'utente decide di leggere i post della discussione*/
	        $discussione->setListaPost($array['listaPost']);
	    }
	    return $discussione;
	}
	
	/**
        Questo metodo permette di verificare se nel database è già presente una discussione avente un certo titolo e appartenente a una certa
        categoria.
        @return null in caso di errore con il database.
        @return true se la discussione esiste, false altrimenti.
    */
    public function cercaPerTitoloECategoria(){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[cercaPerTitoloECategoria] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        //stringa che rappresenta la query da eseguire
        $query = "SELECT titolo, categoria_id FROM discussioni WHERE titolo = ? AND categoria_id = ?"; 
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[cercaPerTitoloECategoria] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("si", $this->getTitolo(), $this->getIdCategoria())){ //collega i parametri con il loro tipo
            error_log("[cercaPerTitoloECategoria] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[cercaPerTitoloECategoria] Errore nell'esecuzione della query");
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
	    Permette di ricercare sul database l'id di una discussione.
	    @param $client è un parametro opzionale di tipo mysqli che viene utilizzato quando si implementano le transazioni. Se non viene ricevuto
               un parametro di questo tipo, il metodo esegue una propria connessione al database, altrimenti sfrutta la connessione ricevuta per
               permettere la transazione.
	    @retun l'id.
	    @return false se la ricerca non genera risultati.
	    @return null in caso d'errore con il database.
	*/
	public function cercaId(mysqli $client = null){
	    if(!isset($client)){
            $mod_transazione = false;
	        //connessione al database
            $db = Database::caricaDatabase();
            $client = $db->connetti();
            if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
                error_log("[cercaId] Errore di connessione al database");
                return null;
            }
        } else $mod_transazione = true;
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        //stringa che rappresenta la query da eseguire
        $query = "SELECT id FROM discussioni WHERE titolo = ? AND categoria_id = ?";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[cercaId] Errore d'inizializzazione dello statement");
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("si", $this->getTitolo(), $this->getIdCategoria())){ //collega i parametri con il loro tipo
            error_log("[cercaId] Errore nel binding dei parametri nella query");
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[cercaId] Errore nell'esecuzione della query");
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        }
                
        //collega i risultati della query con i parametri espliciti passati al metodo
        if(!$statement->bind_result($id)){ 
            error_log("[cercaId] Errore nel binding dei risultati");
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($statement->fetch()){ //se il metodo fetch() rende true significa che la query ha generato dei risultati
            $statement->close(); //libera le risorse dello statement
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return $id;
        } else{ //se il metodo fetch() richiamato nell'if sopra rende false, significa che la query non ha generato risultati
            $statement->close(); //libera le risorse dello statement
            if(!$mod_transazione)
                $client->close(); //rilascia la connessione con il database
            return false;
        }
	}
	
	/**
	    Permette di caricare una singola discussione dal database in base al suo id.
	    @param $id indica l'id della discussione che si vuole caricare.
	    @return l'istanza caricata.
	    @return false se l'istanza non viene trovata.
	    @return null in caso di errore.
	*/
	public static function caricaDiscussione($id){
	    //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[caricaDiscussione] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        //stringa che rappresenta la query da eseguire
        $query = "SELECT discussioni.id, discussioni.titolo, DATE_FORMAT(discussioni.data, '%d/%m/%Y %H:%i') as data_it, "; 
        $query .= "discussioni.categoria_id, discussioni.creatore_id, utenti.username ";
        $query .= "FROM discussioni ";
        $query .= "JOIN utenti ON utenti.id = discussioni.creatore_id ";
        $query .= "WHERE discussioni.id = ?";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[caricaDiscussione] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("i", $id)){ //collega i parametri con il loro tipo
            error_log("[caricaDiscussione] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[caricaDiscussione] Errore nell'esecuzione della query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        $risultato = array(); //crea un array in cui verrà salvato il risultato della ricerca
        
        //collega i risultati della query con i parametri espliciti passati al metodo
        if(!$statement->bind_result($risultato['id'], $risultato['titolo'],  $risultato['data'], $risultato['id_categoria'],
            $risultato['id_utente'], $risultato['nome_utente'])){ 
            error_log("[caricaDiscussione] Errore nel binding dei risultati");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($statement->fetch()){ /*se il metodo fetch() rende true significa che la query ha generato dei risultati, quindi con essi creo
                                   un'istanza della classe Discussione*/
            $discussione = Discussione::creaDiscussioneDaArray($risultato); //dai risultati della query creo istanza di tipo Discussione  
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return $discussione;
        } else{ //se il metodo fetch() richiamato nell'if sopra rende false, significa che la query non ha generato risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return false;
        }
	}
	
	/**
        Carica id, titolo, data e ora di creazione e l'utente di tutte le discussioni inerenti a una certa categoria presenti sul database.
        @param $id indica l'id della categoria di appartenenza delle discussioni.
        @return un array con le informazioni sulle discussioni.
        @return false se non sono presenti discussioni per la categoria voluta.
        @return null in caso di errore con il database.
    */
	public static function caricaElencoDiscussioni($id){
	    //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[caricaElencoDiscussioni] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        //stringa che rappresenta la query da eseguire
        $query = "SELECT discussioni.id, discussioni.titolo, DATE_FORMAT(discussioni.data, '%d/%m/%Y %H:%i') as data_it, utenti.username ";
        $query .= "FROM discussioni ";
        $query .= "JOIN utenti ON utenti.id = discussioni.creatore_id ";
        $query .= "JOIN categorie ON categorie.id = discussioni.categoria_id ";
        $query .= "WHERE categorie.id = ?";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[caricaElencoDiscussioni] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("s", $id)){ //collega i parametri con il loro tipo
            error_log("[caricaElencoDiscussioni] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[caricaElencoDiscussioni] Errore nell'esecuzione della query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        $risultato = array(); //crea un array in cui verrà salvato il risultato della ricerca
        
        //collega i risultati della query con i parametri espliciti passati al metodo
        if(!$statement->bind_result($risultato['id'], $risultato['titolo'],  $risultato['data'], $risultato['nome_utente'])){ 
            error_log("[caricaElencoDiscussioni] Errore nel binding dei risultati");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($statement->fetch()){ /*se il metodo fetch() rende true significa che la query ha generato dei risultati, quindi con essi creo
                                   un'istanza della classe Discussione*/
            do{
                $discussione = Discussione::creaDiscussioneDaArray($risultato); //dai risultati della query creo istanza di tipo Discussione
                $listaDiscussioni[] = $discussione; //aggiungo l'istanza creata in fondo all'array $listaDiscussioni
            } while($statement->fetch()); //continuo fino a quando il metodo fetch() rende true e quindi ci sono risultati da leggere
            
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return $listaDiscussioni;
        } else{ //se il metodo fetch() richiamato nell'if sopra rende false, significa che la query non ha generato risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return false;
        }
	}
	
	/**
	    Questo metodo pemette di salvare sul database una discussione sfruttando le transazioni.
	    @param $post indica un'istanza del tipo Post che rappresenti il post creato insieme alla discussione.
	    @return null in caso di errori con il database.
        @return true in caso di aggiunta andata a buon fine.
	*/
	public function salvaDiscussione(Post $post){
	    //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[salvaDiscussione] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement

        //stringa che rappresenta la query da eseguire
        $query = "INSERT INTO discussioni (data, titolo, categoria_id, creatore_id) ";
        $query .= "VALUES (STR_TO_DATE(?, '%d/%m/%Y %H:%i:%s'), ?, ?, ?)";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[salvaDiscussione] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        //collega i parametri con il loro tipo
        if(!$statement->bind_param("ssii", $this->getDataOra(), $this->getTitolo(), $this->getIdCategoria(), $this->getIdUtente())){ 
            error_log("[salvaDiscussione] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        $client->autocommit(false); //inizia la transazione
                                      
        if(!$statement->execute()){ //esegue la query
            error_log("[salvaDiscussione] Errore nell'esecuzione della query");
            $statement->close(); //libera le risorse dello statement
            $client->rollback(); //in caso di errori ripristina la situazione precedente
            $client->close(); //rilascia la connessione con il database
            return null;
        } else{ //se l'esecuzione della query non genera errori, la discussione è  stata salvata sul database e occorre salvare il post
            $id = $this->cercaId($client); //ricerca l'id della discussione appena creata
            if(!$id){ //se id è null o false significa che si è verificato un errore
                $statement->close(); //libera le risorse dello statement
                $client->rollback(); //in caso di errori ripristina la situazione precedente
                $client->close(); //rilascia la connessione con il database
                return null;
            } else{ //sel'id è valido
                $post->setIdDiscussione($id); //assegna al post l'id della discussione appena creata
                if(!$post->salvaPost($client)){ //salva il post e verifica il risultato
                    //salvataggio non riuscito
                    $statement->close(); //libera le risorse dello statement
                    $client->rollback(); //in caso di errori ripristina la situazione precedente
                    $client->close(); //rilascia la connessione con il database
                } else{ //salvataggio riuscito
                    $statement->close(); //libera le risorse dello statement
                    $client->commit(); //rende permanenti le modifiche al database
                    $client->autocommit(true); //ripristina il comportamento normale
                    $client->close(); //rilascia la connessione con il database
                    return true;
                }
            }
	    }
    }
	
	/**
	    Pemette di eliminare dal database una discussione sfruttando le transazioni.
	    @return null in caso d'errore.
	    @return true se l'eliminazione avviene con successo.
	*/
	public function eliminaDiscussione(){
	    //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[eliminaDiscussione] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement*/
        
        //stringa che rappresenta la query da eseguire
        $query = "DELETE FROM discussioni WHERE id = ?";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[eliminaDiscussione] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        //collega i parametri con il loro tipo
        if(!$statement->bind_param("i", $this->getId())){ 
            error_log("[eliminaDiscussione] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        $client->autocommit(false); /*prima di eliminare la discussione dal database occorre eliminare tutti i post che fanno riferimento a essa,
                                      perciò inizio la transazione*/
        
        $listaPost = $this->getListaPost();
        
        if(!isset($listaPost) || !$listaPost == false){ //verifica se sono presenti post per la discussione
            foreach($listaPost as $post){ //per ogni post della lista
                if(!$post->eliminaPost($client)){ //invoca il metodo per eliminarlo e verifica il risultato dell'eliminazione
                    $client->rollback(); //in caso di errori ripristina la situazione precedente
                    $client->close(); //rilascia la connessione con il database
                    return null;
                }
            }   
        }
        
        //se i post sono stati eliminati senza errori, si può eliminare anche la discussione dal database
        
        if(!$statement->execute()){ //esegue la query
            error_log("[eliminaDiscussione] Errore nell'esecuzione della query");
            $statement->close(); //libera le risorse dello statement
            $client->rollback(); //in caso di errori ripristina la situazione precedente
            $client->close(); //rilascia la connessione con il database
            return null;
        } else{ //eliminazione discussione avvenuta con successo
            $statement->close(); //libera le risorse dello statement
            $client->commit(); //rende permanenti le modifiche fatte al database
            $client->autocommit(true); //ripristina il normale comportamento
            $client->close(); //rilascia la connessione con il database
            return true;
        }
	}
}

?>
