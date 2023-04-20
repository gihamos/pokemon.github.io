<?php
 require ("./modeles/model.php");


function acceuil(){
    require ("vue_acceuil.php");
}

function afficheerreur($a){
    $msgerreur=$a;
    require("erreur.php");
   
    
    
}

function affichetest(){  
   
    try {
   
        $elementpk=print_r(getAllpokemonbd(),true);
        histomodvoir();
    require("vue_test.php");
        
    } catch (Exception $e) {
         afficheerreur($e->getMessage());
    }

}

function affichemodify(){
    try {
   
        $tab=getAllnamepok();
        if(isset($_POST['Envoyer']))
        if(!is_null($_POST['nompok'])){
        $pok=recherchepok($_POST['nompok']);
            modifiepokemonbd($_POST['nompok'],$_POST['taille'],$_POST['poid']);
        histomod($pok,intval($_POST['taille']),intval($_POST['poid']));
        }
        require("modifier.php");
         
    } catch (Exception $e) {
         afficheerreur($e->getMessage());
    }


}
function affichehistorisation(){
    try {
       $tab=affichehistop("modify");
      $tab1=affichehistop("voir");
        $tab2=affichehistop("other");
        require("./vues/historisation.php");
        
    } catch (Exception $e) {
         afficheerreur($e->getMessage());
    }

}
function afficherpok(){

    try {
           $tab=getAlltype();
           require("afficher.php");
           
    } catch (Exception $e) {
        afficheerreur($e->getMessage());
   }
}
function affichertypepok(){

    try {
        viewjson();
        if(!is_null($_GET["type"]))
     histomodvoir(intval($_GET["type"]));
        
 } catch (Exception $e) {
     afficheerreur($e->getMessage());
}

}
?>
