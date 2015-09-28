<div id="titoloContent">
    <h1>Cambia ruolo utenti</h1>
</div> <!-- fine titoloContent -->

<?php
if(!isset($listaUtenti)){
?>
    <p>
        <?= "Impossibile caricare la lista utenti" ?>
    </p>
<?php
} else if($listaUtenti == false){
?>
        <p>
            <?= "Non ci sono utenti registrati" ?>
        </p>
    <?php
    } else{
        ?>
            <div id="cambiaRuoloBanna">
                <ul>
                    <?php
                    foreach($listaUtenti as $utente){
                        if($utente->getUsername() == $_SESSION['userLogged']){
                            echo ""; //se il nome dell'utente corrisponde a quello corrente, non lo visualizza
                        } else{
                        ?>
                            <div class="listaUtenti">
                                <li class="utente" id="<?=$utente->getSesso()?>">
                                    <span><?=$utente->getUsername()?></span>
                                </li>
                                <?php
                                    if($utente->getRuolo() != Utente::Bannato){ //può diventare amministratore/utente solo chi non è bannato
                                ?>
                                    <form class="cambia-ruolo" method="post" action="index.php?page=forum">
                                        <input type="hidden" name="azione" value="cambiaRuolo"/>
                                        <input type="hidden" name="utente" value="<?= $utente->getUsername() ?>"/>
                                        <input type="hidden" name="ruolo" value="<?= $utente->getRuolo() == 1 ? '2' : '1' ?>"/>
                                        <input class="button" id="cRuolo" type="submit"
                                               value="Rendi <?= $utente->getRuolo() == 1 ? 'Utente' : 'Amministratore' ?>"/>
                                    </form>
                                    <?php
                                    }
                                    ?>
                                    <form class="banna" method="post" action="index.php?page=forum">
                                        <input type="hidden" name="azione" value="<?= $utente->getRuolo() == 3 ? 'sblocca' : 'banna' ?>"/>
                                        <input type="hidden" name="utente" value="<?=$utente->getUsername()?>"/>
                                        <input class="button" id="ban" type="submit" 
                                               value="<?= $utente->getRuolo() == 3 ? 'Sblocca' : 'Banna' ?>"/>
                                    </form>
                            </div> <!-- listaUtenti -->
                            <?php
                        }
                    }
                    ?>
                </ul>
             </div> <!-- cambiaRuoloBanna -->
                 <?php
    }
    ?>
