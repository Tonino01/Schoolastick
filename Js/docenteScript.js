
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

//inutili, mi servivano solo per provare una cosa, e non ho voglia di toglierli
function segnalazioni(){

  pulisciContenitore();
  fetching('librerie/mostraSegnalazioni.html');

}

function nuovaSegnalazione(){

  pulisciContenitore();

  fetching('librerie/nuovaSegnalazione.html');

}

function mostraInfoAccount(){

  pulisciContenitore();
  fetching('librerie/infoAccount.html');

}


function seminterratoButton(){

  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Seminterrato.html');

}
function palestraButton(){

  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Palestra.html');

}
function pianoTerraButton(){

  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - PianoTerra.html');

}
function intermedio1Button(){

  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Seminterrato.html');

}
function piano1Button(){

  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Seminterrato.html');

}
function intermedio2Button(){

  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Seminterrato.html');

}
function piano2Button(){

  pulisciContenitore();
  fetching('librerie/nuovaSegnalazione - Seminterrato.html');

}
