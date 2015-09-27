<?php

include_once("php/view/ImpostaPagina.php");

/**
    Questa classe permette di gestire le richieste inerenti alle pagine "statiche" del sito.
*/
class ControllerBase{

    /**
        Crea un'istanza vuota del tipo ControllerBase.
    */
	public function _construct(){
	
	}
	
	public function gestisciOperazioni(&$request){
		//si verifica quale pagina sia stata richiesta per poterla così visualizzare
		$pagina = isset($request['page']) ? $request['page'] : 'home'; /*se $request['page'] risulta true allora $pagina = $request['page',
		                                                                 altrimenti $pagina = 'home' */
	    $vista = ImpostaPagina::creaIstanza();

		//per ogni pagina si devono impostare le rispettive variabili per popolare la master page
		switch($pagina){
			case "home" :
				$this->mostraPaginaHome($vista);
				break;
			case "articoli" :
			    $this->mostraPaginaArticoli($vista);
				break;
			case "strumenti" :
			    $this->mostraPaginaStrumenti($vista);
				break;
			case "link" :
			    $this->mostraPaginaLink($vista);
				break;
		}
		
		if(isset($request["subpage"])){
		
			$sottopagina = $request["subpage"];
			
			switch($sottopagina){
				case "terra":
				    $vista->setContent("php/view/articoli/terra-content.php");
					break;
				case "luna":
	                $vista->setContent("php/view/articoli/luna-content.php");
					break;
				case "giove":
				    $vista->setContent("php/view/articoli/giove-content.php");
				   	break;
				case "marte":
				    $vista->setContent("php/view/articoli/marte-content.php");
				   	break;
			   	case "mercurio":
			   	    $vista->setContent("php/view/articoli/mercurio-content.php");
				   	break;
			   	case "nettuno":
			   	    $vista->setContent("php/view/articoli/nettuno-content.php");
				   	break;
				case "saturno":
				    $vista->setContent("php/view/articoli/saturno-content.php");
				   	break;
				case "urano":
				    $vista->setContent("php/view/articoli/urano-content.php");
				   	break;
				case "venere":
				    $vista->setContent("php/view/articoli/venere-content.php");
				   	break;
				case "pianetiNani":
				    $vista->setContent("php/view/articoli/pianetiNani-content.php");
				   	break;
			  	case "sole":
			  	    $vista->setContent("php/view/articoli/sole-content.php");
				   	break;
				case "viaLattea":
				    $vista->setContent("php/view/articoli/viaLattea-content.php");
				   	break;
				case "stelle":
				    $vista->setContent("php/view/articoli/stelle-content.php");
				   	break;
				case "nebulose":
				    $vista->setContent("php/view/articoli/nebulose-content.php");
				  	break;
			}
		}
		
		include "php/view/master.php"; //includo la master page per poter visualizzare la pagina richiesta
	}
	
	/**
        Questo metodo permette di visualizzare la pagina "Home".
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
    */
	protected function mostraPaginaHome(ImpostaPagina $vista){
	    $vista->setTitolo("Home");
		$vista->setHeader("php/view/home/header.php");
		$vista->setSidebar("php/view/home/sidebar.php");
		$vista->setContent("php/view/home/content.php");
	}
	
	/**
        Questo metodo permette di visualizzare la pagina "I nostri articoli".
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
    */
	protected function mostraPaginaArticoli(ImpostaPagina $vista){
	    $vista->setTitolo("I nostri articoli");
	    $vista->setHeader("php/view/articoli/header.php");
	    $vista->setSidebar("php/view/articoli/sidebar.php");
	    $vista->setContent("php/view/articoli/content.php");
	}
	
	/**
        Questo metodo permette di visualizzare la pagina "Strumenti per l'astronomia".
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
    */
	protected function mostraPaginaStrumenti(ImpostaPagina $vista){
	    $vista->setTitolo("Strumenti per l'astronomia");
	    $vista->setHeader("php/view/strumenti/header.php");
		$vista->setSidebar("php/view/strumenti/sidebar.php");
		$vista->setContent("php/view/strumenti/content.php");
	}
	
	/**
        Questo metodo permette di visualizzare la pagina "Link utili".
        @param $vista e' un'istanza della classe ImpostaPagina che serve per impostare i paramentri richiesti dalla master page.
    */
	protected function mostraPaginaLink(ImpostaPagina $vista){
	    $vista->setTitolo("Link utili");
		$vista->setHeader("php/view/link/header.php");
		$vista->setSidebar("php/view/link/sidebar.php");
		$vista->setContent("php/view/link/content.php");
	}
}

?>
