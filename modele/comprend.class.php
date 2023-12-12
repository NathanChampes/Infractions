<?php
class Comprend {
    private $id_inf;
    private $id_delit;

    function __construct(string $id_inf='', string $id_delit=''){
        $this->id_inf = $id_inf;
        $this->id_delit = $id_delit;
    }

    public function getIdInfraction(): string {
        return $this->id_inf;
    }
    
    public function setIdInfraction(string $id_inf) {
        $this->id_inf = $id_inf;
    }
    public function getIdDelit(): string {
        return $this->id_delit;
    }
    
    public function setIdDelit(string $id_delit) {
        $this->id_delit = $id_delit;
    }
    
}
?>
