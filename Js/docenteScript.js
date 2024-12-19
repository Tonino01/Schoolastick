function caricaSegnalazioni() {

  fetch("librerie/mostraSegnalazioni.html")
    .then(response => response.text())
    .then(data => {
      const fileContent = data;
      document.getElementById('contenitore').innerHTML = fileContent;
    })
    .catch(error => {
      console.error('Errore nel caricamento del file:', error);
    });

}
