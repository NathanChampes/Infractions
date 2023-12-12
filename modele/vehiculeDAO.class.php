<?php
require_once('vehicule.class.php');
require_once('connexion.php');


class VehiculeDAO {
    private $bd;
    private $select;

    function __construct() {
        $this->bd = new Connexion();
        $this->select = 'SELECT num_immat, date_immat, modele, marque, num_permis FROM vehicule';
    }

    private function loadQuery($result) {
        $vehicules = [];
        foreach ($result as $row) {
            $vehicule = new Vehicule();
            $vehicule->setNumImmatriculation($row['num_immat']);
            $vehicule->setDateImmatriculation($row['date_immat']);
            $vehicule->setModele($row['modele']);
            $vehicule->setMarque($row['marque']);
            $vehicule->setNumPermis($row['num_permis']);
            $vehicules[] = $vehicule;
        }
        return $vehicules;
    }

    function getAll(): array {
        return $this->loadQuery($this->bd->execSQL($this->select));
    }

    function getByNumImmatriculation(string $num_immat): Vehicule {
        $unVehicule = new Vehicule();
        $lesVehicules = $this->loadQuery($this->bd->execSQL($this->select . " WHERE num_immat=:num_immat", [':num_immat' => $num_immat]));
        if (count($lesVehicules) > 0) { 
            $unVehicule = $lesVehicules[0]; 
        }
        return $unVehicule;
    }

    function existe(string $num_immat): bool {
        $req = "SELECT * FROM vehicule WHERE num_immat = :num_immat";
        $res = $this->loadQuery($this->bd->execSQL($req, [':num_immat' => $num_immat]));
        return !empty($res);
    }
}
?>
