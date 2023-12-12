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
}else {
    $conducteurDAO = new ConducteurDAO();
    foreach($conducteurDAO->getAll() as $unCond){
        if($unCond->getNumPermis() === $_SESSION['nom_utilisateur']){
            header("location: ../controleur/accueil.php");
            exit();
        }
    }
}

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$infractionDAO = new InfractionDAO();
$vehiculeDAO = new VehiculeDAO();
$comprendDAO = new ComprendDAO();
$delitDAO = new DelitDAO();
$login = $_SESSION['nom_utilisateur'];
$lesInfractions = $infractionDAO->getAll();

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



$lignes = [];
foreach ($lesInfractions as $uneInfraction) {
    $lesConducteurs = $conducteurDAO->getByNumPermis($uneInfraction->getIdPermis());
    $ch = '';
    $ch .= '<td>' . $uneInfraction->getIdInfraction() . '</td>';
    $date = date_create($uneInfraction->getDateInfraction());
    $numImmat = $uneInfraction->getIdImmatriculation();
    $ch .= '<td>' . date_format($date, 'd/m/Y') . '</td>';
    $ch .= '<td>' . $numImmat . '</td>';
    $ch .= '<td>' . $uneInfraction->getIdPermis() . '</td>';
    $ch .= '<td>' . $lesConducteurs->getNom() . ' ' . $lesConducteurs->getPrenom() . '</td>';
    $comprends = $comprendDAO->getByIdInfraction($uneInfraction->getIdInfraction());
    $delits = '';
    $totalTarif = 0;
    foreach ($comprends as $comprend) {
        $lesDelits = $delitDAO->getByIdDelit($comprend->getIdDelit());
        $totalTarif += $lesDelits->getTarifDelit();
    }
    $ch .= '<td>' .number_format($totalTarif, 2, '.', '').' €'.'</td>';
    $ch .= '<td><a href="details.php?id=' . $uneInfraction->getIdInfraction() . '"><img src="../vue/style/eye.png"></a></td>';
    $ch .= '<td><a href="editInf.php?op=m&id=' . $uneInfraction->getIdInfraction() . '"><img src="../vue/style/modification.png"></a></td>';
    $ch .= '<td><a href="editInf.php?op=s&id=' . $uneInfraction->getIdInfraction() . '" class="delete-link"><img src="../vue/style/corbeille.png"></a></td>';
    $lignes[] = "<tr>$ch</tr>";
}
$maxId = max(array_map(function ($infraction) {
    return $infraction->getIdInfraction();
}, $lesInfractions));

$IdInfA = $maxId + 1;

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

function extraction_JSON(){
    $fichier = file_get_contents('../extractions_json/infractions_ext.json');
    $fichierDecode = json_decode($fichier,true);
    $messageError = "";
    $delitDAO = new DelitDAO();
    $conducteurDAO = new ConducteurDAO();
    $vehiculeDAO = new VehiculeDAO();
    $infractionDAO = new InfractionDAO();
    $comprendDAO = new ComprendDAO();

    foreach ($fichierDecode as $uneInfJSON) {
        $lesInfractions = $infractionDAO->getAll();
        $id = max(array_map(function ($infraction) {
            return $infraction->getIdInfraction();
        }, $lesInfractions)) + 1;
        $delitsError = "";
        if(!empty($uneInfJSON['delits'])){
            foreach ($uneInfJSON['delits'] as $unDelit) {
                if(!$delitDAO->existe($unDelit)){
                    $delitsError .= "-Le délit ".$unDelit." n'existe pas.\\n";
                }
            }
        }
        $date = date_create($uneInfJSON['date_inf'])->format('Y-m-d');
        $uneInf = new Infraction($id, $date, $uneInfJSON['num_permis'], $uneInfJSON['num_immat']);
        $lesInfQuiPourraientCorrespondre = $infractionDAO->existeJSON($uneInf);
        $InfQuiCorrespond = null;
        foreach($lesInfQuiPourraientCorrespondre as $uneInfQuiPourraitCorrespondre){
            $lesComprends = $comprendDAO->getByIdInfraction($uneInfQuiPourraitCorrespondre->getIdInfraction());
            $lesDelits = [];
            foreach($lesComprends as $unComprend){
                $lesDelits[] = $unComprend->getIdDelit();
            }
            if($lesDelits == $uneInfJSON['delits']){
                $InfQuiCorrespond = $uneInfQuiPourraitCorrespondre;
            }
        }
        if($InfQuiCorrespond == null && $vehiculeDAO->existe($uneInfJSON['num_immat']) && ($conducteurDAO->existe($uneInfJSON['num_permis']) || $uneInfJSON['num_permis'] == null) && $delitsError == ""){
            $infractionDAO->insert($uneInf);
            foreach ($uneInfJSON['delits'] as $unDelit) {
                $unComprend = new Comprend($id, $unDelit);
                $comprendDAO->insert($unComprend);
            }
        }
        elseif ($InfQuiCorrespond != null) {
            $messageError .= "L'infraction ". $uneInfJSON['date_inf'] . " " . $uneInfJSON['num_immat'] . " " . (($uneInfJSON['num_permis']!=null)?($uneInfJSON['num_permis']):("")). " qui a comme delits : [ " . implode(", ", $uneInfJSON['delits']) ."] existe déjà, c'est l'infraction ". $InfQuiCorrespond->getIdInfraction() . ".\\n";
        }
        else
        {
            $messageError .= "L'infraction ". $uneInfJSON['date_inf'] . " " . $uneInfJSON['num_immat'] . " " . (($uneInfJSON['num_permis']!=null)?($uneInfJSON['num_permis']):("")). " qui a comme delits : [ " . implode(", ", $uneInfJSON['delits']) ."] n'a pas été ajoutée car : \\n";
            if(!$vehiculeDAO->existe($uneInfJSON['num_immat'])){
                $messageError .= "-Le véhicule n'existe pas.\\n";
            }
            if(!$conducteurDAO->existe($uneInfJSON['num_permis']) && $uneInfJSON['num_permis'] != null){
                $messageError .= "-Le conducteur n'existe pas.\\n";
            }
            if(empty($uneInfJSON['delits'])){
                $messageError .= "Il n'y a pas de délit saisie.\\n";
            }elseif($delitsError != ""){
                $messageError .= $delitsError;
            }
        }
    }
    return $messageError;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['scanJSON'])) {
    $message = extraction_JSON();
    echo "<script>alert(". '"'. $message .'"'. "); setTimeout(function(){ window.location.href = 'admin.php'; }, 0);</script>"; 
}

unset($lesInfractions);
require_once('../vue/admin.view.php');
?>