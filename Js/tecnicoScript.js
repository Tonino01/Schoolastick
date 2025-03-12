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
    // Assicurati che l'ID della segnalazione sia passato correttamente
    console.log('ID Segnalazione:', id_segnalazione);
  })
  .catch(error => {
    console.error('Errore nel caricamento dei dettagli:', error);
  });
}


function modificaSegnalazione(id_segnalazione, stato_corrente) {



  const formData = new FormData();
  formData.append('id_segnalazione', id_segnalazione);
  formData.append('stato_corrente', stato_corrente);


  if (stato_corrente === "Nuova"){

    fetch('php/setIdUtenteLavora.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(result => {
      console.log('Successo modifica stato:', result);
      dettagliSegnalazione(id_segnalazione); // Refresh the details view
    })
    .catch(error => {
      console.error('Errore:', error);
    });

  }

  if (stato_corrente === "In corso") {
    fetching('librerie/mostraScriviReport.html').then(() => {
      const button = document.createElement('button');
      button.id = 'buttonModificaSegnalazione';
      button.type = 'button';
      button.innerText = 'CONTRASSEGNA COME COMPLETATA';
      button.onclick = async () => {

        await inserisciReport(id_segnalazione);

        formData.set('stato_corrente', 'In corso');
        fetch('php/setStato.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(result => {
          console.log('Successo modifica stato:', result);
          dettagliSegnalazione(id_segnalazione); // Refresh the details view
        })
        .catch(error => {
          console.error('Errore:', error);
        });
      };
      document.getElementById('contenitore').appendChild(button);
    });
  } else {
    fetch('php/setStato.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(result => {
      console.log('Successo modifica stato:', result);
      dettagliSegnalazione(id_segnalazione); // Refresh the details view
    })
    .catch(error => {
      console.error('Errore:', error);
    });
  }
}

async function inserisciReport(id_segnalazione) {

  let report = document.getElementById("report").value;



  if(!(report == null || report == "")){
    const formData = new FormData();
    formData.append('id_segnalazione', id_segnalazione);
    formData.append('report', report);

    await fetch('php/setReport.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(result => {
      console.log('Successo iserito report:', result);
      dettagliSegnalazione(id_segnalazione); // Refresh the details view
    })
    .catch(error => {
      console.error('Errore report:', error);
    });
  } else {
    alert("Inserire un report valido");
  }
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



function getStato(){


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

let tmpFiltro = false;
function mostraFiltro() {
  let input = document.createElement("input");
  let selectStato = document.createElement("select");
  let selectCategoria = document.createElement("select");
  let selectSede = document.createElement("select");

  if (tmpFiltro) {
    let descrizione = document.getElementById("input").value;

    let selectElementStato = document.getElementById('selectStato');
    let stato = selectElementStato.options[selectElementStato.selectedIndex].value;

    let selectElementCategoria = document.getElementById('selectCategoria');
    let categoria = selectElementCategoria.options[selectElementCategoria.selectedIndex].value;

    let selectElementSede = document.getElementById('selectSede');
    let sede = selectElementSede.options[selectElementSede.selectedIndex].value;

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

  } else {
    input.type = "text";
    input.placeholder = "Inserisci qualcosa...";
    input.id = "input";

    selectStato.id = "selectStato";
    selectStato.options[selectStato.options.length] = new Option('Qualunque', 'Qualunque');
    selectStato.options[selectStato.options.length] = new Option('Nuova', 'Nuova');
    selectStato.options[selectStato.options.length] = new Option('In corso', 'In corso');
    selectStato.options[selectStato.options.length] = new Option('Completa', 'Completa');

    selectCategoria.id = "selectCategoria";
    selectCategoria.options[selectCategoria.options.length] = new Option('Qualunque', 'Qualunque');
    selectCategoria.options[selectCategoria.options.length] = new Option('Riparare', 'Riparare');
    selectCategoria.options[selectCategoria.options.length] = new Option('Sostituire', 'Sostituire');
    selectCategoria.options[selectCategoria.options.length] = new Option('Pulire', 'Pulire');

    selectSede.id = "selectSede";
    selectSede.options[selectSede.options.length] = new Option('Tutte', 'Tutte');
    selectSede.options[selectSede.options.length] = new Option('ITT', 'ITT');
    selectSede.options[selectSede.options.length] = new Option('IPSIA', 'IPSIA');
    selectSede.options[selectSede.options.length] = new Option('ITE', 'ITE');

    document.getElementById("sezioneFiltro").appendChild(input);
    document.getElementById("sezioneFiltro").appendChild(selectStato);
    document.getElementById("sezioneFiltro").appendChild(selectCategoria);
    document.getElementById("sezioneFiltro").appendChild(selectSede);

    tmpFiltro = true;
  }
}
