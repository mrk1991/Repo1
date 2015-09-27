<div id="titoloContent">
    <h1>Crea discussione per: <span class="titleInfo"><?=$nome_categoria?></span></h1>
</div> <!-- fine titoloContent -->

<p class="messaggio" id=""></p>

<div class="creaDisc">
    <form method="post" action="index.php?page=forum">
        <input type="hidden" nae="azione" value="crea_discussione"/>
        <!-- l'id della categoria serve per salvare correttamente la nuova discussione sul database -->
        <input type="hidden" name="id_categoria" id="id_categoria" value="<?=$id_categoria?>"/>
        <!-- il nome della categoria serve per impostare correttamente la pagina in cui si viene portati dopo aver compilato il form -->
        <input type="hidden" name="nome_categoria" id="nome_categoria" value="<?=$nome_categoria?>"/>
        <!-- l'id utente serve per salvare correttamente la nuova discussione sul database -->
        <input type="hidden" name="id_utente" id="id_utente" value="<?= $_SESSION['userId'] ?>"/>
        <!-- il nome dell'utente viene salvato perchè andrà visualizzato tra le informazioni relative alla discussione -->
        <input type="hidden" name="nome_utente" id="nome_utente" value="<?= $_SESSION['userLogged'] ?>"/>
        <!-- come data e ora di creazione della discussione si prende quella corrente del server -->
        <input type="hidden" name="data" id="data" value="<?= date('d/m/Y H:i:s') ?>"/>
        <label for="titolo"><span>Titolo :</span></label>
        <input type="text" name="titolo" id="titolo"/>
        </br>
        </br>
        <label for="post"><span>Post :</span></label>
        <textarea name="post" id="firstPost"></textarea>
        <input class="button" id="creaDiscussione" type="submit" value="Crea"/>
    </form>        
</div>
