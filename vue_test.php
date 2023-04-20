<?php 
$content=null;
ob_start(); ?>
<p id="test">   
    <?= $elementpk ?>
</p>
<?php 
$content=ob_get_clean();
$title="Application-test";
require("gabarit.php");





?>