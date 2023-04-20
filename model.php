<?php 
class type{
private $id;
private $nom;

public function __construct(int $id,string $nom){
    $this->id=$id;
    $this->nom=$nom;
}
public function getid():int{
    return $this->id;
}
public function getnom():string{
    return $this->nom;
}

public function settid(int $id){
    $this->id=$id;
}
public function setnom(string $nom){
    $this->nom=$nom;
}
}



class pokemon{
private $id;    
private $nom;
private $taille;
private $poids;
private $tab;
public function __construct(int $id,string $nom,int $taille,int $poids,array $types=null)
{   
    $this->id=$id;
    $this->nom=$nom;
    $this->taille=$taille;
    $this->poids=$poids;
    if(!is_null($types)){
    foreach ($types as $element) 
    if (!($element instanceof type)) 
      throw new InvalidArgumentException('Le tableau doit contenir uniquement des objets de la classe type.');  
    $this->tab=$types;
    }
    
}
public function getid():int{
    return $this->id;
}

public function getnom():string{
    return $this->nom;
}

public function gettaille():int{
    return $this->taille;
}

public function getpoids():int{
    return $this->poids;
}

public function gettype(): array{
    return $this->tab;
}

public function setid(int $id){
     $this->id=$id;
}

public function setnom(string $nom){
 $this->nom=$nom;
}

public function settaille(int $taille){
    $this->taille=$taille;
   }

public function setpoids(int $poids){
    $this->poids=$poids;
   }
   
public function settype(array $tab){
    foreach ($tab as $element) 
        if (!($element instanceof type)) 
          throw new InvalidArgumentException('Le tableau doit contenir uniquement des objets de la classe type.');
          $this->tab=$tab;
}
   

public function ajoutetype(type $a){

array_push($this->tab,$a);
  }

}

