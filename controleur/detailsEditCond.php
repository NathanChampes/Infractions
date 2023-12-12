<?php
require_once('../modele/conducteurDAO.class.php');

if (isset($_GET['selectedValue'])) {
    $selectedValue = $_GET['selectedValue'];
    if ($selectedValue != "Selectionner un permis") {
        $conducteurDAO = new ConducteurDAO();
        $leConducteur = $conducteurDAO->getByNumPermis($selectedValue);
        
        $conducteurDetails = array(
            'nom' => $leConducteur->getNom(),
            'prenom' => $leConducteur->getPrenom(),
            'datePermis' => $leConducteur->getDatePermis()
        );

        echo json_encode($conducteurDetails);
    } else {
        $conducteurDetails = array();
        echo json_encode($conducteurDetails);
    }
}
?>
