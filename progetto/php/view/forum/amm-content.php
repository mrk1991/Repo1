<div id="titoloContent">
    <h1>Funzioni amministratore</h1>
</div> <!-- fine titoloContent -->

</br>

<div id="listaFunzioniAmm">
    <ul>
        <div class="contenitoreFunzioni">
        
            <li class="funzione">
                <a id="addCategoria">Aggiungi una categoria per le discussioni</a>
            </li>
                    
            <p class="messaggio" id=""></p>
                    
            <div class="form">
            
                <form class="toggle" method="post" action="index.php?page=forum">
                    <input type="hidden" name="azione" value="addCategory"/>
                    <label for="nomeCategoria"><span>Categoria :</span></label>
                    <input type="text" name="nomeCategoria" id="nomeCategoria"/>
                    </br>
                    <input class="button" id="creaCategoria" type="submit" value="Inserisci"/>
                </form>
                
            </div> <!-- form -->
            
        </div> <!--contenitoreFunzioni -->  
         
        <div class="contenitoreFunzioni">
        
            <li class="funzione">
                <a id="listaUtenti" href="index.php?page=forum&subpage=listaUtenti">Visualizza la lista degli utenti</a>
            </li>
            
        </div> <!--contenitoreFunzioni -->
        
        <div class="contenitoreFunzioni">
        
            <li class="funzione">
                <a id="ruolo-banna" href="index.php?page=forum&subpage=cambiaRuolo_Banna">Cambia ruolo o banna un utente</a>
            </li>

        </div> <!--contenitoreFunzioni-->
        
    </ul> <!--funzioniAmm-->
</div> <!--listaFunzioniAmm-->
