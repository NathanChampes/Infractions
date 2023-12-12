<?php
session_start();
include('../modele/connexion.php');

function existeConducteur(string $login, string $mdp): bool
{
    $connexion = new Connexion();
    $sql = "SELECT motdepasse FROM conducteur WHERE num_permis = ? AND admin = 0";
    $result = $connexion->execSQL($sql, [$login]);
    return ($result && password_verify($mdp, $result[0]['motdepasse']));
}

function existeAdmin(string $login, string $mdp): bool
{
    $connexion = new Connexion();
    $sql = "SELECT motdepasse FROM conducteur WHERE num_permis = ? AND admin = 1";
    $result = $connexion->execSQL($sql, [$login]);
    return ($result && password_verify($mdp, $result[0]['motdepasse']));
}

$messageErreur = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_utilisateur = $_POST['username'];
    $mot_de_passe = $_POST['password'];

    if (existeConducteur($nom_utilisateur, $mot_de_passe)) {
        session_start();
        $_SESSION['nom_utilisateur'] = $nom_utilisateur;
        header("location: ../controleur/accueil.php");
    } elseif (existeAdmin($nom_utilisateur, $mot_de_passe)) {
        session_start();
        $message = "Connexion le " . date("d/m/Y H:i:s") . " au poste d'administrateur\n";
        file_put_contents("../logs/admin_log.txt", $message, FILE_APPEND);
        $_SESSION['nom_utilisateur'] = $nom_utilisateur;
        header("location: ../controleur/admin.php");
    } else {
        $messageErreur = 'Identification incorrecte. Essayez de nouveau.';
    }
}

require_once "../vue/login.view.php";

?>