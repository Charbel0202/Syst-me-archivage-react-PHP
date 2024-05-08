<?php
include('connect.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['c_email'];
    $nom = $_POST['c_nom'];
    $prenom = $_POST['c_prenom'];
    $role = $_POST['c_role'];
    $date = $_POST['c_date'];

    // Vérifier si un fichier a été envoyé et s'il n'y a pas d'erreur
    if ($_FILES['c_fichier']['error'] === UPLOAD_ERR_OK) {
        $fichier = $_FILES['c_fichier']['name'];
        $fichier_temp = $_FILES['c_fichier']['tmp_name'];
        $fichier_dest = "uploads/" . basename($fichier);

        // Insérer les données et le chemin du fichier dans la base de données
        $req_personnel = "INSERT INTO personnel (email, nom, prenom, role, date_jour) 
                          VALUES ('$email', '$nom', '$prenom', '$role', '$date')";

        // Exécuter la requête pour insérer les données personnelles
        if (mysqli_query($bdd, $req_personnel)) {
            // Récupérer l'ID de la dernière insertion dans la table personnel
            $last_personnel_id = mysqli_insert_id($bdd);

            // Requête d'insertion pour le document avec l'ID personnel correspondant
            $req_document = "INSERT INTO documents (id, lien, date_ajout) 
                             VALUES ('$last_personnel_id', '$fichier_dest', NOW())";

            // Exécuter la requête pour insérer les données du document
            if (mysqli_query($bdd, $req_document)) {
                // Succès, renvoyer une réponse JSON
                echo json_encode(array("success" => true, "message" => "Personnel et document créés avec succès.", "fichier_dest" => $fichier_dest));
            } else {
                // Échec de l'insertion du document, renvoyer une réponse JSON avec un message d'erreur
                echo json_encode(array("success" => false, "message" => "Échec de la création du document."));
            }
        } else {
            // Échec de l'insertion du personnel, renvoyer une réponse JSON avec un message d'erreur
            echo json_encode(array("success" => false, "message" => "Échec de la création du personnel."));
        }
    } else {
        // Échec de l'upload du fichier, renvoyer une réponse JSON avec un message d'erreur
        echo json_encode(array("success" => false, "message" => "Échec de l'upload du fichier."));
    }
} else {
    // Méthode HTTP incorrecte, renvoyer une réponse JSON avec un message d'erreur
    echo json_encode(array("success" => false, "message" => "Méthode HTTP incorrecte."));
}

?>

