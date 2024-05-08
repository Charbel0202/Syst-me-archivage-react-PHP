<?php
include('connect.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $email = $_POST['c_email'];
    $nom = $_POST['c_nom'];
    $prenom = $_POST['c_prenom'];
    $role = $_POST['c_role'];
    $date = $_POST['c_date'];
    // Insérer les données et le chemin du fichier dans la base de données
    $req = "UPDATE personnel SET email='$email', nom='$nom', prenom='$prenom', role='$role', date_jour='$date' WHERE id='$id'";

    if ($bdd->query($req) === TRUE) {
        // Succès, renvoyer une réponse JSON
        echo json_encode(array("success" => true, "message" => "Personnel modifié avec succès."));
    } else {
        // Échec de l'insertion, renvoyer une réponse JSON avec un message d'erreur
        echo json_encode(array("success" => false, "message" => "Échec de la modification du personnel."));
    }
} else {
    // Méthode HTTP incorrecte, renvoyer une réponse JSON avec un message d'erreur
    echo json_encode(array("success" => false, "message" => "Méthode HTTP incorrecte."));
}
?>
