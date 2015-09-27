<div id="titoloContent">
    <h1>Form di registrazione</h1>
</div> <!-- fine titoloContent -->

<div class="form" id="reg">
    <!-- se durante la validazione della registrazione si ha un qualche messaggio d'errore o conferma esso viene visualizzato qui -->
    <p class="messaggio" id=""></p>
    
    <form method="post" action="index.php?page=registrazione">
    <!-- l'attributo for delle label dev'essere uguale all'attributo id dell'input a cui si riferiscono, in questo modo 
    il browser capisce che sono collegati-->
        <label for="username"><span>Username :</span></label>
        <input type="text" name="username" id="username"/>
        </br>
        <label for="password"><span>Password :</span></label>
        <input type="password" name="password" id="password"/>
        </br>
        <label for="eta"><span>Età :</span></label>
        <input type="text" name="eta" id="eta"/>
        </br>
        <span>Sesso :</span>
        <label for="uomo"><span>Uomo</span></label>
        <input type="radio" name="sesso" id="uomo" value="uomo"/>
        </br>
        <label for="donna"><span>Donna</span></label>
        <input type="radio" name="sesso" id="donna" value="donna"/>
        </br>
        <label for="email"><span>E-mail :</span></label>
        <input type="text" name="email" id="email"/>
        </br>
        <label for="citta"><span>Città :</span></label>
        <input type="text" name="citta" id="citta"/>
        </br>
        <input class="button" id="registrazione" type="submit" value="Registrati"/>
    </form>
    
</div>
