<?php
 require("controller.php");



if(isset($_GET["action"])){
    if($_GET["action"]=="test")      
               affichetest();
    elseif($_GET["action"]=="modifypok")
           affichemodify() ;   
    elseif($_GET["action"]=="historique")
       affichehistorisation();
    elseif($_GET["action"]=="afficherpok")
       afficherpok();
     elseif($_GET["action"]=="pok"&&(isset($_GET["type"]))&&!empty($_GET["type"]))
     affichertypepok();
     else
     acceuil();
}
else
   acceuil();






?>
