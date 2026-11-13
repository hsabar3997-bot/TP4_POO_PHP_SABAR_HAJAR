<?php

// 2.1 & 2.3 : Constructeur avec promotion de propriétés + Destructeur
class Voiture
{
    public function __construct(
        public string $couleur = "Blanche",
        public int $vitesse = 0
    ) {
        echo "Voiture {$this->couleur} créée." . PHP_EOL;
    }

    public function afficher(): void
    {
        echo "Couleur: {$this->couleur} | Vitesse: {$this->vitesse} km/h" . PHP_EOL;
    }

    public function __destruct()
    {
        echo "Voiture {$this->couleur} détruite." . PHP_EOL;
    }
}

$v1 = new Voiture();
$v2 = new Voiture("Rouge", 50);
$v3 = new Voiture("Noire"); // Utilise vitesse = 0 par défaut
$v1->afficher();
$v2->afficher();
$v3->afficher();

unset($v1); // Appelle immédiatement __destruct() pour $v1

// 2.2 : Un seul constructeur avec valeurs par défaut + méthode statique de fabrique
class Personne
{
    public function __construct(
        public string $nom = "",
        public string $prenom = ""
    ) {
        if ($this->nom === "" && $this->prenom === "") {
            echo "Création " . __CLASS__ . " vide" . PHP_EOL;
        }
    }

    public static function depuisTableau(array $data): self
    {
        return new self(
            $data['nom'] ?? "",
            $data['prenom'] ?? ""
        );
    }

    public function __destruct()
    {
        echo "Détruire " . __CLASS__ . PHP_EOL;
    }
}

$pVide = new Personne();
$pInfo = new Personne("Alami", "Youssef");
$pTab = Personne::depuisTableau(['nom' => 'Bennani', 'prenom' => 'Salma']);

echo "Fin du script." . PHP_EOL;