<?php
require_once('comprend.class.php');
require_once('connexion.php');

class ComprendDAO {
    private $bd;
    private $select;

    function __construct() {
        $this->bd = new Connexion();
        $this->select = 'SELECT id_inf, id_delit FROM comprend';
    }

    private function loadQuery($result) {
        $comprends = [];
        foreach ($result as $row) {
            $comprend = new Comprend();
            $comprend->setIdInfraction($row['id_inf']);
            $comprend->setIdDelit($row['id_delit']);
            $comprends[] = $comprend;
        }
        return $comprends;
    }

    function getAll(): array {
        return $this->loadQuery($this->bd->execSQL($this->select));
    }

    function getByIdInfraction(string $id_inf): Array {
        $lesComprends = $this->loadQuery($this->bd->execSQL($this->select . " WHERE id_inf=:id_inf", [':id_inf' => $id_inf]));
        return $lesComprends;
    }

    function insert(Comprend $comprend) : void {
        $req = "INSERT INTO comprend (id_inf, id_delit) VALUES (:id_inf, :id_delit)";
        $this->bd->execSQL($req, [':id_inf' => $comprend->getIdInfraction(), ':id_delit' => $comprend->getIdDelit()]);
    }

    function delete(Comprend $comprend) : void {
        $req = "DELETE FROM comprend WHERE id_inf = :id_inf";
        $this->bd->execSQL($req, [':id_inf' => $comprend->getIdInfraction()]);
    }

    function deleteById(string $id_inf) : void {
        $req = "DELETE FROM comprend WHERE id_inf = :id_inf";
        $this->bd->execSQL($req, [':id_inf' => $id_inf]);
    }

    function update(Comprend $comprend) : void {
        $req = "UPDATE comprend SET id_delit = :id_delit WHERE id_inf = :id_inf";
        $this->bd->execSQL($req, [':id_inf' => $comprend->getIdInfraction(), ':id_delit' => $comprend->getIdDelit()]);
    }

    function existe(Comprend $comprend) : bool{
        $req = "SELECT * FROM comprend WHERE id_inf = :id_inf AND id_delit = :id_delit";
        $res = $this->loadQuery($this->bd->execSQL($req, [':id_inf' => $comprend->getIdInfraction(), ':id_delit' => $comprend->getIdDelit()]));
        return !empty($res);
    }
}
?>
