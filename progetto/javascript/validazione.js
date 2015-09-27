$(document).ready(function(){
    
    $("p.messaggio").hide(); //nasconde i messaggi d'errore o conferma alla prima apertura di una pagina che potrebbe visualizzarli
    $("p.toggle").hide();
    
    //$("p#conferma").hide(); //VECCHIO DA ELIMINARE
    
    //funzione per la validazione del login
    $("#login").click(function(event){ //aggancia il click del pulsante "Login"
        
        //$("p.messaggio").hide(); //nasconde i messaggi d'errore o conferma quando si verifica un nuovo click sul tasto "Login"
        
        //$("p#errore").hide(); //VECCHIO DA ELIMINARE
        //$("p#conferma").hide(); //VECCHIO DA ELIMINARE
        
        
        event.preventDefault(); //previene che venga eseguita la submit
        
        var username = $("#username").val(); //prelevo il valore inserito dall'utente nel campo username
        var password = $("#password").val(); //prelevo il valore inserito dall'utente nel campo password
        
        //verifica che non siano stati lasciati campi vuoti nel form
        if(username == "" || password == ""){ //se i campi sono vuoti
            
            //seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html al suo interno
            $("p.messaggio").attr("id", "errore").html("Alcuni campi sono vuoti");
            $("p.messaggio").show(); //rende visualizzabile il messaggio
            
            /*$("p#errore").html("Hai lasciato dei campi vuoti"); //VECCHIO DA ELIMINARE
            $("p#errore").show();*/ //VECCHIO DA ELIMINARE
            
        } else{ //se i campi sono stati tutti compilati
            $.ajax({ //richiama la funzione ajax
                url : "index.php?page=login",//"",php/controller/ControlloreAjax.php //indirizzo a cui inviare la richesta
                //lista dei dati da passare
                data : {
                    validazione : true,//'validaLogin',//validazione : true,
                    username : username,
                    password : password
                },
                dataType: "json", //tipo di dati restituiti dal server
                success: function (data){ //funzione da eseguire in caso di successo
                    var errore = data.errore; //contiene un eventuale errore reso dal server durante il processo di validazione
                    var conferma = data.conferma; /*contiene un eventuale messaggio di conferma reso dal server durante il processo di
                                                    validazione*/
                    if(errore){ //se c'è un errore
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        dell'errore al suo interno*/
                        $("p.messaggio").attr("id", "errore").html(errore);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio
                    } else if(conferma){ //se c'è una conferma
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        della conferma al suo interno*/
                        $("p.messaggio").attr("id", "conferma").html(conferma);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio
                        
                        /*$("#conferma").html(conferma); //VECCHIO DA ELIMINARE
                        $("p#conferma").show();*/ //VECCHIO DA ELIMINARE
                        
                        // Redirect dopo 0.8 secondi
                        setTimeout(function() {
                          $(location).attr('href','index.php?page=forum');
                        }, 800);
                        //location.replace("index.php?page=forum"); //reindirizzamento verso la home del forum
                    }
                    
                },
                error: function (data){ //funzione da eseguire in caso di insuccesso
                    alert("La richiesta non è stata eseguita, si prega di riprovare."); //visualizza un popup con il messaggio d'errore
                }
            });
        }
    });
    
    //funzione per la validazione della registrazione
    $("#registrazione").click(function(event){ //aggancia il click del pulsante "Login"

        event.preventDefault(); //previene che venga eseguita la submit
        
        var username = $("#username").val(); //prelevo il valore inserito dall'utente nel campo username
        var password = $("#password").val(); //prelevo il valore inserito dall'utente nel campo password
        var eta = $("#eta").val(); //prelevo il valore inserito dall'utente nel campo età
        var sesso = $("input[type=radio][name=sesso]:checked").val(); /*dall'input che ha type=radio e name=sesso preleva il valore dell'opzione
                                                                        selezionata*/
        var email = $("#email").val(); //prelevo il valore inserito dall'utente nel campo e-mail
        var citta = $("#citta").val(); //prelevo il valore inserito dall'utente nel campo citta
        
        //verifica che non siano stati lasciati campi vuoti nel form
        if(username == "" || password == "" || eta == "" || sesso == "" || email == "" || citta == ""){ //se i campi sono vuoti
            
            //seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html al suo interno
            $("p.messaggio").attr("id", "errore").html("Alcuni campi sono vuoti");
            $("p.messaggio").show(); //rende visualizzabile il messaggio

        } else{ //se i campi sono stati tutti compilati
            $.ajax({ //richiama la funzione ajax
                url : "index.php?page=registrazione", //indirizzo a cui inviare la richesta
                //lista dei dati da passare
                data : {
                    validazione : true, //serve per permettere, lato server, di capire che si è ricevuta una richiesta ajax
                    username : username,
                    password : password,
                    eta : eta,
                    sesso : sesso,
                    email : email,
                    citta : citta
                },
                dataType: "json", //tipo di dati restituiti dal server
                success: function (data){ //funzione da eseguire in caso di successo
                    var errore = data.errore; //contiene un eventuale errore reso dal server durante il processo di validazione
                    var conferma = data.conferma; /*contiene un eventuale messaggio di conferma reso dal server durante il processo di
                                                    validazione*/
                    if(errore){ //se c'è un errore
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        dell'errore al suo interno*/
                        $("p.messaggio").attr("id", "errore").html(errore);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio
                    } else if(conferma){ //se c'è una conferma
                    
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        della conferma al suo interno*/
                        $("p.messaggio").attr("id", "conferma").html(conferma);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio
                        
                        setTimeout(function() {
                          $(location).attr('href','index.php?page=login');
                        }, 800);
                        //location.replace("index.php?page=login"); //reindirizzamento verso la pagina di login
                    }
                },
                error: function (data){ //funzione da eseguire in caso di insuccesso
                    alert("La richiesta non è stata eseguita, si prega di riprovare."); //visualizza un popup con il messaggio d'errore
                }
            });
        }
    });
    
    //funzione per la validazione dell'opzione "Aggiungi una categoria per le discussioni"
    $("#creaCategoria").click(function(event){ //aggancia il click del pulsante "Inserisci"
    
        event.preventDefault(); //previene che venga eseguita la submit
        
        var nome = $("#nomeCategoria").val(); //prelevo il valore inserito dall'utente nel campo Categoria
        
        //verifica che non siano stati lasciati campi vuoti nel form
        if(nome == ""){ //se i campi sono vuoti
            
            //seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html al suo interno
            $("p.messaggio").addClass("toggle").attr("id", "errore").html("Alcuni campi sono vuoti");
            $("p.messaggio").show(); //rende visualizzabile il messaggio
             
        } else{ //se i campi sono stati tutti compilati
            $.ajax({ //richiama la funzione ajax
                url : "index.php?page=forum", //indirizzo a cui inviare la richesta
                //lista dei dati da passare
                data : {
                    azione : "addCategory",
                    validazione : true, //serve per permettere, lato server, di capire che si è ricevuta una richiesta ajax
                    nomeCategoria : nome
                },
                dataType: "json", //tipo di dati restituiti dal server
                success: function (data){ //funzione da eseguire in caso di successo
                    var errore = data.errore; //contiene un eventuale errore reso dal server durante il processo di validazione
                    var conferma = data.conferma; /*contiene un eventuale messaggio di conferma reso dal server durante il processo di
                                                    validazione*/
                    if(errore){ //se c'è un errore
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        dell'errore al suo interno*/
                        $("p.messaggio").addClass("toggle").attr("id", "errore").html(errore);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio
                    } else if(conferma){ //se c'è una conferma
                    
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        della conferma al suo interno*/
                        $("p.messaggio").addClass("toggle").attr("id", "conferma").html(conferma);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio
                        
                        // Redirect dopo 0.8 secondi
                        setTimeout(function() {
                          $(location).attr('href','index.php?page=forum');
                        }, 800);
                    }
                },
                error: function (data){ //funzione da eseguire in caso di insuccesso
                    alert("La richiesta non è stata eseguita, si prega di riprovare."); //visualizza un popup con il messaggio d'errore
                }
            });
        }
    });
    
    //funzione per la validazione della creazione di nuove discussioni
    $("#creaDiscussione").click(function(event){ //aggancia il click del pulsante "Crea"
          
        event.preventDefault(); //previene che venga eseguita la submit
        
        var id_categoria = $("#id_categoria").val(); //prelevo l'id della categoria
        var nome_categoria = $("#nome_categoria").val(); //prelevo il nome della categoria
        var id_utente = $("#id_utente").val(); //prelevo l'id dell'utente
        var nome_utente = $("#nome_utente").val(); //prelevo il nome dell'utente
        var data = $("#data").val(); //prelevo la data
        var titolo = $("#titolo").val(); //prelevo il valore inserito dall'utente nel campo "Titolo"
        var post = $("#firstPost").val(); //prelevo il valore inserito dall'utente nel textbox
        
        //verifica che non siano stati lasciati campi vuoti nel form
        if(titolo == "" || post == ""){ //se i campi sono vuoti
            
            //seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html al suo interno
            $("p.messaggio").attr("id", "errore").text("Alcuni campi sono vuoti");
            $("p.messaggio").show(); //rende visualizzabile il messaggio
             
        } else{ //se i campi sono stati tutti compilati
            $.ajax({ //richiama la funzione ajax
                url : "index.php?page=forum", //indirizzo a cui inviare la richesta
                //lista dei dati da passare
                data : {
                    azione : "crea_discussione",
                    validazione : true, //serve per permettere, lato server, di capire che si è ricevuta una richiesta ajax
                    titolo : titolo,
                    id_categoria : id_categoria,
                    id_utente : id_utente,
                    nome_utente : nome_utente,
                    data : data,
                    post : post
                },
                dataType: "json", //tipo di dati restituiti dal server
                success: function (data){ //funzione da eseguire in caso di successo
                    var errore = data.errore; //contiene un eventuale errore reso dal server durante il processo di validazione
                    var conferma = data.conferma; /*contiene un eventuale messaggio di conferma reso dal server durante il processo di
                                                    validazione*/
                    if(errore){ //se c'è un errore
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        dell'errore al suo interno*/
                        $("p.messaggio").attr("id", "errore").html(errore);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio
                    } else if(conferma){ //se c'è una conferma
                    
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        della conferma al suo interno*/
                        $("p.messaggio").attr("id", "conferma").html(conferma);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio
                        
                        var indirizzo = "index.php?page=forum&subpage=categoria&id=" + id_categoria;
                        
                        // Redirect dopo 0.8 secondi
                        setTimeout(function() {
                          $(location).attr('href', indirizzo);
                        }, 800);
                    }
                },
                error: function (data){ //funzione da eseguire in caso di insuccesso
                    alert("La richiesta non è stata eseguita, si prega di riprovare."); //visualizza un popup con il messaggio d'errore
                }
            });
        }
    });
    
    //funzione per la validazione dell'eliminazione di una discussione
    $("#eliminaDiscussione").click(function(event){ //aggancia il click del pulsante "Elimina discussione"
          
        event.preventDefault(); //previene che venga eseguita la submit
        
        var id_categoria = $("#id_categoria").val(); //prelevo l'id della categoria
        var id_discussione = $("#id_discussione").val(); //prelevo l'id della discussione

        $.ajax({ //richiama la funzione ajax
            url : "index.php?page=forum", //indirizzo a cui inviare la richesta
            //lista dei dati da passare
            data : {
                azione : "elimina_discussione",
                validazione : true, //serve per permettere, lato server, di capire che si è ricevuta una richiesta ajax
                id : id_discussione
            },
            dataType: "json", //tipo di dati restituiti dal server
            success: function (data){ //funzione da eseguire in caso di successo
                var errore = data.errore; //contiene un eventuale errore reso dal server durante il processo di validazione
                var conferma = data.conferma; /*contiene un eventuale messaggio di conferma reso dal server durante il processo di
                                                validazione*/
                if(errore){ //se c'è un errore
                    /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                    dell'errore al suo interno*/
                    $("p.messaggio").attr("id", "errore").html(errore);
                    $("p.messaggio").show(); //rende visualizzabile il messaggio
                } else if(conferma){ //se c'è una conferma
                    
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        della conferma al suo interno*/
                        $("p.messaggio").attr("id", "conferma").html(conferma);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio

                        // Redirect dopo 0.8 secondi
                        setTimeout(function() {
                          $(location).attr('href', "index.php?page=forum&subpage=categoria&id=" + id_categoria);
                        }, 800);
                  }
            },
            error: function (data){ //funzione da eseguire in caso di insuccesso
                alert("La richiesta non è stata eseguita, si prega di riprovare."); //visualizza un popup con il messaggio d'errore
            }
        });
    });
    
    //funzione per la validazione dell'eliminazione di una discussione
    $("#creaPost").click(function(event){ //aggancia il click del pulsante "Invia"
          
        event.preventDefault(); //previene che venga eseguita la submit
        
        var id_discussione = $("#id_discussione").val(); //prelevo l'id della discussione
        var id_utente = $("#id_utente").val(); //prelevo l'id dell'utente
        var nome_utente = $("#nome_utente").val(); //prelevo il nome dell'utente
        var data = $("#data").val(); //prelevo la data
        var post = $("#post").val(); //prelevo il valore inserito dall'utente nel textbox

        $.ajax({ //richiama la funzione ajax
            url : "index.php?page=forum", //indirizzo a cui inviare la richesta
            //lista dei dati da passare
            data : {
                azione : "crea_post",
                validazione : true, //serve per permettere, lato server, di capire che si è ricevuta una richiesta ajax
                id_discussione : id_discussione,
                id_utente : id_utente,
                nome_utente : nome_utente,
                data : data,
                post : post
            },
            dataType: "json", //tipo di dati restituiti dal server
            success: function (data){ //funzione da eseguire in caso di successo
                var errore = data.errore; //contiene un eventuale errore reso dal server durante il processo di validazione
                var conferma = data.conferma; /*contiene un eventuale messaggio di conferma reso dal server durante il processo di
                                                validazione*/
                if(errore){ //se c'è un errore
                    /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                    dell'errore al suo interno*/
                    $("p.messaggio").attr("id", "errore").html(errore);
                    $("p.messaggio").show(); //rende visualizzabile il messaggio
                } else if(conferma){ //se c'è una conferma
                    
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        della conferma al suo interno*/
                        $("p.messaggio").attr("id", "conferma").html(conferma);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio

                        // Redirect dopo 0.8 secondi
                        setTimeout(function() {
                          $(location).attr('href', "index.php?page=forum&subpage=discussione&id=" + id_discussione);
                        }, 800);
                  }
            },
            error: function (data){ //funzione da eseguire in caso di insuccesso
                alert("La richiesta non è stata eseguita, si prega di riprovare."); //visualizza un popup con il messaggio d'errore
            }
        });
    });
    
    //funzione per la validazione dell'eliminazione di un post
    $("input#eliminaPost").click(function(event){ //aggancia il click del pulsante "Elimina Post"
          
        event.preventDefault(); //previene che venga eseguita la submit
        
        var id_discussione = $("#id_discussione").val(); //prelevo l'id della discussione
        var form = $(this).parent(); /*partendo dall'input con id=eliminaPost che ha scatenato l'evento (indicato da $(this)) seleziono il primo
                                       elemento genitore, che è il form*/
        var id_post = form.children("input#id_post").val(); /*partendo dal form selezionato prima, seleziono l'elemento figlio che è un tag
                                                              input con id=id_post e ne prelevo il valore*/
        $.ajax({ //richiama la funzione ajax
            url : "index.php?page=forum", //indirizzo a cui inviare la richesta
            //lista dei dati da passare
            data : {
                azione : "elimina_post",
                validazione : true, //serve per permettere, lato server, di capire che si è ricevuta una richiesta ajax
                id_discussione : id_discussione,
                id : id_post
            },
            dataType: "json", //tipo di dati restituiti dal server
            success: function (data){ //funzione da eseguire in caso di successo
                var errore = data.errore; //contiene un eventuale errore reso dal server durante il processo di validazione
                var conferma = data.conferma; /*contiene un eventuale messaggio di conferma reso dal server durante il processo di
                                                validazione*/
                if(errore){ //se c'è un errore
                    /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                    dell'errore al suo interno*/
                    $("p.messaggio").attr("id", "errore").html(errore);
                    $("p.messaggio").show(); //rende visualizzabile il messaggio
                } else if(conferma){ //se c'è una conferma
                    
                        /*seleziono il tag p che ha come classe messaggio, gli imposto l'attributo id="errore" e inserisco il testo html
                        della conferma al suo interno*/
                        $("p.messaggio").attr("id", "conferma").html(conferma);
                        $("p.messaggio").show(); //rende visualizzabile il messaggio

                        // Redirect dopo 0.8 secondi
                        setTimeout(function() {
                          $(location).attr('href', "index.php?page=forum&subpage=discussione&id=" + id_discussione);
                        }, 800);
                  }
            },
            error: function (data){ //funzione da eseguire in caso di insuccesso
                alert("La richiesta non è stata eseguita, si prega di riprovare."); //visualizza un popup con il messaggio d'errore
            }
        });
    });
});
