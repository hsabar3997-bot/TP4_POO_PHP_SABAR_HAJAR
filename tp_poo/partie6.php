<?php

// --- 6.1 : Animal, Chien, Chat ---
class Animal
{
    public function manger(): void
    {
        echo "L'animal mange." . PHP_EOL;
    }
}

class Chien extends Animal
{
    public function aboyer(): void
    {
        echo "Le chien aboie." . PHP_EOL;
    }
}

class Chat extends Animal
{
    public function miauler(): void
    {
        echo "Le chat miaule." . PHP_EOL;
    }
}

$c = new Chien();
$c->manger();
$c->aboyer();

$chat = new Chat();
$chat->manger();
$chat->miauler();

// --- 6.3 : final et readonly ---
class Base
{
    final public function afficher(): void
    {
        echo "Méthode finale de Base." . PHP_EOL;
    }
}

final class Outil
{
    public function executer(): void
    {
        echo "Outil non extensible." . PHP_EOL;
    }
}

class Produit
{
    public function __construct(public readonly string $reference)
    {
    }
}

$prod = new Produit("REF-001");
echo $prod->reference . PHP_EOL;

// --- 6.4 : Exercice principal Personne & Etudiant ---
class Personne
{
    private string $nom;
    private string $prenom;
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

    // Visibilité protected nécessaire pour que Etudiant puisse y accéder
    protected function getAge(): int
    {
        $naissance = new DateTime($this->dateNaissance);
        $aujourdhui = new DateTime();
        return $naissance->diff($aujourdhui)->y;
    }

    public function __toString(): string
    {
        return "{$this->prenom} {$this->nom} ({$this->getAge()} ans)";
    }
}

class Etudiant extends Personne
{
    private string $cne;

    public function __construct(
        string $nom,
        string $prenom,
        string $dateNaissance,
        string $villeNaissance,
        string $cin,
        string $cne
    ) {
        parent::__construct($nom, $prenom, $dateNaissance, $villeNaissance, $cin);
        $this->cne = $cne;
    }

    public function getCne(): string
    {
        return $this->cne;
    }

    public function __toString(): string
    {
        return parent::__toString() . " | CNE: " . $this->cne;
    }
}

$etudiants = [
    new Etudiant("Hachimi", "Sara", "2003-05-14", "Marrakech", "EE111111", "G130001"),
    new Etudiant("Alami", "Youssef", "2002-11-20", "Casablanca", "BK222222", "G130002"),
    new Etudiant("Bennani", "Salma", "2004-02-10", "Rabat", "A333333", "G130003"),
    new Etudiant("Tazi", "Omar", "2003-08-03", "Fès", "CD444444", "G130004"),
    new Etudiant("Idrissi", "Khadija", "2002-01-25", "Agadir", "J555555", "G130005"),
];

foreach ($etudiants as $etudiant) {
    echo $etudiant . PHP_EOL;
}