<?php
class Infraction {
    private $id_inf;
    private $date_inf;
    private $num_permis;
    private $num_immat;

    function __construct(string $id_inf='', string $date_inf='', string $num_permis='', string $num_immat=''){
        $this->id_inf = $id_inf;
        $this->date_inf = $date_inf;
        $this->num_permis = $num_permis;
        $this->num_immat = $num_immat;
    }

    public function getIdInfraction(): string {
        return $this->id_inf;
    }
    
    public function setIdInfraction(string $id_inf) {
        $this->id_inf = $id_inf;
    }
    
    public function getDateInfraction(): string {
        return $this->date_inf;
    }
    
    public function setDateInfraction(string $date_inf) {
        $this->date_inf = $date_inf;
    }
    
    public function getIdPermis(): string {
        return $this->num_permis;
    }
    
    public function setIdPermis(string $num_permis) {
        $this->num_permis = $num_permis;
    }
    
    public function getIdImmatriculation(): string {
        return $this->num_immat;
    }
    
    public function setIdImmatriculation(string $num_immat) {
        $this->num_immat = $num_immat;
    }
    
}
?>
