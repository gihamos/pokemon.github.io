<?php ob_start();?>
<p class="error">Une erreur est survenue: <?=$msgerreur?></p>
<?php
$content=ob_get_clean();
$title="Erreur survenu!";

require("gabarit.php");
?>