<?php
class Delit {
    private $id_delit;
    private $nature;
    private $tarif;

    function __construct(string $id_delit='', string $nature='', string $tarif=''){
        $this->id_delit = $id_delit;
        $this->nature = $nature;
        $this->tarif = $tarif;
    }

    public function getIdDelit(): string {
        return $this->id_delit;
    }
    
    public function setIdDelit(string $id_delit) {
        $this->id_delit = $id_delit;
    }
    
    public function getNatureDelit(): string {
        return $this->nature;
    }
    
    public function setNatureDelit(string $nature) {
        $this->nature = $nature;
    }
    
    public function getTarifDelit(): string {
        return $this->tarif;
    }
    
    public function setTarifDelit(string $tarif) {
        $this->tarif = $tarif;
    }
    
}
?>
