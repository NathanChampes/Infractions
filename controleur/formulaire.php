<?php
require_once('../modele/infractionDAO.class.php');
require_once('../modele/conducteurDAO.class.php');
require_once('../modele/comprendDAO.class.php');
require_once('../modele/vehiculeDAO.class.php');
require_once('../modele/delitDAO.class.php');
session_start();

if (!isset($_SESSION['nom_utilisateur'])) {
    header("location: ../controleur/login.php");
    exit();
}

$infractionDAO = new InfractionDAO();
$conducteurDAO = new ConducteurDAO();
$vehiculeDAO = new VehiculeDAO();
$comprendDAO = new ComprendDAO();
$delitDAO = new DelitDAO();
$login = $_SESSION['nom_utilisateur'];
$lesInfractions = $infractionDAO->getByNumPermis($login);
$lesConducteurs = $conducteurDAO->getByNumPermis($login);

if (isset($_GET['tri']) && $_GET['tri'] === 'date') {
    usort($lesInfractions, function ($a, $b) {
        $diff = strtotime($a->getDateInfraction()) - strtotime($b->getDateInfraction());
        return (isset($_GET['ordre']) && $_GET['ordre'] === 'desc') ? -$diff : $diff;
    });
}

if (isset($_GET['tri']) && $_GET['tri'] === 'index') {
    usort($lesInfractions, function ($a, $b) {
        $diff = $a->getIdInfraction() - $b->getIdInfraction();
        return (isset($_GET['ordre']) && $_GET['ordre'] === 'desc') ? -$diff : $diff;
    });
}

if (isset($_GET['tri']) && $_GET['tri'] === 'montant') {
    usort($lesInfractions, function ($a, $b) {
        $totalTarifA = 0;
        $totalTarifB = 0;
        $comprendDAO = new ComprendDAO();
        $delitDAO = new DelitDAO();
        $comprendsA = $comprendDAO->getByIdInfraction($a->getIdInfraction());
        foreach ($comprendsA as $comprend) {
            $lesDelitsA = $delitDAO->getByIdDelit($comprend->getIdDelit());
            $totalTarifA += $lesDelitsA->getTarifDelit();
        }

        $comprendsB = $comprendDAO->getByIdInfraction($b->getIdInfraction());
        foreach ($comprendsB as $comprend) {
            $lesDelitsB = $delitDAO->getByIdDelit($comprend->getIdDelit());
            $totalTarifB += $lesDelitsB->getTarifDelit();
        }

        $diff = $totalTarifA - $totalTarifB;
        return (isset($_GET['ordre']) && $_GET['ordre'] === 'desc') ? -$diff : $diff;
    });
}

$lignes=[];
foreach($lesInfractions as $uneInfraction){
    $ch = '';
    $ch .= '<td>' .$uneInfraction->getIdInfraction(). '</td>';
    $date = date_create($uneInfraction->getDateInfraction());
    $numImmat = $uneInfraction->getIdImmatriculation();
    $ch .= '<td>' .date_format($date, 'd/m/Y'). '</td>';
    $ch .= '<td>' .$numImmat. '</td>';
    $ch .= '<td>' .$uneInfraction->getIdPermis()." / " .$lesConducteurs->getNom(). ' ' . $lesConducteurs->getPrenom(). '</td>';
    $comprends = $comprendDAO->getByIdInfraction($uneInfraction->getIdInfraction());
    $delits = '';
    $totalTarif = 0;
    foreach($comprends as $comprend){   
        $lesDelits = $delitDAO->getByIdDelit($comprend->getIdDelit());
        $totalTarif += $lesDelits->getTarifDelit();
    }
    $ch .= '<td>' .number_format($totalTarif, 2, '.', '') ." €". '</td>';
    $ch .= '<td><a href="details.php?id=' .$uneInfraction->getIdInfraction(). '"><img src="../vue/style/eye.png"></a></td>';
    $lignes[] = "<tr>$ch</tr>";
}

function triTable($column, $text) {
    $ordre_tri = (isset($_GET['ordre']) && $_GET['ordre'] === 'asc') ? 'desc' : 'asc';
    $fleche = '';
    if (isset($_GET['tri']) && $_GET['tri'] === $column) {
        $fleche = (isset($_GET['ordre']) && $_GET['ordre'] === 'asc') ? ' ▼' : ' ▲';
    }
    return '<th id="affichable"><a href="?tri=' . $column . '&ordre=' . $ordre_tri . '">' . $text . $fleche . '</a></th>';
}

$id = triTable('index', "Numéro d'infraction");
$datetri = triTable('date', "Date d'infraction");
$montantTri = triTable('montant', "Montant de l'amende");


unset($lesInfractions);
require_once('../vue/formulaire.view.php');
?>
