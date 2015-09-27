<?php

if(!isset($ajax)){ //se la variabile $ajax è settata non si deve visualizzare una normale pagina, ma quella con i dati json

?>

    <!DOCTYPE html>

    <html>
	    <!--presentazione pagina-->
	    <head>
		    <title> AstroWorld - <?= $vista->getTitolo() ?> </title>
		    <meta charset="utf-8"> <!--codifica caratteri speciali-->
		    <meta name="keywords" content="astro, astri, terra, luna, pianeta, giove, marte, mercurio, nettuno, pianeti nani, saturno, urano,
										    venere, universo, stella, stelle, cielo, costellazione, costellazioni, via lattea, astronomia,
										    telescopio, world"> <!--aiuta i motori di ricerca a trovare la pagina-->
		    <meta name="author" content="Bitshift">
		    <link rel="stylesheet" type="text/css" href="css/astro.css" media="screen"> <!-- Collegamento al documento CSS esterno -->
		    <script type="text/javascript" src="javascript/jquery-2.1.4.min.js"></script> <!-- Collegamento allo script per jquery -->
		    <script type="text/javascript" src="javascript/mostraNascondi.js"></script>
		    <script type="text/javascript" src="javascript/validazione.js"></script>
	    </head>

	    <body>
		    <div id="page">
			    <header>
				    <div id="header">

					    <div id="logo">
						    <h1> AstroWorld </h1>
					    </div> <!-- fine logo -->
					
					    <?php if(isset($_SESSION['loggedIn'])){ //se si è loggati si visualizzano le relative informazioni
                            if($_SESSION['loggedIn'] == true){ ?>
                                <div id="info-log">
                                    Utente: <?= $_SESSION['userLogged'] ?>
                                    <form method="post" action="index.php?page=logout">
                                        <input class="button" id="logout" type="submit" value="Logout"/>
                                    </form>
                                </div>
                     <?php }
                             } ?>
                             
					    <?php
						    require($vista->getHeader());
					    ?>
					
				    </div> <!-- fine header -->
			    </header>

				    <div id="sidebar">
                    	<?php
                    		require($vista->getSidebar());
                    	?>
				    </div> <!-- fine sidebar -->

			    <div id="content">
                    <?php
				        require($vista->getContent());
                    ?>
			    </div> <!-- fine content -->

			    <div id="clear"> </div> <!-- fine clear -->

			    <footer>
				    <div id="footer">

					    <div id="copyright">
						    <p>
							    <strong> AstroWorld </strong>è un sito creato e sviluppato dal team Bitshift composto da Mirko Fadda e Sharon
							    Carta. Tutti i diritti riservati.
						    </p>
					    </div> <!-- fine parte copyright -->

					    <div id="social">
						    <p>
							    Seguici anche su:
						    </p>
						    <ul>
							    <li id="facebook"><a href="https://www.facebook.com/"> Face </a></li>
							    <li id="twitter"><a href="https://twitter.com/"> Twit </a></li>
						    </ul>
					    </div> <!-- fine social -->

				    </div> <!-- fine footer -->
			    </footer>

		    </div> <!-- fine page -->
	    </body>
    </html>
<?php

} else{

    require($vista->getContent());
}
?>
