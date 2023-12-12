<?php
session_start();
include('../modele/connexion.php');

if (!isset($_SESSION['nom_utilisateur'])) {
    header("location: ../controleur/login.php");
    exit();
}


function infosUtilisateur(string $login): array|null
{
    $connexion = new Connexion();
    $sql = "SELECT nom, prenom, num_permis, date_permis FROM conducteur WHERE num_permis = ?";
    $result = $connexion->execSQL($sql, [$login]);

    if ($result && count($result) === 1) {
        return $result[0];
    } else {
        return null;
    }
}

$login = $_SESSION['nom_utilisateur'];

$informationsUtilisateur = infosUtilisateur($login);

require_once('../vue/accueil.view.php');
?>