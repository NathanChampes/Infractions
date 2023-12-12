<?php
//Cryptage des mdp deja existants

session_start();
include('../modele/connexion.php');

$db = new Connexion();

$conducteurs = $db->execSQL('SELECT * FROM conducteur');

foreach ($conducteurs as $conducteur) {
    $password = $conducteur['motdepasse'];
    $mdpCrypte = password_hash($password, PASSWORD_DEFAULT);
    $db->execSQL('UPDATE conducteur SET motdepasse = :mdp WHERE num_permis = :num_permis', [':mdp' => $mdpCrypte, ':num_permis' => $conducteur['num_permis']]);
}

?>