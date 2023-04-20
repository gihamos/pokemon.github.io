<?php ob_start();?>
<h1>Historisation des opérations modifiant la base </h1>
<h2>Modifier</h2>
<table >
<thead>  
<tr>
    <th>Horodatage</th>
    <th>Description</th>
</tr>
</thead>
<?php 
echo"<tbody>";
if(!is_null($tab))
foreach($tab as $elt)
if(!is_null($elt))
echo"<tr><td>".$elt[0]."</td><td>".$elt[1]."</td></tr>";
echo"</tbody>";
?>
</table>
<h2>Voir</h2>
<table >
<thead>
<tr>
    <th>Horodatage</th>
    <th>Description</th>
</tr>
</thead>
<?php 
echo"<tbody>";
if(!is_null($tab1))
foreach($tab1 as $elt)
if(!is_null($elt))
echo"<tr><td>".$elt[0]."</td><td>".$elt[1]."</td></tr>";
echo"</tbody>";
?>
</table>
<h2>Autre</h2>
<table >
<thead>
<tr>
    <th>Horodatage</th>
    <th>Description</th>
</tr>
</thead>
<?php 
echo"<tbody>";
if(!is_null($tab2))
foreach($tab2 as $elt)
if(!is_null($elt))
echo"<tr><td>".$elt[0]."</td><td>".$elt[1]."</td></tr>";
echo"</tbody>";
?>
</table>
<?php
$content=ob_get_clean();
$title="Application-Historisation";
require("gabarit.php");
?>