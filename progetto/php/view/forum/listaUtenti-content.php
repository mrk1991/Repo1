<div id="titoloContent">
    <h1>Lista utenti registrati</h1>
</div> <!-- fine titoloContent -->

<div id="tabella">
    <?php
    if(!isset($listaUtenti)){
    ?>
        <p class="messaggio" id="errore">
            <?="Errore: impossibile caricare la lista utenti"?>
        </p>
    <?php
    } else if($listaUtenti == false){
        ?>
            <p class="messaggio" id="errore">
                <?="Non ci sono utenti registrati"?>
            </p>
        <?php
        } else{
            ?>
                <table>
                    <tr class="intestazione">
                        <th>Username</th>
                        <th>Password</th>
                        <th>Età</th>
                        <th>Sesso</th>
                        <th>E-mail</th>
                        <th>Città</th>
                        <th>Ruolo</th>
                    </tr>
                    <?php  
                    $contatore = 1; //variabile utilizzata per impostare la classe delle righe pari della tabella
                    foreach($listaUtenti as $utente){    
                    ?>
                       <tr <?= $contatore % 2 == 0 ? 'class="pari"' : '' ?>>
                          <td><?=$utente->getUsername()?></td>
                          <td><?=$utente->getPassword()?></td>
                          <td><?=$utente->getEta()?></td>
                          <td><?=$utente->getSesso()?></td>
                          <td><?=$utente->getEmail()?></td>
                          <td><?=$utente->getCitta()?></td>
                          <td>
                             <?php
                             switch($utente->getRuolo()){
                                 case Utente::Amministratore:
                                      echo "Amministratore";
                                      break;
                                 case Utente::User:
                                     echo "Utente";
                                     break;
                                 case Utente::Bannato:
                                     echo "Bannato";
                                     break;
                             }
                             ?>
                          </td>
                       </tr>
                       <?php
                       $contatore++;
                    }
                    ?>  
                </table>
                <?php   
            } 
            ?>
</div> <!-- tabella -->
