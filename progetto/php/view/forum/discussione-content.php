<div id="titoloContent">
    <h1><?= $discussione->getTitolo() ?></h1>
    <!-- $discussione è l'istanza della discussione che si vuole visualizzare passata dal controlloreForum -->
</div> <!-- fine titoloContent -->

<p class="messaggio" id=""></p>

<div class="form" id="delDisc">
    <?php
    if($_SESSION['userRole'] == 2){ /*se non si è amministratori, il form per l'eliminazione della discussione non dev'essere visualizzato*/
        echo "";
    } else{
    ?>
    <form method="post" action="index.php?page=forum">
        <input type="hidden" name="azione" value="elimina_discussione"/>
        <!-- l'id della discussione serve per la sua eliminazione -->
        <input type="hidden" name="id_discussione" id="id_discussione" value="<?=$discussione->getId()?>"/>
        <!-- l'id della categoria serve per la corretta redirezione della pagina dopo aver eliminato la discussione -->
        <input type="hidden" name="id_categoria" id="id_categoria" value="<?=$discussione->getIdCategoria()?>"/>
        <input class="button" id="eliminaDiscussione" type="submit" value="Elimina Discussione"/>
    </form>
    <?php
    }
    ?>
</div>

<?php
    $post = $discussione->getListaPost(); //$post è un array contenente elementi di tipo Post
    if(!isset($post)){ //se la lista è null significa che si è verificato un errore durante il caricamento dal database
    ?>
        <p>
            <?= "Impossibile caricare i post" ?>
        </p>
    <?php
    }
    else if($post == false){ //se è false significa che non ci sono post per la discussione
        ?>
        <p>
            <?= "Non sono presenti post per questa discussione" ?>
        </p>
        <?php
        } else{ //altrimenti visualizza la lista dei post
            ?>
            <div id="listaPost">
                <?php
                foreach($post as $singlePost){
                ?>
                    <div class="contenitorePost">
                        <div class="infoUtente">
                            <span> Scritto da: <span class="creatorePost"><?=$singlePost->getNomeUtente()?></span></span>
                            <span  class="dataOraPost">Pubblicato il: <?=$singlePost->getDataOra()?></span>
                        </div>
                        <div class="testo">
                            <p id="paragrafoPost">
                                <?=$singlePost->getTesto()?>
                            </p>
                        </div>
                        <div id="rispondi-elimina">
                            <div class="form" id="delPost">
                                <?php
                                if($_SESSION['userRole'] == 2){ /*se non si è amministratori, il form per l'eliminazione del post non
                                                                  dev'essere visualizzato*/
                                    echo "";
                                } else{
                                ?>
                                <form method="post" action="index.php?page=forum">
                                    <input type="hidden" name="azione" value="elimina_post"/>
                                    <!-- l'id della discussione serve per la corretta redirezione della pagina dopo aver eliminato il post -->
                                    <input type="hidden" name="id_discussione" id="id_discussione" value="<?=$discussione->getId()?>"/>
                                    <!-- l'id del post serve per la sua eliminazione -->
                                    <input type="hidden" name="id_post" id="id_post" value="<?=$singlePost->getId()?>"/>
                                    <input class="button" id="eliminaPost" type="submit" value="Elimina post"/>
                                </form>
                                <?php
                                }
                                ?>
                            </div> <!-- class=form id=delPost-->
                            <div class="form" id="reply-quote">
                                <?php
                                if($discussione->getIdCategoria() == 1){ /*il form per rispondere a un post non dev'essere visualizzato se ci si
                                                                           trova nella categoria "Regolamento"*/
                                    echo "";
                                } else{
                                ?>
                                <form method="post" action="index.php?page=forum&subpage=discussione">
                                    <!-- l'id della discussione serve per il corretto salvataggio del post sul database -->
                                    <input type="hidden" name="id_discussione" value="<?=$discussione->getId()?>"/>
                                    <!-- il titolo della discussione serve per compilare la pagina contenente il form per creare il post -->
                                    <input type="hidden" name="titolo_discussione" value="<?= $discussione->getTitolo() ?>"/>
                                    <!-- il nome dell'utente serve per visualizzarlo nel richiamo del post che si vuole quotare -->
                                    <input type="hidden" name="nome_utente" value="<?=$singlePost->getNomeUtente()?>"/>
                                    <!-- il testo del messaggio serve per poter quotare -->
                                    <input type="hidden" name="testo" value='<?=$singlePost->getTesto()?>'/>
                                    <input class="button" id="rispondiQuotando" type="submit" name="submit-repQuote" value="Rispondi quotando"/>
                                </form>
                                <?php
                                }
                                ?>
                            </div> <!-- class=form id=reply-quote -->
                            <div class="form" id="reply">
                                <?php
                                if($discussione->getIdCategoria() == 1){ /*il form per rispondere a un post non dev'essere visualizzato se ci si
                                                                           trova nella categoria "Regolamento"*/
                                    echo "";
                                } else{
                                ?>
                                <form method="post" action="index.php?page=forum&subpage=discussione">
                                    <!-- l'id della discussione serve per salvare correttamente il nuovo post sul database -->
                                    <input type="hidden" name="id_discussione" value="<?=$discussione->getId()?>"/>
                                    <!-- il titolo della discussione serve per compilare la pagina contenente il form per creare il post -->
                                    <input type="hidden" name="titolo_discussione" value="<?= $discussione->getTitolo() ?>"/>
                                    <input class="button" id="rispondi" type="submit" name="submit-reply" value="Rispondi"/>
                                </form>
                                <?php
                                }
                                ?>
                            </div> <!-- class=form id=reply-->
                        </div> <!-- rispondi-elimina -->
                    </div> <!-- contenitore post -->
                <?php
                }
                ?>
            </div> <!-- lista post -->
        <?php
        }
        ?>
