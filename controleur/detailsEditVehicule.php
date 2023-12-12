<?php
require_once('../modele/vehiculeDAO.class.php');

if (isset($_GET['selectedValue'])) {
    $selectedValue = $_GET['selectedValue'];
    if ($selectedValue != "Selectionner une immatriculation") {
        $vehiculeDAO = new VehiculeDAO();
        $leVehicule = $vehiculeDAO->getByNumImmatriculation($selectedValue);
        
        $vehiculeDetails = array(
            'marque' => $leVehicule->getMarque(),
            'modele' => $leVehicule->getModele(),
            'dateImmat' => $leVehicule->getDateImmatriculation(),
            'numPermis' => $leVehicule->getNumPermis()
        );

        echo json_encode($vehiculeDetails);
    } else {
        $vehiculeDetails = array();
        echo json_encode($vehiculeDetails);
    }
}
?>
