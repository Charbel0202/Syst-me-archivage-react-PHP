<?php
// Paramètres de connexion à la base de données
$serveur = "localhost"; // Adresse du serveur MySQL
$utilisateur = "root"; // Nom d'utilisateur MySQL
$motDePasse = ""; // Mot de passe MySQL
$baseDeDonnees = "db_archivage"; // Nom de la base de données

// Connexion à la base de données
$bdd = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

// Vérifier la connexion
if ($bdd->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
}
?>