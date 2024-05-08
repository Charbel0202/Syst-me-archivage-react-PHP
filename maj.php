<?php
include('connect.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si les données nécessaires sont fournies
    if (isset($_POST['iddoc']) && isset($_FILES['c_fichier'])) {
        $iddoc = $_POST['iddoc'];

        // Vérifier si un fichier a été envoyé
        if ($_FILES['c_fichier']) {
            $fichier = $_FILES['c_fichier']['name'];
            $fichier_temp = $_FILES['c_fichier']['tmp_name'];
            $fichier_dest = "uploads/" . basename($fichier);

            // Déplacer le fichier vers le répertoire des uploads
            if (move_uploaded_file($fichier_temp, $fichier_dest)) {
                $req_document = "UPDATE documents SET lien='$fichier_dest', date_ajout=NOW() WHERE iddoc='$iddoc'";

                // Exécuter la requête pour mettre à jour les données du document
                if (mysqli_query($bdd, $req_document)) {
                    // Succès, renvoyer une réponse JSON
                    echo json_encode(array("success" => true, "message" => "Document modifié avec succès.", "fichier_dest" => $fichier_dest));
                } else {
                    // Échec de la mise à jour du document, renvoyer une réponse JSON avec un message d'erreur
                    echo json_encode(array("success" => false, "message" => "Échec de la modification du document."));
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
        // Données manquantes, renvoyer une réponse JSON avec un message d'erreur
        echo json_encode(array("success" => false, "message" => "Données manquantes pour la modification du document."));
    }
} else {
    // Méthode HTTP incorrecte, renvoyer une réponse JSON avec un message d'erreur
    echo json_encode(array("success" => false, "message" => "Méthode HTTP incorrecte."));
}
?>
