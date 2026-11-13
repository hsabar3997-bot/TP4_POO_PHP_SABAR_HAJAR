<?php

class Utilisateur
{
    private string $nom;
    private int $age;
    private string $motDePasse;

    public function __construct(string $nom, int $age, string $motDePasse)
    {
        $this->nom = $nom;
        $this->age = $age;
        $this->motDePasse = $motDePasse;
    }

    public function __serialize(): array
    {
        return [
            'nom' => $this->nom,
            'age' => $this->age,
            // $motDePasse est volontairement exclu pour des raisons de sécurité
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->nom = $data['nom'];
        $this->age = $data['age'];
        $this->motDePasse = ""; // réinitialisé
    }
}

$u = new Utilisateur("Alice", 25, "secret123");
$serialise = serialize($u);
echo "Sérialisé: $serialise" . PHP_EOL;

$restaure = unserialize($serialise);
var_dump($restaure);