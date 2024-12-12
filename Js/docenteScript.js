
const creaSegnalazione = document.createElement();


function caricaContenuto(file, callback) {
  fetch(file)
    .then(response => response.text())
    .then(data => callback(data))
    .catch(error => console.error('Errore nel caricamento del file:', error));
	
	
}

