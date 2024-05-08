<?php
include('connect.php'); // Inclure le fichier de connexion à la base de données

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Vérifier si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données JSON de la requête
    $data = json_decode(file_get_contents("php://input"));

    // Vérifier si les données JSON contiennent l'ID du document à archiver
    if (isset($data->documentId)) {
        // Sécuriser l'ID du document
        $documentId = mysqli_real_escape_string($conn, $data->documentId);

        // Préparer la requête SQL pour mettre à jour le statut du document
        $sql = "UPDATE documents SET archive = 1 WHERE iddoc = $documentId";

        // Exécuter la requête SQL
        if (mysqli_query($conn, $sql)) {
            // Succès : renvoyer une réponse JSON indiquant que l'archivage a été réussi
            $response = array('success' => true, 'message' => 'Document archivé avec succès.');
            echo json_encode($response);
        } else {
            // Erreur lors de la mise à jour : renvoyer une réponse JSON d'erreur
            $response = array('success' => false, 'message' => 'Erreur lors de l\'archivage du document : ' . mysqli_error($conn));
            echo json_encode($response);
            // Débogage : afficher la requête SQL complète ou le message d'erreur SQL
            echo "Erreur SQL : " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // Répondre avec un statut HTTP 400 (Bad Request) si l'ID du document est manquant
        http_response_code(400);
        echo json_encode(array("message" => "ID du document manquant dans les données."));
    }
} else {
    // Répondre avec un statut HTTP 405 (Method Not Allowed) si la méthode de requête n'est pas autorisée
    http_response_code(405);
    echo json_encode(array("message" => "Méthode non autorisée."));
}
?>
