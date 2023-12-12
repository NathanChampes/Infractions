<?php
class Conducteur {
    private $num_permis;
    private $date_permis;
    private $nom;
    private $prenom;
    private $motdepasse;
    private $admin;

    function __construct(string $num_permis='', string $date_permis='', string $nom='', string $prenom='', string $motdepasse ="", bool $admin=false){
        $this->num_permis = $num_permis;
        $this->date_permis = $date_permis;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->motdepasse = $motdepasse;
        $this->admin = $admin;
    }

    public function getNumPermis(): string {
        return $this->num_permis;
    }

    public function setNumPermis(string $num_permis) {
        $this->num_permis = $num_permis;
    }

    public function getDatePermis(): string {
        return $this->date_permis;
    }

    public function setDatePermis(string $date_permis) {
        $this->date_permis = $date_permis;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom) {
        $this->prenom = $prenom;
    }
    public function getMdp(): string {
        return $this->motdepasse;
    }

    public function setMdp(string $mdp) {
        $this->motdepasse = $mdp;
    }
    public function getAdmin(): bool {
        return $this->admin;
    }

    public function setAdmin(bool $admin) {
        $this->admin = $admin;
    }
}
?>
