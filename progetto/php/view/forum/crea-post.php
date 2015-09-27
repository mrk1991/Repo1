<div id="titoloContent">
    <h1>Crea post per: <span class="titleInfo"><?=$titolo_discussione?></span></h1>
</div> <!-- fine titoloContent -->

<p class="messaggio" id=""></p>

<?php

if(isset($testo)) //se è settata la variabile $testo significa che si è scelta l'opzione rispondi quotando
    $testo = '<div class="quote"> <em>Originariamente scritto da: ' . $nome_utente . "</em></br>" . $testo . '</div>';
?>

<div class="form">
    <form method="post" action="index.php?page=forum">
        <input type="hidden" name="azione" value="crea_post">
        <!-- l'id della discussione serve per salvare correttamente il nuovo post sul database -->
        <input type="hidden" name="id_discussione" id="id_discussione" value="<?=$id_discussione?>"/>
        <!-- l'id utente serve per salvare correttamente il nuovo post sul database -->
        <input type="hidden" name="id_utente" id="id_utente" value="<?= $_SESSION['userId'] ?>"/>
        <!-- il nome dell'utente viene salvato perchè andrà visualizzato tra le informazioni relative al post -->
        <input type="hidden" name="nome_utente" id="nome_utente" value="<?= $_SESSION['userLogged'] ?>"/>
        <!-- come data e ora di creazione della discussione si prende quella corrente del server -->
        <input type="hidden" name="data" id="data" value="<?= date('d/m/Y H:i:s') ?>"/>
        <textarea name="post" id="post"><?php if(isset($testo)){ echo $testo . "\n\n"; } ?></textarea>
        <input class="button" id="creaPost" type="submit" value="Invia"/>
    </form>        
</div> <!-- toggle form -->
