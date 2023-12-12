<?php
class Vehicule {
    private $num_immat;
    private $date_immat;
    private $modele;
    private $marque;
    private $num_permis;

    function __construct(string $num_immat='', string $date_immat='', string $modele='', string $marque='', string $num_permis=''){
        $this->num_immat = $num_immat;
        $this->date_immat = $date_immat;
        $this->modele = $modele;
        $this->marque = $marque;
        $this->num_permis = $num_permis;
    }

    public function getNumImmatriculation(): string {
        return $this->num_immat;
    }
    
    public function setNumImmatriculation(string $num_immat) {
        $this->num_immat = $num_immat;
    }
    
    public function getDateImmatriculation(): string {
        return $this->date_immat;
    }
    
    public function setDateImmatriculation(string $date_immat) {
        $this->date_immat = $date_immat;
    }
    
    public function getModele(): string {
        return $this->modele;
    }
    
    public function setModele(string $modele) {
        $this->modele = $modele;
    }
    
    public function getMarque(): string {
        return $this->marque;
    }
    
    public function setMarque(string $marque) {
        $this->marque = $marque;
    }
    
    public function getNumPermis(): string {
        return $this->num_permis;
    }
    
    public function setNumPermis(string $num_permis) {
        $this->num_permis = $num_permis;
    }
    
}
?>
