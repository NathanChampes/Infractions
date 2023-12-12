<?php
session_start();
include('../modele/connexion.php');

function verifierMotDePasse($nom_utilisateur, $mot_de_passe) {
    $connexion = new Connexion();

    $resultats = $connexion->execSQL('SELECT motdepasse FROM conducteur WHERE num_permis = ?', [$nom_utilisateur]);
    if (!empty($resultats)) {
        $mot_de_passe_db = $resultats[0]['motdepasse'];

        return password_verify($mot_de_passe, $mot_de_passe_db);
    }

    return false;
}

function changerMotDePasse($nom_utilisateur, $nouveau_mot_de_passe) {
    $connexion = new Connexion();
    $nouveau_mot_de_passe_hash = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);
    $connexion->execSQL('UPDATE conducteur SET motdepasse = ? WHERE num_permis = ?', [$nouveau_mot_de_passe_hash, $nom_utilisateur]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valider'])) {
    $nom_utilisateur = $_POST['num_permis'];
    $ancien_mot_de_passe = $_POST['ancien_mot_de_passe'];
    $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];

    // Vérifier si l'ancien mot de passe est correct
    if (verifierMotDePasse($nom_utilisateur, $ancien_mot_de_passe)) {
        // Mettre à jour le mot de passe dans la base de données
        changerMotDePasse($nom_utilisateur, $nouveau_mot_de_passe);
        $message = 'Votre mot de passe a été changé avec succès.';
        header('Location: login.php');
        exit();
    } else {
        $message = 'L\'ancien mot de passe est incorrect.';
    }
} elseif (isset($_POST['annuler'])) {
    header('Location: login.php');
    exit();
}

require_once "../vue/changement_mdp.view.php";

?>