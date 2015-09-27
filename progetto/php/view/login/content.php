<div class="form">
    
    <!-- se durante la validazione del login si ha un qualche messaggio d'errore o conferma esso viene visualizzato qui -->
    <p class="messaggio" id=""></p>
    
    <form method="post" action="index.php?page=login">
    <!-- l'attributo for delle label dev'essere uguale all'attributo id dell'input a cui si riferiscono, in qst modo 
    il browser capisce che sono collegati-->
        <label for="username"><span>Username :</span></label>
        <input type="text" name="username" id="username"/>
        </br>
        <label for="password"><span>Password :</span></label>
        <input type="password" name="password" id="password"/>
        </br>
        <input class="button" id="login" type="submit" value="Login"/>
    </form>
    
    <hr/> <!-- inserisce una linea che separa il form del login dal pulsante per la registrazione -->
    
    <p class="registra">
        Non sei registrato?
    </p>
            
    <form class="registra" method="post" action="index.php?page=registrazione"> <!-- rimanda a una pagina in cui è presente il form
                                                                                               per effettuare la registrazione -->
        <input class="button" type="submit" value="Registrati"/>
    </form>
            
</div>
