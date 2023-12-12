<?php
require_once('infraction.class.php');
require_once('connexion.php');

class InfractionDAO {
    private $bd;
    private $select;

    function __construct() {
        $this->bd = new Connexion();
        $this->select = 'SELECT id_inf, date_inf, num_permis, num_immat FROM infraction';
    }

    private function loadQuery($result) {
        $infractions = [];
        foreach ($result as $row) {
            $infraction = new Infraction();
            $infraction->setIdInfraction($row['id_inf']);
            $infraction->setDateInfraction($row['date_inf']);
            $infraction->setIdPermis($row['num_permis']);
            $infraction->setIdImmatriculation($row['num_immat']);
            $infractions[] = $infraction;
        }
        return $infractions;
    }

    function getAll(): array {
        return $this->loadQuery($this->bd->execSQL($this->select . " ORDER BY id_inf ASC"));
    }

    function getByIdInfraction(string $id_inf): Array { 
        $lesInfractions = $this->loadQuery($this->bd->execSQL($this->select . " WHERE id_inf=:id_inf", [':id_inf' => $id_inf]));
        return $lesInfractions;
    }

    function getByNumPermis(string $num_permis): Array {
        $lesInfractions = $this->loadQuery($this->bd->execSQL($this->select . " WHERE num_permis=:num_permis", [':num_permis' => $num_permis]));
        return $lesInfractions;
    }

    function insert(Infraction $inf) : void {
        $req = "INSERT INTO infraction (id_inf, date_inf, num_permis, num_immat) VALUES (:id_inf, :date_inf, :num_permis, :num_immat)";
        $this->bd->execSQL($req, [':id_inf' => $inf->getIdInfraction(), ':date_inf' => $inf->getDateInfraction(), ':num_permis' => $inf->getIdPermis(), ':num_immat' => $inf->getIdImmatriculation()]);
    }

    function delete(string $idInf) : void {
        $req = "DELETE FROM infraction WHERE id_inf = :id_inf";
        $this->bd->execSQL($req, [':id_inf' => $idInf]);
    }

    function update(Infraction $inf) : void {
        $req = "UPDATE infraction SET date_inf = :date_inf, num_permis = :num_permis, num_immat = :num_immat WHERE id_inf = :id_inf";
        $this->bd->execSQL($req, [':id_inf' => $inf->getIdInfraction(), ':date_inf' => $inf->getDateInfraction(), ':num_permis' => $inf->getIdPermis(), ':num_immat' => $inf->getIdImmatriculation()]);
    }
    
    function existe(string $id_inf): bool {
        $req = "SELECT * FROM infraction WHERE id_inf = :id_inf";
        $res = $this->loadQuery($this->bd->execSQL($req, [':id_inf' => $id_inf]));
        return !empty($res);
    }
    function existeJSON(Infraction $inf): array|null {
        $req = "SELECT * FROM infraction WHERE date_inf = :date_inf AND num_permis = :num_permis AND num_immat = :num_immat";
        $res = $this->loadQuery($this->bd->execSQL($req, [':date_inf' => $inf->getDateInfraction(), ':num_permis' => $inf->getIdPermis(), ':num_immat' => $inf->getIdImmatriculation()]));
        return ($res);
    }
}
?>
