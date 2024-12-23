
// Funzione per caricare il file HTML esterno
async function mostraSegnalazioni() {

    try {
        const response = await fetch('librerie/mostraSegnalazioni.html');
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

async function creaSegnalazioni(){

  try {
      const response = await fetch('librerie/creaSegnalazioni.html');
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

async function infoAccount(){

  try {
      const response = await fetch('librerie/infoAccount.html');
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
  mostraSegnalazioni();

}

function nuovaSegnalazione(){

  pulisciContenitore();
  creaSegnalazioni();

}

function mostraInfoAccount(){

  pulisciContenitore();
  infoAccount();

}
