let fs = require('fs');

function caricaContenuto() {
    fs.readFile('mostraSegnalazioni.html', 'utf8', (err, data) => {
        if (err) {
            console.error(err);
            return;
        }
        document.getElementById("contenuto").innerHTML = data;
    });
}


