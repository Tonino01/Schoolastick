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

  document.getElementById("titolo").innerText = "Creazione Segnalazione:";

}

function mostraInfoAccount(){

  pulisciContenitore();


  fetching('librerie/infoAccount.html');

  document.getElementById("titolo").innerText = "Informazioni sull'Account:";

}



function mostraUtenti(){

  pulisciContenitore();

  fetching('librerie/mostraUtenti.html');

  document.getElementById("titolo").innerText = "Utenti Piattaforma:";

  caricaUtenti();

}

function caricaUtenti() {
  fetch('php/view_ut.php') // Qui chiami il file PHP
  .then(response => response.text())
  .then(data => {
    // Aggiungi i dettagli nel div con id "dettagli
    document.getElementById('dettagli').innerHTML = data;
  })
  .catch(error => {
    console.error('Errore nel caricamento dei dettagli:', error);
  });
}

//gestione selezione luogo

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

}




function mostraModificaUtente(){

  pulisciContenitore();

  fetching('librerie/modificaUtente.html');

  document.getElementById("titolo").innerText = "Modifica Permessi Utente:";

  modificaUtente();
  
}

function modificaUtente() {

  fetch('php/caricaDettagliUtenteModifica.php') // Qui chiami il file PHP
  .then(response => response.text())
  .then(data => {
    // Aggiungi i dettagli nel div con id "dettagli
    document.getElementById('dettagli').innerHTML = data;

    //imposto la selezione con il tipo dell'account
    document.getElementById('permesso').value = document.getElementById('tipoUtente').innerText;


  })
  .catch(error => {
    console.error('Errore nel caricamento dei dettagli:', error);
  });

  
}

function salvaTipoUtente(){

  let selectElement = document.getElementById('permesso');


  let tipo = selectElement.options[selectElement.selectedIndex];


  let tipoSelezionato = categoria.value;


  const formData = new FormData();
  formData.append('tipo', tipoSelezionato);
  

  fetch('php/modifica_tipo.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(result => {
    console.log('Successo:', result);
    alert("modifica effettuata!!");
  })
  .catch(error => {
    console.error('Errore:', error);
    alert("modifica NON effettuata!!");
  });


}

function eliminaUtente(){

  

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
