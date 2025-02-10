//inizializazione degli oggetti

const segnalazione = {

  descrizione: "",
  categoria: "",
  aula:"",
  piano: "",
  stato: "",
  perChi: "",
  daChi: "",
  risoluzione: ""

};


function logOut(){

  window.location.href = "index.html";

}

//ottimizazione fetch
async function fetching(risorsa) {

    try {
        const response = await fetch(risorsa);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const html = await response.text(); // Ottieni il contenuto del file come testo
        // Salva il contenuto in una variabile
        const codiceHTML = html;

        // Puoi anche inserire il codice HTML in un elemento della pagina
        document.getElementById('contenitore').innerHTML = codiceHTML;

        console.log(codiceHTML); // Stampa il codice HTML nella console
    } catch (error) {
        console.error('Si è verificato un errore:', error);
    }
}
//trovare soluzioni per transizioni
function transizione(container){

  document.getElementById(container).classList.add('div-animate');

}

function pulisciContenitore(){

  document.getElementById("contenitore").innerHTML = '';

}


function segnalazioni(){

  pulisciContenitore();
  fetching('librerie/mostraSegnalazioni.html');




  document.getElementById("titolo").innerText = "Segnalazioni:";

  caricaDettagli();



}

function caricaDettagli() {
  fetch('php/caricaSegnalazioniDB.php') // Qui chiami il file PHP
  .then(response => response.text())
  .then(data => {
    // Aggiungi i dettagli nel div con id "dettagli
    document.getElementById('dettagli').innerHTML = data;
  })
  .catch(error => {
    console.error('Errore nel caricamento dei dettagli:', error);
  });
}

function dettagliSegnalazione(){

  pulisciContenitore();
  fetching('librerie/mostraDettagliSegnalazione.html');

}

function nuovaSegnalazione(){

  pulisciContenitore();

  fetching('librerie/nuovaSegnalazione.html');

  document.getElementById("titolo").innerText = "Creazione Segnalazione:"



}

function mostraInfoAccount(){

  pulisciContenitore();


  fetching('librerie/infoAccount.html');

  document.getElementById("titolo").innerText = "Informazioni sull'Account:"

}

function mostraArchivio(){

  pulisciContenitore();

  fetching('librerie/mostraArchivio.html');

  document.getElementById("titolo").innerText = "Archivio Segnalazioni:"

}

function getUtente(){

  //DA FARE!!!!

}

function creaNuovaSegnalazione(){


  segnalazione.descrizione = document.getElementById("descrizione").value;

  let selectElement = document.getElementById('categoria');


  let categoria = selectElement.options[selectElement.selectedIndex];


  categoria = categoria.value;

  segnalazione.categoria = categoria;

  segnalazione.aula = tempAula;

  segnalazione.piano = tempPiano;

  segnalazione.stato = "DA FARE";

  segnalazione.daChi = getUtente();

  if(categoria == "Pulire"){

    segnalazione.perChi = "Collaboratore";

  }else{

    segnalazione.perChi = "Tecnico";

  }

  alert("segnalazione effettuata!!");


  //inviare la segnalazione al DataBase




  segnalazioni();
}
