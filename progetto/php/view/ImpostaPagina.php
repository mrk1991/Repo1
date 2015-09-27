<?php

/**
    Questa classe contiene le variabili utili a popolare la master page.
*/
class ImpostaPagina{

    private $vista; //rappresenta l'istanza della classe che servirà per impostare i parametri per la visualizzazione delle pagine
    private $titolo; //indica il titolo della pagina
    private $header; //indica l'header della pagina
    private $sidebar; //indica la sidebar della pagina
    private $content; //indica il content della pagina
    private $errore; //indica eventuali messaggi di errore da visualizzare
    private $conferma; //indica eventuali messaggi di conferma da visualizzare
    
    /**
        Crea un'istanza vuota del tipo ImpostaPagina.
    */
    private function _construct(){
    
    }
    
    /**
        Permette di creare un'istanza del tipo ImpostaPagina qualora essa non sia gia' stata creata.
        @return l'istanza di tipo ImpostaPagina.
    */
    public static function creaIstanza(){
        if(!isset($vista)){ //se la variabile $vista non è stata ancora settata...
            $vista = new ImpostaPagina(); //...viene creata l'istanza di tipo ImpostaPagina
        }
        return $vista; //rende un'istanza di tipo ImpostaPagina
    }
    
    /**
        Imposta il titolo della pagina.
        @param $titolo indica il titolo da impostare.
    */
    public function setTitolo($titolo){
        $this->titolo = $titolo;
    }
    
    /**
        Rende il titolo della pagina.
        @return il titolo della pagina.
    */
    public function getTitolo(){
        return $this->titolo;
    }
    
    /**
        Imposta l'header della pagina.
        @param $header indica l'indirizzo del file contenente l'header.
    */
    public function setHeader($header){
        $this->header = $header;
    }
    
    /**
        Rende l'header della pagina.
        @return l'header.
    */
    public function getHeader(){
        return $this->header;
    }
    
    /**
        Imposta la sidebar della pagina.
        @param $sidebar indica l'indirizzo del file contenente la sidebar.
    */
    public function setSidebar($sidebar){
        $this->sidebar = $sidebar;
    }
    
    /**
        Rende la sidebar del sito.
        @return la sidebar.
    */
    public function getSidebar(){
        return $this->sidebar;
    }
    
    /**
        Imposta il content della pagina.
        @param $content indica l'indirizzo del file contenente il content.
    */
    public function setContent($content){
        $this->content = $content;
    }
    
    /**
        Rende il content della pagina.
        @return il content.
    */
    public function getContent(){
        return $this->content;
    }
    
    /**
        Imposta un eventuale messaggio di errore da visualizzare nella pagina.
        @param $messaggio indica il messaggio da visualizzare
    */
    public function setErrore($messaggio){
        $this->errore = $messaggio;
    }
    
    /**
        Rende il messaggio di errore.
        @return il messaggio.
    */
    public function getErrore(){
        return $this->errore;
    }
    
    /**
        Imposta un eventuale messaggio di conferma da visualizzare nella pagina.
        @param $messaggio indica il messaggio da visualizzare
    */
    public function setConferma($messaggio){
        $this->conferma = $messaggio;
    }
    
    /**
        Rende il messaggio di conferma.
        @return il messaggio.
    */
    public function getConferma(){
        return $this->conferma;
    }
}
?>
