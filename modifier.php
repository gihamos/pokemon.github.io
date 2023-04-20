<?php ob_start();?>
<h2>Mofifier Pokémon</h2>
<form id="form" action="" method="post">
<label for="namepok">Pokemon </label>
    <select name="nompok" id="namepok">
     <?php     
           foreach($tab as $name){
            print_r($tab);
           echo "<option value=\"$name\" >$name</option>";
           }
           ?>

    </select><br><br>
    <label for="taillepok">Taille </label>
    <input type="number" name="taille" id="taillepok" min=0><br><br>
    <label for="poidpok">Poids </label>
    <input type="number" name="poid" id="poidpok" min=0><br><br>
    <input type="submit" name="Envoyer">
</form>
<?php
$content=ob_get_clean();
$title="Application-Modifier";
require("gabarit.php");
