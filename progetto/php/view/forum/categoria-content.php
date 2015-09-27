<div id="titoloContent">
    <h1><?= $categoria->getNome() ?></h1> <!-- $categoria è l'istanza della categoria che si vuole visualizzare passata dal controlloreForum -->
</div> <!-- fine titoloContent -->
           
<div class="form" id="newDisc">
    <?php
    if(($categoria->getNome() == 'Regolamento') && ($_SESSION['userRole'] == 2)){ /*se si è nella categoria Regolamento e non si è amministratori
                                                                                    il form per la creazione di una nuova discussione non
                                                                                    dev'essere visualizzato*/
        echo "";
    } else{
    ?>
    <form method="post" action="index.php?page=forum&subpage=categoria">
        <!-- l'id della categoria serve per la creazione della discussione -->
        <input type="hidden" name="idCategoria" value="<?=$categoria->getId()?>"/>
        <!-- il nome della categoria serve come informazione per la pagina in cui è presente il form per creare la discussione -->
        <input type="hidden" name="nomeCategoria" value="<?=$categoria->getNome()?>"/>
        <input class="button" id="nuovaDiscussione" name="submit-newdisc" type="submit" value="Nuova discussione"/>
    </form>
    <?php
    }
    ?>
</div>

<?php
    $discussioni = $categoria->getListaDiscussioni(); //$discussioni è un array contenente elementi di tipo Discussione
    if(!isset($discussioni)){ //se la lista è null significa che si è verificato un errore durante il caricamento dal database
    ?>
        <p class="messaggio" id="errore">
            <?= "Errore: impossibile caricare la lista delle discussioni" ?>
        </p>
    <?php
    }
    else if($discussioni == false){ //se è false significa che non ci sono discussioni per la categoria
        ?>
        <p class="messaggio" id="errore">
            <?= "Non sono presenti discussioni per questa categoria" ?>
        </p>
        <?php
        } else{ //altrimenti visualizza la lista delle discussioni. Visualizza titolo, nome utente, data e ora
            ?>
            <div id="listaDiscussioni">
                <ul>
                <?php
                foreach($discussioni as $discussione){
                ?>
                    <div class="contenitoreVoce">
                        <li class="voceSingola">
                            <a href="index.php?page=forum&subpage=discussione&id=<?=$discussione->getId()?>">
                                <?=$discussione->getTitolo()?>
                            </a>
                        </li>
                        <p class="creatore"> di <span><?=$discussione->getNomeUtente()?></span></p>
                        <p class="dataOra"><span><?=$discussione->getDataOra()?></span></p>
                    </div>
                <?php
                }
                ?>
                </ul>
            </div>
        <?php
        }
        ?>
