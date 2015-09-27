<?php

/**
    Questa classe rappresenta la categoria di una discussione.
*/
class Categoria{

    private $id; //indica l'id della categoria sul database
    private $nome; //nome della categoria
    private $listaDiscussioni; //lista con tutte le discussioni che appartengono alla categoria. Istanza di ElencoDiscussioni
    
    /**
        Costruisce un'istanza vuota del tipo Categoria.
    */
    public function _constructor(){
    
    }
    
    /**
        Imposta l'id della categoria.
        @param $id indica l'id da impostare.
    */
    public function setId($id){
        if(filter_var($id, FILTER_VALIDATE_INT)){
            //valore id valido
            $this->id = $id;
        }
    }
    
    /**
        Rende l'id della categoria.
        @return l'id.
    */
    public function getId(){
        return $this->id;
    }
    
    /**
        Imposta il nome della categoria.
        @param $nome indica il nome della categoria.
    */
    public function setNome($nome){
        $this->nome = $nome;
    }
    
    /**
        Rende il nome della categoria.
        @return il nome.
    */
    public function getNome(){
        return $this->nome;
    }
    
    /**
        Imposta la lista delle discussioni relative alla categoria.
        @param $lista indica la lista delle discussioni.
    */
    public function setListaDiscussioni($lista){
        $this->listaDiscussioni = $lista;
    }
    
    /**
        Rende la lista delle discussioni relative alla categoria.
        @return la lista.
    */
    public function getListaDiscussioni(){
        return $this->listaDiscussioni;
    }
    
    /**
        Permette di creare un'istanza di tipo Categoria partendo da un array.
        @param $array indica l'array contenente i dati relativi a una categoria.
        @return la categoria creata.
    */
    public static function creaCategoriaDaArray($array){
        $categoria = new Categoria();
        
        if(isset($array['id'])){
            $categoria->setId($array['id']);
        }
        $categoria->setNome($array['nome']);
        if(isset($array['listaDiscussioni'])){
            $categoria->setListaDiscussioni($array['listaDiscussioni']);
        }
        return $categoria;
    }
    
    /**
        Permette di verificare se nel database è presente una categoria con un determinato nome.
        @return null in caso di errore con il database.
        @return true se la categoria esiste, false altrimenti.
    */
    public function cercaPerNome(){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[cercaPerNome] Errore di connessione al database");
            return null;
        }

        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        $query = "SELECT nome FROM categorie WHERE nome = ?"; //stringa che rappresenta la query da eseguire
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[cercaPerNome] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("s", $this->getNome())){ //collega i parametri con il loro tipo
            error_log("[cercaPerNome] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[cercaPerNome] Errore nell'esecuzione della query");
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
        Permette di caricare dal database una categoria in base al suo id.
        @param $id indica l'id della categoria da caricare.
        @return l'instanza di tipo Categoria caricata.
        @return false se la categoria non viene trovata.
        @return null in caso d'errore con il database.
    */
    public static function caricaCategoria($id){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[caricaCategoria] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        $query = "SELECT id, nome FROM categorie WHERE id = ?"; //stringa che rappresenta la query da eseguire
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[caricaCategoria] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("i", $id)){ //collega i parametri con il loro tipo
            error_log("[caricaCategoria] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[caricaCategoria] Errore nell'esecuzione della query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        $risultato = array(); //crea un array in cui verrà salvato il risultato della ricerca
        
        //collega i risultati della query con i parametri espliciti passati al metodo
        if(!$statement->bind_result($risultato['id'], $risultato['nome'])){ 
            error_log("[caricaCategoria] Errore nel binding dei risultati");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($statement->fetch()){ /*se il metodo fetch() rende true significa che la query ha generato dei risultati, quindi con essi creo
                                   un'istanza della classe Categoria*/
            $categoria = Categoria::creaCategoriaDaArray($risultato); //dai risultati della query creo l'istanza di tipo Categoria
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return $categoria;
        } else{ //se il metodo fetch() richiamato nell'if sopra rende false, significa che la query non ha generato risultati
            $statement->close(); //libera le risorse dello statement
            $client->close(); //rilascia la connessione con il database
            return false;
        }
    }
    
    /**
        Carica tutte le categorie disponibili sul database.
        @return un array con le categorie.
        @return false se la query non produce risultati.
        @return null in caso di errore con il database.
    */
    public static function caricaElencoCategorie(){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[caricaElencoCategorie] Errore di connessione al database");
            return null;
        }
        
        $query = "SELECT id, nome FROM categorie"; //stringa che rappresenta la query da eseguire
        
        $risultato = $client->query($query); //esegue la query e in $risultato ne salva il risultato
        
        if($client->errno > 0){ //se errno > 0 significa che si è verificato un errore
            error_log("[caricaElencoCategorie] Errore nell'esecuzione della query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if($risultato->num_rows > 0){ //se è vero significa che la query ha prodotto risultati
            while($categoria = $risultato->fetch_array()){ /*$categoria è un array in cui vengono salvati, tramite la funzione fetch_array(), i
                                                             nomi relativi alle categorie caricate*/
                $listaCategorie[] = Categoria::creaCategoriaDaArray($categoria); //$listaCategorie è un array con tutte le categorie
            }
            $client->close(); //rilascia la connessione con il database
            return $listaCategorie; //si rende la lista delle categorie caricate
        } else{
            $client->close(); //rilascia la connessione con il database
            return false; //si rende false perchè la query non ha prodotto risultati
        }
    }
    
    /**
        Permette di salvare i dati relativi a un'istanza di tipo Categoria sul database.
        @return null in caso di errori con il database.
        @return true in caso di aggiunta andata a buon fine.
    */
    public function salvaCategoria(){
        //connessione al database
        $db = Database::caricaDatabase();
        $client = $db->connetti();
        if(!isset($client)){ //se $client è null significa che si è verificato un errore in fase di connessione al database
            error_log("[salvaCategoria] Errore di connessione al database");
            return null;
        }
        
        $statement = $client->stmt_init(); //inizializza il prepared statement
        
        $query = "INSERT INTO categorie (nome) VALUES (?)";
        
        $statement->prepare($query); //prepara lo statement per l'esecuzione
        if(!$statement){
            error_log("[salvaCategoria] Errore d'inizializzazione dello statement");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->bind_param("s", $this->getNome())){ //collega i parametri con il loro tipo
            error_log("[salvaCategoria] Errore nel binding dei parametri nella query");
            $client->close(); //rilascia la connessione con il database
            return null;
        }
        
        if(!$statement->execute()){ //esegue la query
            error_log("[salvaCategoria] Errore nell'esecuzione della query");
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
