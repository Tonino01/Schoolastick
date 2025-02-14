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

function dettagliSegnalazione(id_segnalazione) {
  pulisciContenitore(); // Pulisce il contenitore dei dettagli
  fetching('librerie/mostraDettagliSegnalazione.html'); // Carica il template HTML per la visualizzazione

  // Usa l'ID passato come parametro
  caricaDettagliSegnalazioni(id_segnalazione);

  document.getElementById("titolo").innerText = "DETTAGLI SEGNALAZIONE";
}

function caricaDettagliSegnalazioni(id_segnalazione) {
  const formData = new FormData();
  formData.append('id', id_segnalazione);

  // Effettua la richiesta POST al server
  fetch('php/caricaDettagliSegnalazioni.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.text()) // Gestisce la risposta del server come testo
  .then(data => {
    // Aggiungi i dettagli nel div con id "dettagli"
    document.getElementById('dettagli').innerHTML = data;
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

  fetching('librerie/InfoAccount.html');
  document.getElementById("titolo").innerText = "INFORMAZIONI ACCOUNT";

  caricaDettagliUtente();


}




async function caricaDettagliUtente() {
  fetch('php/caricaDettagliUtente.php') // Qui chiami il file PHP
  .then(response => response.text())
  .then(data => {
    // Aggiungi i dettagli nel div con id "dettagli
    document.getElementById('dettagli').innerHTML = data;
  })
  .catch(error => {
    console.error('Errore nel caricamento dei dettagli:', error);
  });
}

let tempPiano = "";
let tempAula = "";

function seminterratoButton(){

  tempPiano = "Seminterrato";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Seminterrato.html');

}
function palestraButton(){

  tempPiano = "Palestra";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Palestra.html');

}
function pianoTerraButton(){

  tempPiano = "Piano Terra";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - PianoTerra.html');

}
function intermedio1Button(){

  tempPiano = "Intermedio 1";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - intermedio1.html');

}
function piano1Button(){

  tempPiano = "Piano 1";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Piano1.html');

}
function intermedio2Button(){

  tempPiano = "Intermedio 2";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - intermedio2.html');

}
function piano2Button(){

  tempPiano = "Piano 2";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - piano2.html');

}

function creaSegnalazione(aula){
  tempAula = aula;

  pulisciContenitore();
  fetching('librerie/mostraCreaSegnalazione.html');

  setTimeout(function() { console.log('Attesa completata. Continuo con la funzione.');
    document.getElementById('aulaSezione').innerText = tempAula;
  }, 500);

}

function indietro(){

  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - ' +tempPiano.replace(/\s+/g, '')+ '.html');

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
  return "Tecnico";

}

function getStato(){

  //DA FARE!!!!
  return "Da Fare";

}

function setStato(stato){

  return stato;

  //DA FARE!!!!

}



function buttonCompletaSegnalazione(buttonContainer) {


  if(getUtente() == "Tecnico" || getUtente() == "Amministratore"){

    if(getStato() == "Da Fare"){

      buttonContainer.onclick = function() { contrassegnaInCorso(buttonContainer); };
      buttonContainer.style.backgroundColor = "#D78605";
      buttonContainer.style.borderColor = "#D78605";
      buttonContainer.textContent = 'CONTRASSEGNA COME IN CORSO';

    }else if(getStato() == "In Corso"){

      buttonContainer.onclick = function() { mostraScriviReport(buttonContainer); };
      buttonContainer.style.backgroundColor = "#0A9B02";
      buttonContainer.style.borderColor = "#0A9B02";
      buttonContainer.textContent = 'CONTRASSEGNA COME COMPLETATA';

    }
  }else{

    buttonContainer.style.display = "none";

  }

}

function contrassegnaInCorso(buttonContainer){




  setStato("In Corso");

  buttonContainer.onclick = function() { contrassegnaCompletata(buttonContainer); };
  buttonContainer.style.backgroundColor = "#D78605";
  buttonContainer.style.borderColor = "#D78605";
  buttonContainer.textContent = 'CONTRASSEGNA COME IN CORSO';


}

function contrassegnaCompletata(buttonContainer){

  buttonContainer.onclick = function() { mostraScriviReport(buttonContainer); };
  buttonContainer.style.backgroundColor = "#0A9B02";
  buttonContainer.style.borderColor = "#0A9B02";
  buttonContainer.textContent = 'CONTRASSEGNA COME COMPLETATA';


  setStato("Completata"); //da mettere finito il report


}



function mostraScriviReport(){

  pulisciContenitore();

  fetching('librerie/mostraScriviReport.html');

  document.getElementById("titolo").innerText = "Scrivi Report:"

}

async function getUtenteId() {
  const response = await fetch('php/getUtente.php', { credentials: 'include' });
  const userId = await response.text();
  return userId !== 'null' ? userId : null;
}

async function getLuogoId(aula) {
  const formData = new FormData();
  formData.append('aula', aula);

  try {
    const response = await fetch('php/getLuogo.php', {
      method: 'POST',
      body: formData
    });
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const result = await response.text();
    return result;
  } catch (error) {
    console.error('Errore:', error);
    return null;
  }
}

async function creaNuovaSegnalazione() {
  segnalazione.descrizione = document.getElementById("descrizione").value;

  let selectElement = document.getElementById('categoria');
  let categoria = selectElement.options[selectElement.selectedIndex];
  segnalazione.categoria = categoria.value;

  segnalazione.luogo_id = await getLuogoId(tempAula);
  segnalazione.stato = "Da fare";
  segnalazione.id_utente_crea = await getUtenteId();

  inviaSegnalazioni();
  segnalazioni();
}

function inviaSegnalazioni() {
  const formData = new FormData();
  formData.append('descrizione', segnalazione.descrizione);
  formData.append('luogo_id', segnalazione.luogo_id);
  formData.append('id_utente_crea', segnalazione.id_utente_crea);
  formData.append('categoria', segnalazione.categoria);

  fetch('php/inserisciSegnalazione.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(result => {
    console.log('Successo:', result);
    alert("segnalazione effettuata!!");
  })
  .catch(error => {
    console.error('Errore:', error);
    alert("segnalazione NON effettuata!!");
  });
}
