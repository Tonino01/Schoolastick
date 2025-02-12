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


function logOut() {
  fetch('php/logout.php', {
      method: 'POST', // Usa POST se il logout modifica lo stato del server
      credentials: 'include' // Invia i cookie di sessione se necessari
  })
  .then(response => {
      if (response.ok) {
          window.location.href = 'index.html'; // Reindirizza alla homepage dopo il logout
      } else {
          console.error('Errore nel logout');
      }
  })
  .catch(error => console.error('Errore di rete:', error));
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

  document.getElementById("archivioButton").src = "icone/box_icon.png";

  caricaSegnalazioni();



}

function caricaSegnalazioni() {
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








function dettagliSegnalazione(id) {

  pulisciContenitore();
  fetching('librerie/mostraDettagliSegnalazione.html');

  // Usa l'ID passato come parametro
  caricaDettagli(id);

}





function caricaDettagli(id) {
  fetch('php/caricaDettagliSegnalazioni.php?id=' + id) // Passa l'ID come parametro alla richiesta
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.text();
  })
  .then(data => {
    const dettagliElement = document.getElementById('dettagli');
    if (dettagliElement) {
      // Aggiungi i dettagli nel div con id "dettagli"
      dettagliElement.innerHTML = data;
    } else {
      console.error('Elemento con id "dettagli" non trovato.');
    }
  })
  .catch(error => {
    console.error('Errore nel caricamento dei dettagli:', error);
  });
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


let tmp = false;
function mostraArchivio(){

  if(tmp){

    segnalazioni();

    tmp = false;

  }else{

    pulisciContenitore();

    fetching('librerie/mostraArchivio.html');

    document.getElementById("titolo").innerText = "Archivio Segnalazioni:";

    document.getElementById("archivioButton").src = "icone/indietro-48.png";

    tmp = true;

  }
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
