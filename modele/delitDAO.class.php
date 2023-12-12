<?php
require_once('delit.class.php');
require_once('connexion.php');

class DelitDAO {
    private $bd;
    private $select;

    function __construct() {
        $this->bd = new Connexion();
        $this->select = 'SELECT id_delit, nature, tarif FROM delit';
    }

    private function loadQuery($result) {
        $delits = [];
        foreach ($result as $row) {
            $delit = new Delit();
            $delit->setIdDelit($row['id_delit']);
            $delit->setNatureDelit($row['nature']);
            $delit->setTarifDelit($row['tarif']);
            $delits[] = $delit;
        }
        return $delits;
    }

    function getAll(): array {
        return $this->loadQuery($this->bd->execSQL($this->select));
    }

    function getByIdDelit(string $id_delit): Delit {
        $unDelit = new Delit();
        $lesDelits = $this->loadQuery($this->bd->execSQL($this->select . " WHERE id_delit=:id_delit", [':id_delit' => $id_delit]));
        if (count($lesDelits) > 0) { 
            $unDelit = $lesDelits[0]; 
        }
        return $unDelit;
    }

    function existe(string $id_delit): bool {
        $req = "SELECT * FROM delit WHERE id_delit = :id_delit";
        $res = $this->loadQuery($this->bd->execSQL($req, [':id_delit' => $id_delit]));
        return !empty($res);
    }
}
?>
