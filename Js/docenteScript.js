
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





}
function palestraButton(){



}
function pianoTerraButton(){



}
function intermedio1Button(){



}
function piano1Button(){



}
function intermedio2Button(){



}
function piano2Button(){



}
