<?php
$filename = "../downloads/ClientSide.zip"; // Nome del file da scaricare
$filepath = 'files/' . basename($filename); // evita path traversal

if (file_exists($filepath)) {
    // Imposta gli header per il download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));

    // Pulisce il buffer e invia il file
    flush();
    readfile($filepath);
    exit;
} else {
    http_response_code(404);
    echo "File non trovato.";
}
?>
