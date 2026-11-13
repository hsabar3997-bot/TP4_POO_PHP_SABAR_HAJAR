<?php

class Personne
{
    public string $nom;
    public string $prenom;
    private string $dateNaissance;
    private string $villeNaissance;
    private string $cin;

    public function __construct(
        string $nom,
        string $prenom,
        string $dateNaissance,
        string $villeNaissance,
        string $cin
    ) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->villeNaissance = $villeNaissance;
        $this->cin = $cin;
    }

    public function getName(): string
    {
        return $this->prenom . " " . $this->nom;
    }

    private function getAge(): int
    {
        $naissance = new DateTime($this->dateNaissance);
        $aujourdhui = new DateTime();
        return $naissance->diff($aujourdhui)->y;
    }
}

$p = new Personne("Hachimi", "Sara", "2000-05-14", "Marrakech", "EE123456");
echo $p->getName() . PHP_EOL; // Affiche : Sara Hachimi
echo $p->nom . PHP_EOL;       // Affiche : Hachimi

// Expérimentation (décommenter une ligne à la fois pour observer les Fatal Errors) :
// echo $p->cin;
// echo $p->dateNaissance;
// echo $p->getAge();