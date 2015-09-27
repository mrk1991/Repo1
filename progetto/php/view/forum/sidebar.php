<div class="titoloSidebar" id="forumSide">
    <h3> Forum </h3>
</div> <!-- fine titoloSidebar -->

<p>
   	Benvenuto sul nostro forum
   	<?php
   	    if(isset($_SESSION['userLogged']))
   	        echo "<strong>".$_SESSION['userLogged']."</strong>";
   	?>.
</p>

<p>
    Categorie:
    <?php
    if(!isset($listaCategorie)){ //si è verificato un errore durante il caricamento delle categorie
    ?>
        <p>
            <?= "Impossibile caricare la lista delle categorie." ?>
        </p>
    <?php
    } else if($listaCategorie == false){ //non sono presenti categorie nel database
         ?>
              <p>
                  <?= "Non sono presenti categorie." ?>
              </p>
         <?php
         } else{ //sono presenti delle categorie e le visualizzo
         ?>
   	        <ul id="categorieSidebar">
   	        <?php
   	        foreach($listaCategorie as $category){
   	            ?>
   	            <li><a href="index.php?page=forum&subpage=categoria&id=<?=$category->getId()?>">
   	                   <?=$category->getNome()?>
   	                </a>
   	            </li>
   	        <?php
   	        }
   	        ?>
   	        </ul>
   	     <?php
   	     }
   	     ?>
</p>
