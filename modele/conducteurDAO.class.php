<?php
require_once('conducteur.class.php');
require_once('connexion.php');

class ConducteurDAO {
    private $bd;
    private $select;

    function __construct() {
        $this->bd = new Connexion();
        $this->select = 'SELECT num_permis, date_permis, nom, prenom, motdepasse, admin FROM conducteur WHERE admin = 0';
    }

    private function loadQuery(array $result): array {
        $conducteurs = [];
        foreach($result as $row) {
            $conducteur = new Conducteur();
            $conducteur->setNumPermis($row['num_permis']);
            $conducteur->setDatePermis($row['date_permis']);
            $conducteur->setNom($row['nom']);
            $conducteur->setPrenom($row['prenom']);
            $conducteur->setMdp($row['motdepasse']);
            $conducteur->setAdmin($row['admin']);
            $conducteurs[] = $conducteur;
        }
        return $conducteurs;
    }

    function getAll(): array {
        return ($this->loadQuery($this->bd->execSQL($this->select)));
    }

    function getByNumPermis(string $num_permis): Conducteur {
        $unConducteur = new Conducteur();
        $lesConducteurs = $this->loadQuery($this->bd->execSQL($this->select . " AND num_permis=:num_permis", [':num_permis' => $num_permis]));
        if (count($lesConducteurs) > 0) { 
            $unConducteur = $lesConducteurs[0];
        }
        return $unConducteur;
    }

    function existe(string $num_permis): bool {
        $req = "SELECT * FROM conducteur WHERE num_permis = :num_permis";
        $res = ($this->loadQuery($this->bd->execSQL($req, [':num_permis' => $num_permis])));
        return ($res != []);
    }

    function isAdmin(string $num_permis): bool {
        $req = "SELECT * FROM conducteur WHERE num_permis = :num_permis AND admin = 1";
        $res = ($this->loadQuery($this->bd->execSQL($req, [':num_permis' => $num_permis])));
        return ($res != []);
    }
}
?>

