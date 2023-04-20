<?php ob_start();?>
<div id="home">
<h1 >Bienvenue dans l'application</h1>
<img src="./public/images/logopokemon.png" alt="Logo de la franchise pokémon"/>

</div>
<?php
$content=ob_get_clean();
$title="Application-Acceuil";
require("gabarit.php");
?>






