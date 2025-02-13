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
  document.getElementById("titolo").innerText = "SEGNALAZIONI";




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

  document.getElementById("titolo").innerText = "CREAZIONE SEGNALAZIONE";



}



function mostraInfoAccount(){

  pulisciContenitore();
  fetching('librerie/infoAccount.html');
  document.getElementById("titolo").innerText = "INFORMAZIONI ACCOUNT";

  caricaDettagliUtente();


}

function caricaDettagliUtente() {
  const formData = new FormData();
  formData.append('id', getUtenteId());

  // Effettua la richiesta POST al server
  fetch('php/caricaDettagliUtente.php', {
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




document.addEventListener('scroll', function() {
    const header = document.querySelector('.header');
    const bc = document.querySelector('.bc');
    if (window.scrollY >= header.offsetHeight) {
        document.body.classList.add('scrolled');
    } else {
        document.body.classList.remove('scrolled');
    }
});

