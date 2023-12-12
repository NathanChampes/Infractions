<?php
require_once('../modele/conducteurDAO.class.php');
require_once('../modele/infractionDAO.class.php');
require_once('../modele/vehiculeDAO.class.php');
require_once('../modele/comprendDAO.class.php');
require_once('../modele/delitDAO.class.php');
session_start();

if (!isset($_SESSION['nom_utilisateur'])) {
    header("location: ../controleur/login.php");
    exit();
}else {
    $bool = false;
    $conducteurDAO = new ConducteurDAO();
    if($conducteurDAO->isAdmin($_SESSION['nom_utilisateur'])){
        $bool = true;
    } 
    $infractionDAO = new InfractionDAO();
    foreach ($infractionDAO->getByNumPermis($_SESSION['nom_utilisateur']) as $uneInf)
    {
        if ($uneInf->getIdInfraction() === $_GET['id'])
        {
            $bool = true;
        }
    }
    if ($bool === false)
    {
        header("location: ../controleur/accueil.php");
        exit();
    }
}

$lignes = [];
if (isset($_GET['id'])) {
    $idInfraction = $_GET['id'];
    $infractionDAO = new InfractionDAO();
    $comprendDAO = new comprendDAO();
    $delitDAO = new delitDAO();
    $vehiculeDAO = new VehiculeDAO();
    $conducteurDAO = new ConducteurDAO();
    $uneInfraction = $infractionDAO->getByIdInfraction($idInfraction);
    $numPermis = $uneInfraction[0]->getIdPermis();
    $leConducteur = $conducteurDAO->getByNumPermis($numPermis);
    $date = date_create($uneInfraction[0]->getDateInfraction());
    $numImmat = $uneInfraction[0]->getIdImmatriculation();
    $vehicule = $vehiculeDAO->getByNumImmatriculation($numImmat);
    $dateImmat = date_create($vehicule->getDateImmatriculation());
    $marque = $vehicule->getMarque();
    $modele = $vehicule->getModele();
    $comprends = $comprendDAO->getByIdInfraction($uneInfraction[0]->getIdInfraction());
    $totalTarif = 0;
    foreach ($comprends as $comprend) {
        $ch = '';
        $lesDelits = $delitDAO->getByIdDelit($comprend->getIdDelit());
        $totalTarif += $lesDelits->getTarifDelit();
        $ch .= '<td>' . $lesDelits->getIdDelit() . '</td>';
        $ch .= '<td>' . $lesDelits->getNatureDelit() . '</td>';
        $ch .= '<td>' . $lesDelits->getTarifDelit() . '€ </td>';
        $lignes[] = "<tr>$ch</tr>";
    }
    
}

require_once('../vue/details.view.php');
?>