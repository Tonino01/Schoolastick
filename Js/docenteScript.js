//inizializazione degli oggetti

const segnalazione = {

  descrizione: "",
  luogo_id: "",
  stato: "",
  id_utente_crea: "",
  categoria: "",
  report: ""

};


function logOut() {
    fetch('php/logout.php', {
        method: 'POST' // Usa POST se il logout modifica lo stato del server
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


function pulisciContenitore(){

  document.getElementById("contenitore").innerHTML = '';

}


function segnalazioni(){

  pulisciContenitore();
  fetching('librerie/mostraSegnalazioni.html');


  document.getElementById("titolo").innerText = "SEGNALAZIONI"

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



function nuovaSegnalazione(){

  pulisciContenitore();

  fetching('librerie/nuovaSegnalazione.html');

  document.getElementById("titolo").innerText = "CREA SEGNALAZIONE";



}



function nuovaSegnalazione_Sedi(){

  pulisciContenitore();

  fetching('librerie/nuovaSegnalazione-Sedi.html');

  document.getElementById("titolo").innerText = "CREA SEGNALAZIONE"

}

function sede1(){

  pulisciContenitore();

  fetching('librerie/nuovaSegnalazione.html');

  

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
  fetching('librerie/nuovaSegnalazione - Intermedio1.html');

}
function piano1Button(){

  tempPiano = "Piano 1";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Piano1.html');

}
function intermedio2Button(){

  tempPiano = "Intermedio 2";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Intermedio2.html');

}
function piano2Button(){

  tempPiano = "Piano 2";
  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Piano2.html');

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

    document.getElementById("titolo").innerText = "ARCHIVIO SEGNALAZIONI";

    document.getElementById("archivioButton").src = "icone/indietro-48.png";


    tmp = true;

  }
}

async function getUtenteId(){

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


  /*
  if(categoria == "Pulire"){

    segnalazione.perChi = "Collaboratore";

  }else{

    segnalazione.perChi = "Tecnico";

  */

//inviare la segnalazione al DataBase

  inviaSegnalazioni();



  
}

document.addEventListener('scroll', function() {
  const header = document.querySelector('.header');
  const bc = document.querySelector('.bc');
  if (window.scrollY >= header.offsetHeight) {
      document.body.classList.add('scrolled');
  } else {
      document.body.classList.remove('scrolled');
  }
});


function inviaSegnalazioni() {
    const formData = new FormData();
    formData.append('descrizione', segnalazione.descrizione);
    formData.append('luogo_id', segnalazione.luogo_id);
    formData.append('id_utente_crea', segnalazione.id_utente_crea);
    formData.append('categoria', segnalazione.categoria);

    // Effettua la richiesta POST al server
    fetch('php/inserisciSegnalazione.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        console.log('Successo:', result);
        alert("segnalazione effettuata!!");
        segnalazioni();
    })
    .catch(error => {
        console.error('Errore:', error);
        alert("segnalazione NON effettuata!!");
    });
}

let tmpFiltro = false;
let descrizione = '';
let stato = '';
let categoria = '';
let sede = '';

function Filtro() {
    const sezioneFiltro = document.getElementById("sezioneFiltro");
    if (tmpFiltro) {

        descrizione = document.getElementById('input').value;
        stato = document.getElementById('selectStato').value; 
        categoria = document.getElementById('selectCategoria').value;
        sede = document.getElementById('selectSede').value;
        
        applicaFiltro();
        
        
    } else {
        sezioneFiltro.innerHTML = `
            <button class='XButton' onclick='nascFiltro()'>
                <img class='nascondiButton' src='icone/cancButton.png'>
            </button>
            <input type="text" id="input" placeholder="Inserisci qualcosa...">
            <select id="selectStato">
                <option>Qualunque</option>
                <option>Nuova</option>
                <option>In corso</option>
                <option>Completa</option>
            </select>
            <select id="selectCategoria">
                <option>Qualunque</option>
                <option>Riparare</option>
                <option>Sostituire</option>
                <option>Pulire</option>
            </select>
            <select id="selectSede">
                <option>Tutte</option>
                <option>ITT</option>
                <option>IPSIA</option>
                <option>ITE</option>
            </select>
        `;
        tmpFiltro = !tmpFiltro;
    }
    
}

function nascFiltro() {
    const sezioneFiltro = document.getElementById("sezioneFiltro");
    sezioneFiltro.innerHTML = '';
    tmpFiltro = !tmpFiltro;
    caricaSegnalazioni();
}

function applicaFiltro() {
  const formData = new FormData();
  formData.append('descrizione', descrizione);
  formData.append('stato', stato);
  formData.append('categoria', categoria);
  formData.append('sede', sede);

  fetch('php/filtraSegnalazioni.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('dettagli').innerHTML = data;
  })
  .catch(error => {
    console.error('Errore nel caricamento dei dettagli:', error);
  });
}
