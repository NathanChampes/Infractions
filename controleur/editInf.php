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
}else{
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

$op 	= (isset($_GET['op'])?$_GET['op']:null);
$ajout 	= ($op == 'a');
$modif 	= ($op == 'm');
$suppr 	= ($op == 's');
$id 	= (isset($_GET['id'])?$_GET['id']:null);

// accès à la page uniquement si un numéro d'infraction et statut opération sont passés en paramètre
if ( $id==null && !($ajout || $modif || $suppr )) {
	header("location: admin.php");
} 

// delits valides id=>delit
$delitDAO = new DelitDAO();
$lesDelits = $delitDAO->getAll();
$delits = [];
foreach($lesDelits as $unDelit){
    $delits[$unDelit->getIdDelit()] = $unDelit;
}

// num_permis valides
$conducteurDAO = new ConducteurDAO();
$lesConducteurs = $conducteurDAO->getAll();
$permis = ["Selectionner un permis"];
foreach($lesConducteurs as $unConducteur){
    $permis[$unConducteur->getNumPermis()] = $unConducteur->getNumPermis();
}

// num_immat valides
$vehiculeDAO = new VehiculeDAO();
$lesVehicules = $vehiculeDAO->getAll();
$immats = ["Selectionner une immatriculation"];
foreach($lesVehicules as $unVehicule){
    $immats[$unVehicule->getNumImmatriculation()] = $unVehicule->getNumImmatriculation();
}


$infractionDAO = new InfractionDAO();
$comprendDAO = new ComprendDAO();

// gestion des zones non modifiables en mode "modif"
$valeurs['id'] = $id;
if ($modif || $suppr)	{
	$uneInf = $infractionDAO->getByIdInfraction($valeurs['id']);
}


$titre = (($ajout)?'Nouvelle Infraction':(($modif)?"Infractions - édition des informations":"Suppression d'une infraction"));

$erreurs = ['date'=>"", 'num_permis'=>'', 'num_immat'=>"", 'delits'=>""];
$valeurs['date'] = (isset($_POST['date'])?trim($_POST['date']):null);
$valeurs['num_permis'] = (isset($_POST['num_permis'])?trim($_POST['num_permis']):null);
$valeurs['num_immat'] = (isset($_POST['num_immat'])?trim($_POST['num_immat']):null);
$valeurs['delits'] = (isset($_POST['delits']) ? $_POST['delits'] : null);


$retour = false;
	
if (isset($_POST['valider'])) {
	if (!isset($valeurs['num_permis']) || strlen($valeurs['num_permis'])==0 || !in_array($valeurs['num_permis'],$permis,true) ||  $valeurs['num_permis'] == "Selectionner un permis") { 
		$erreurs['num_permis'] = 'Numéro de permis non valide.'; 
	}
    if (!isset($valeurs['num_immat']) || strlen($valeurs['num_immat'])==0 || !in_array($valeurs['num_immat'],$immats,true) ||  $valeurs['num_immat'] == "Selectionner une immatriculation") {
        $erreurs['num_immat'] = 'Numéro d\'immatriculation non valide.';
    }
    if (!isset($valeurs['date']) || strlen($valeurs['date'])==0) {
        $erreurs['date'] = 'Date non valide.';
    }
    if ($valeurs['delits'] == NULL || count($valeurs['delits'])==0) {
        $erreurs['delits'] = 'Delit(s) non valide(s).';
    }

 	$nbErreurs = 0;
 	foreach ($erreurs as $erreur){
 		if ($erreur != "") {$nbErreurs++;}
 	}
 	if ($nbErreurs == 0){
		$uneInf = new Infraction($valeurs['id'],$valeurs['date'], $valeurs['num_permis'], $valeurs['num_immat']);
		$retour = true;
		if ($ajout)	{
			$infractionDAO->insert($uneInf);
            foreach($valeurs['delits'] as $unDelit){
                $unComprend = new Comprend($valeurs['id'], $unDelit);
                $comprendDAO->insert($unComprend);
            }
		}	
		else {			
			$infractionDAO->update($uneInf);
            $comprendDAO->deleteById($valeurs['id']);
            foreach($valeurs['delits'] as $unDelit){
                $unComprend = new Comprend($valeurs['id'], $unDelit);
                $comprendDAO->insert($unComprend);
            }
		}
	}
}
elseif (isset($_POST['annuler']))	{
	$retour = true;
}
elseif ($suppr) {
// suppression
    $comprendDAO->deleteById($id);
	$infractionDAO->delete($id);
	$retour = true;
}
elseif ($modif)    {
    $uneInf = $infractionDAO->getByIdInfraction($id);
    $comprends = $comprendDAO->getByIdInfraction($uneInf[0]->getIdInfraction());
    $valeurs['date'] = date_create($uneInf[0]->getDateInfraction())->format('Y-m-d');
    $valeurs['num_permis'] = $uneInf[0]->getIdPermis();
    $valeurs['num_immat'] = $uneInf[0]->getIdImmatriculation();
    foreach ($comprends as $comprend) {
        $valeurs['delits'][] = $delitDAO->getByIdDelit($comprend->getIdDelit());
    }
}

if ($retour)
{
	header("location: admin.php");
}	

require_once("../vue/editInf.view.php");
?>