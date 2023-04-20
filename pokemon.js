document.querySelector("#type").addEventListener('change',function(e){
   let url="index.php?action=pok&type="+document.querySelector("#type").value;
   if(document.querySelector("#type").value!="---"){
   let myrequest= new Request(url);
   fetch(myrequest)
   .then (function(reponse){
    if(!reponse.ok)
    throw new Error("HTTP error, status= "+reponse.status)
    return reponse.json();
   })
   .then(function(rep){
    let page= document.querySelector("#cont");
   page.childNodes.forEach(element=>{
    page.removeChild(element);
})
    let table=document.createElement("table");
    let tr1=document.createElement("tr");
    let nom=document.createElement("th");
    nom.textContent="Nom";
     tr1.appendChild(nom);
    let taille=document.createElement("th");
    taille.textContent="Taille";
     tr1.appendChild(taille);
     let poid=document.createElement("th");
    poid.textContent="Poids";
     tr1.appendChild(poid);
     table.appendChild(tr1)
     rep.forEach(element => {
        let tr=document.createElement("tr");
         let td1=document.createElement("td");
         td1.textContent=element.pok_name;
         tr.appendChild(td1);
         let td2=document.createElement("td");
         td2.textContent=element.pok_height;
         tr.appendChild(td2);
         let td3=document.createElement("td");
         td3.textContent=element.pok_weight;
         tr.appendChild(td3);
       table.appendChild(tr); 
    });
    page.appendChild(table);
    let test=document.createElement("p");
    test.innerHTML="<?php  histomodvoir("+document.querySelector("#type").value+"); ?>";
    page.appendChild(test);

   })
   .catch(function(error){
    document.querySelector("#content").innerHTML="Error "+error.message;
   });
}
else{
    let page= document.querySelector("#cont");
        page.childNodes.forEach(element=>{
            page.removeChild(element);
        })
  }
});