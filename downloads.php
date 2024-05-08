<?php
include('connect.php');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Vérifier si le nom du fichier est présent dans les paramètres de la requête GET
if (isset($_GET['nomFichier'])) {
    $nomFichier = $_GET['nomFichier'];
    
    // Chemin complet du fichier à récupérer
    $cheminFichier = $nomFichier;

    // Vérifier si le fichier existe avant de le renvoyer
    if (file_exists($cheminFichier)) {
        // Déterminer le type MIME en fonction de l'extension du fichier (le type de doc quoi !!!)
        $extension = strtolower(pathinfo($cheminFichier, PATHINFO_EXTENSION));
        $mimeTypes = array(
            'pdf' => 'application/pdf',
        );

        if (array_key_exists($extension, $mimeTypes)) {
            $contentType = $mimeTypes[$extension];
            header('Content-Type: ' . $contentType);
            header('Content-Disposition: attachment; filename="' . basename($cheminFichier) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($cheminFichier));
            readfile($cheminFichier);
            exit;
        } else {
            // Type MIME non pris en charge
            header('HTTP/1.0 415 Unsupported Media Type');
            echo 'Type MIME non pris en charge.';
            exit;
        }
    } else {
        // ca cest pour quand Le fichier demandé n'existe pas
        header('HTTP/1.0 404 Not Found');
        echo 'Le fichier demandé n\'existe pas.';
        exit;
    }
} else {
    // Paramètre manquant dans la requête
    header('HTTP/1.0 400 Bad Request');
    echo 'Paramètre manquant dans la requête.';
    exit;
}
?>