function connexpdo(string $db="pokemon"){
    $sgbd="mysql"; // à modifier au besoin
   $host="localhost";// à modifier au besoin
   $port="3306";// à modifier au besoin
   $charset="UTF8";
   $user="gihamos";// à modifier au besoin
   $pass="11229978";// à modifier au besoin
   
   
        $pdo=new pdo("$sgbd::host=$host;port=$port;dbname=$db;charset=$charset",$user,$pass,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
       
        return $pdo;
  
   }
//return un pokemon
 function getpokemon(int $id,string $nom,int $taille,int $poids,array $types=null):pokemon{
    return new pokemon($id,$nom,$taille,$poids,$types);
 }
//recherche un pokemon dans la db à travers son nom et return le pokemon
function recherchepok(string $nom):pokemon{
  $pdo=connexpdo();
  $str="SELECT * FROM pokemon WHERE pok_name='$nom'";
  $stt=$pdo->query($str);
  $tab=$stt->fetch(PDO::FETCH_NUM);
  $pdo=null;
  return getpokemon(intval($tab[0]),$tab[1],intval($tab[2]),intval($tab[3]));

}
//fonction permettant de creer un type de pokemon
function getypepo(int $id,string $nom):type{
    return new type($id,$nom);
}

//fonction qui permet de retourner un array tous les pokemons present dans la db et leur type
function getAllpokemonbd():array{
$pdo=connexpdo();
$str1="SELECT*FROM pokemon";
$stt=$pdo->query($str1);
$tab=$stt->fetchAll(PDO::FETCH_NUM);
$pdo=null;
$pokemons=[];
foreach($tab as $pok){
  $pdo=connexpdo();  
$str2="SELECT t.type_id, t.type_name FROM types t JOIN pokemon_types p ON t.type_id=p.type_id WHERE p.pok_id=:val";
$stt1=$pdo->prepare($str2);
$stt1->execute(['val' => $pok[0]]);
$typ=$stt1->fetchAll(PDO::FETCH_NUM);
$types=[];
foreach($typ as $ta){
array_push($types,getypepo($ta[0],$ta[1]));
}

array_push($pokemons,getpokemon($pok[0],$pok[1],$pok[2],$pok[3],$types));


}
$pdo=null;
return $pokemons;

}

//fonction qui permet de retpurner un array des nom de tous les pokemon de la db
function getAllnamepok():array{
    $pdo=connexpdo();
    $str1="SELECT pok_name FROM pokemon ORDER BY pok_name ASC";
    $stt=$pdo->query($str1);
    $tab=[];
    foreach($stt->fetchAll(PDO::FETCH_NUM) as $t)
      array_push($tab,$t[0]);
      $pdo=null;
      return $tab;

}

//fonction qui permet de modifier le poid et la taille d'un pok dans la db
function modifiepokemonbd(string $name,string $taille,string $poid){
    $pdo=connexpdo();  
    $str="UPDATE pokemon SET pok_height=:t, pok_weight=:p Where pok_name='$name'";
    $stt1=$pdo->prepare($str);
    $stt1->execute(['p' => $poid,'t'=>$taille]);
    $pdo=null;

}

//fonction qui permet de sauvegarder les modification d'un pokemon dans le ficher xml
//$pok: le pokemon à modifier,$taille: la nouvelle taille,$poids: le nouveau poids
function histomod(pokemon $pok,int $taille,int $poids){
    testcrerrxml('./public/xml/histo1.xml');
    
    $xml=new DOMDocument('1.0',"utf-8");
    $xml->load('./public/xml/histo1.xml');
    $root = $xml->documentElement;
    $operation=$xml->createElement("operation");
     $operation->appendChild($xml->createElement("type","modify"));
    $operation->appendChild($xml->createElement("horodate",date('Y-m-d H:i:s')));
    $desc=$xml->createElement("desc");
    $desc->textContent="La taille ( ".$pok->gettaille()."->".$taille.") et le poids (".$pok->getpoids()."->".$poids.") de ".$pok->getnom()." [id=".$pok->getid()."] modifiés";
    $operation->appendChild($desc);
    $root->appendChild($operation);
    if($xml->validate())
    $xml->save('./public/xml/histo1.xml');
    else
      throw new Exception("Impossible de valider le document XML");
}

//fonction retournant un array qui contient l'ensemble des operations d'historisation present dans le ficher xml de type:$type
function affichehistop(string $type):array{
    testcrerrxml('./public/xml/histo1.xml');
    $xml=new DOMDocument('1.0',"utf-8");
    $xml->load('./public/xml/histo1.xml');
    $root = $xml->documentElement;
    $nodes=$root->getElementsByTagName("operation");
    $tab1=[];
    foreach($nodes as $item){
        $tab=[];
        if($item->nodeType==XML_ELEMENT_NODE)
            if($item->firstChild->nodeValue==$type){
            array_push($tab,$item->childNodes[1]->textContent,$item->childNodes[2]->textContent);
            if(!is_null($tab))
        array_push($tab1,$tab);
            }
        }
      return $tab1;

}

//fonction qui permet de sauvegarder l'ensemble des actions faites sur les pokemon hors mofification dans le ficher xml
//si $a est null alors c'est le menu test sinon c'est le menu afficher
function histomodvoir(int $a=null){
  testcrerrxml('./public/xml/histo1.xml');

    $xml=new DOMDocument('1.0',"utf-8");
    $xml->load('./public/xml/histo1.xml');
    $xml->validateOnParse=true;
    $root = $xml->documentElement;
    $operation=$xml->createElement("operation");
     $operation->appendChild($xml->createElement("type","voir"));
     $operation->appendChild($xml->createElement("horodate",date('Y-m-d H:i:s')));
        if(!is_null($a)&&$a>=0)
        $operation->appendChild($xml->createElement("desc","Récupération des Pokemon pour le type d'id=".$a));
        else
        $operation->appendChild($xml->createElement("desc","Récupérations de tous les Pokemon et leurs type en base."));
        $root->appendChild($operation);
        if($xml->validate())
        $xml->save('./public/xml/histo1.xml');
        else
        throw new Exception("Impossible de valider le document XML");
       
}

// fonction permettant de creer un ficher xml s'il n'existe pas déjà et sauvegarder sa date de creation dans le ficher
 function testcrerrxml(string $dir){
    libxml_use_internal_errors(true);
    if(!file_exists($dir)){
       $xml1 = new DOMDocument('1.0', 'utf-8');
      $dtd= $xml1->implementation->createDocumentType('operations', '', 'histo.dtd');
      $xml1->appendChild($dtd);
      $xml1->validateOnParse=true;
       $root = $xml1->createElement('operations');
       $operation=$xml1->createElement("operation");
        $operation->appendChild($xml1->createElement("type","other"));
       $operation->appendChild($xml1->createElement("horodate",date('Y-m-d H:i:s')));
       $operation->appendChild($xml1->createElement("desc","Creation d'un ficher XML"));
       $root->appendChild($operation);
       $xml1->appendChild($root);
       $xml1->save($dir);     
      
    }

 }
//permet de recuperer tous les types de pok dans la db
 function getAlltype():array{
    $pdo=connexpdo();
    $str1="SELECT *FROM types ORDER BY type_name ASC";
    $stt=$pdo->query($str1);
    $tab=[];
    foreach($stt->fetchAll(PDO::FETCH_NUM) as $t)
      array_push($tab,getypepo($t[0],$t[1]));
      $pdo=null;
      return $tab;

 }
 //return le type de pok de la db
 function gettypeid(string $name):string{
    $pdo=connexpdo();
    $str1="SELECT type_id FROM types WHERE type_name='$name'";
    $stt=$pdo->query($str1);
    $stt->fetch(PDO::FETCH_NUM);
      $pdo=null;
      return $stt[0];
 }
 //fonction qui un array qui contient un les nom du pok ainsi que leur poid et leur taille selon le type selectionner
function getpokemonbd(string $idtype):array{
    $pdo=connexpdo();
    $str="SELECT p.pok_name,p.pok_height,p.pok_weight FROM pokemon p JOIN pokemon_types t ON p.pok_id=t.pok_id WHERE t.type_id=:k ORDER BY p.pok_name ASC";
    $stt1=$pdo->prepare($str);
$stt1->execute(['k' => $idtype]);
$tab=$stt1->fetchAll(PDO::FETCH_ASSOC);
$pdo=null;
 return $tab;
}
// return le resulat de la function getpokemondb sous forme de json
function viewjson(string $typeid="type"){
    header("Content-Type: application/json; charset=UTF-8");
    if(isset($_GET[$typeid])){
       echo json_encode(getpokemonbd($_GET["type"]));
    }  
}
?>
