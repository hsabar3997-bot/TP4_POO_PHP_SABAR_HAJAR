<?php

class Voiture
{
    public string $marque;
    public string $couleur;

    public function setMarque(string $m): void
    {
        $this->marque = $m;
    }

    public function setCouleur(string $c): void
    {
        $this->couleur = $c;
    }

    public function afficher(): void
    {
        echo "Marque: " . $this->marque . " | Couleur: " . $this->couleur . PHP_EOL;
    }
}

$v1 = new Voiture();
$v1->setMarque("Toyota");
$v1->setCouleur("Blanche");
$v1->afficher();

// 0.1 & 0.2 : Second objet $v2
$v2 = new Voiture();
$v2->setMarque("Renault");
$v2->setCouleur("Noire");
$v2->afficher();