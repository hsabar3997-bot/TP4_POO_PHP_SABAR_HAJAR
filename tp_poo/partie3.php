<?php

class Personne
{
    private string $nom;
    private string $prenom;
    private string $dateNaissance;
    private string $villeNaissance;
    private string $cin;
    private array $attributsDynamiques = [];

    public function __set(string $name, mixed $value): void
    {
        if ($name === 'nom') {
            if (!is_string($value) || strlen(trim($value)) < 2) {
                throw new InvalidArgumentException("Le nom ne doit pas être vide et doit contenir au moins 2 caractères.");
            }
        }

        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            $this->attributsDynamiques[$name] = $value;
        }
    }

    public function __get(string $name): mixed
    {
        if (property_exists($this, $name)) {
            return isset($this->$name) ? $this->$name : null;
        }
        return $this->attributsDynamiques[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        if (property_exists($this, $name)) {
            return isset($this->$name);
        }
        return isset($this->attributsDynamiques[$name]);
    }

    public function __unset(string $name): void
    {
        if (property_exists($this, $name)) {
            unset($this->$name);
        } else {
            unset($this->attributsDynamiques[$name]);
        }
    }
}

$p = new Personne();
$p->nom = "Hachimi";              // -> __set
echo $p->nom . PHP_EOL;           // -> __get
var_dump(isset($p->nom));         // -> __isset (true)
unset($p->nom);                   // -> __unset
var_dump(isset($p->nom));         // -> __isset (false)

$p->telephone = "0600000000";     // -> __set (propriété inexistante)
echo $p->telephone . PHP_EOL;     // -> __get