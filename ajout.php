<?php
include('connect.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $date = $_POST['c_date'];

    // Vérifier si un fichier a été envoyé
    if ($_FILES['c_fichier']) {
        $fichier = $_FILES['c_fichier']['name'];
        $fichier_temp = $_FILES['c_fichier']['tmp_name'];
        $fichier_dest = "uploads/" . basename($fichier);

        // Déplacer le fichier vers le répertoire des uploads
        if (move_uploaded_file($fichier_temp, $fichier_dest)) {
            $req_document = "INSERT INTO documents (id, lien, date_ajout) 
                             VALUES ('$id', '$fichier_dest', NOW())";

            // Exécuter la requête pour insérer les données du document
            if (mysqli_query($bdd, $req_document)) {
                // Succès, renvoyer une réponse JSON
                echo json_encode(array("success" => true, "message" => "Personnel et document créés avec succès.", "fichier_dest" => $fichier_dest));
            } else {
                // Échec de l'insertion du document, renvoyer une réponse JSON avec un message d'erreur
                echo json_encode(array("success" => false, "message" => "Échec de la création du document."));
            }
        } else {
            // Échec de l'upload du fichier, renvoyer une réponse JSON avec un message d'erreur
            echo json_encode(array("success" => false, "message" => "Échec de l'upload du fichier."));
        }
    } else {
        // Aucun fichier envoyé, renvoyer une réponse JSON avec un message d'erreur
        echo json_encode(array("success" => false, "message" => "Aucun fichier envoyé."));
    }
} else {
    // Méthode HTTP incorrecte, renvoyer une réponse JSON avec un message d'erreur
    echo json_encode(array("success" => false, "message" => "Méthode HTTP incorrecte."));
}
?>
