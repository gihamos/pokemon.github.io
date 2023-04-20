
<?php ob_start();?>
<h2>Afficher Pokémon</h2>
<p><label for="type">Types: </label>
<select name="nametype" id="type">
<option value="---" >---</option>   
     <?php  
           foreach($tab as $name){
           echo "<option value=\"".$name->getid()."\" >".$name->getnom()."</option>";
           }
           ?>
</select>           
</p>
<div id="cont"></div>
<?php
echo "<script type=\"text/javascript\" src=\"pokemon.js\"></script>";
$content=ob_get_clean();
$title="Application-Afficher";
require("gabarit.php");
?>
