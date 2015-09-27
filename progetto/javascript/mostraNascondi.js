$(document).ready(function(){
    
    $(".toggle").css("display","none"); //permette di nascondere tutti gli elementi aventi classe toggle
    
    //quando si clicca sul link che ha attributo id="listaPianeti" si richiama la funzione mostraNascondi
    $("a#listaPianeti").on('click', function(){ 
                        mostraNascondi($("ul.toggle"));
    });
    
    //quando si clicca sul link che ha attributo id="addCategoria" si richiama la funzione mostraNascondi
    $("a#addCategoria").on('click', function(){ 
                        mostraNascondi($("form.toggle"));
    });
    
    //quando si clicca sul link che ha attributo id="addCategoria" si richiama la funzione mostraNascondi
    $("a#addCategoria").on('click', function(){ 
                        mostraNascondi($("p.toggle"));
    });
      
    //Questa funzione permette di mostrare o nascondere un elemento in base al valore della sua proprieta' display
    function mostraNascondi(elemento){
        if(elemento.css("display") === "none"){
            elemento.css("display","block");
        } else elemento.css("display","none");
    }
    
    
    
});
