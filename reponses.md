# Réponses aux questions — TP 4 : POO en PHP

## Partie 0
- **0.3** : Non, `$v1` et `$v2` ne partagent pas la même valeur de `$marque`. Chaque objet créé avec `new` possède sa propre copie en mémoire de ses propriétés d'instance.

## Partie 1
- **1.1** : `getName()` et `$p->nom` fonctionnent car ils sont `public`. En revanche, `$p->cin`, `$p->dateNaissance` et `$p->getAge()` déclenchent chacun une `Fatal error: Uncaught Error: Cannot access private property/method Personne::...` car ils sont déclarés `private`.
- **1.2** : Laisser `cin` en `public` permet à n'importe quelle partie extérieure du code de lire ou modifier librement cette donnée personnelle sensible sans aucun contrôle ni validation.
- **1.3** : Non, `getAge()` n'est pas inutile : elle sert de méthode utilitaire interne appelée par d'autres méthodes publiques de la même classe (comme `__toString()` dans la Partie 4) pour factoriser le calcul de l'âge.
- **1.4** : Non, le comportement depuis l'extérieur ne change pas : `protected` interdit toujours l'accès depuis l'extérieur de la classe (mais autorise l'accès aux classes filles).

## Partie 2
- **2.1.a** : `new Voiture("Noire")` fonctionne et utilise la valeur par défaut `0` pour `$vitesse`. En revanche, `new Voiture(120)` passe `120` au premier paramètre `$couleur` (converti en `"120"` sans `strict_types=1`), et si on passait un type incompatible avec `int` au 2ᵉ paramètre (ex. `new Voiture("Noire", "rapide")`), PHP lèverait une `TypeError`.
- **2.1.b** : La promotion de propriétés évite de répéter trois fois chaque attribut (déclaration, paramètre du constructeur, affectation `$this->... = ...`), rendant le code beaucoup plus concis et lisible.
- **2.2.a** : PHP affiche une `Fatal error: Cannot redeclare Personne::__construct()` car PHP ne supporte pas la surcharge de méthodes (avoir deux méthodes portant le même nom dans une même classe).
- **2.2.b** : Utiliser un seul constructeur avec des paramètres ayant des valeurs par défaut : `public function __construct(public string $nom = "", public string $prenom = "")`.
- **2.2.c** : Une méthode statique de fabrique (*named constructor*) est une méthode `public static` qui retourne une nouvelle instance (`new self(...)`) construite à partir d'un format spécifique (comme un tableau associatif), offrant un nom explicite et plusieurs façons d'instancier la classe.
- **2.3.a** : 1) `Voiture Blanche créée.` 2) `Voiture Blanche détruite.` (déclenché par `unset()`) 3) `Fin du script.`
- **2.3.b** : Sans `unset()`, l'ordre devient : 1) `Voiture Blanche créée.` 2) `Fin du script.` 3) `Voiture Blanche détruite.` (détruit automatiquement à la fin de l'exécution du script).
- **2.3.c** : À la fin du script, PHP détruit les objets dans l'ordre inverse de leur création (LIFO) : `$b` est détruit en premier, puis `$a`.

## Partie 3
- **3.2** : Sans `__set()`, écrire `$p->nom = "X"` provoque une `Fatal error: Cannot access private property Personne::$nom`. Avec `__set()`, PHP intercepte l'affectation et exécute `__set('nom', 'X')`.
- **3.3** : Oui, un `__set()` sans contrôle permettrait d'affecter n'importe quelle valeur invalide aux attributs privés. Pour préserver l'encapsulation, il faut ajouter des conditions de validation dans `__set()` et lever une exception en cas d'erreur.

## Partie 4
- **4.1** : `__toString()` fait partie de la classe `Personne` elle-même ; elle a donc le droit d'appeler les méthodes `private` de cette même classe.
- **4.2** : Si `__toString()` retourne un entier sans `strict_types=1`, PHP le convertit automatiquement en chaîne de caractères (ex. `25` devient `"25"`). Avec `declare(strict_types=1);`, PHP lève une `TypeError`.
- **4.3** : `__toString()` permet d'utiliser l'objet directement dans un contexte textuel sans appeler explicitement une méthode : par exemple lors d'un `echo $p;`, d'une concaténation (`"Bonjour " . $p`), ou de l'interpolation dans une chaîne (`"Étudiant : $p"`).

## Partie 5
- **5.1** : Non, le mot de passe ne figure pas dans la chaîne sérialisée car `__serialize()` ne retourne que `nom` et `age`.
- **5.2** : En commentant `__serialize()`, PHP sérialise toutes les propriétés de l'objet, y compris `$motDePasse` (`"secret123"`) en clair. Cela expose des données sensibles si la chaîne est stockée dans un fichier, une base ou un cookie.
- **5.3** : Après `unserialize()`, `$motDePasse` vaut `""` (chaîne vide). Dans une vraie application, il faut soit recharger le hash du mot de passe depuis la base de données, soit demander une réauthentification.
- **5.4** : Désérialiser des données non fiables expose à une faille **PHP Object Injection** : un attaquant peut forger une chaîne sérialisée pour instancier des objets arbitraires et déclencher des méthodes magiques (`__destruct()`, `__wakeup()`) afin d'exécuter du code malveillant. Pour échanger des données en toute sécurité, on utilise `json_encode()` et `json_decode()`.

## Partie 6
- **6.1.b** : Non, `$c->miauler()` provoque une erreur (`Call to undefined method Chien::miauler()`) car `$c` est une instance de `Chien`, et `miauler()` appartient uniquement à la classe sœur `Chat`.
- **6.2.a** : Si on supprime `parent::__construct($nom)`, la propriété `$this->nom` n'est jamais initialisée, provoquant une erreur lors de l'accès à `$this->nom` dans `presentation()`.
- **6.2.b** : `$nom` est `protected` afin d'être accessible directement dans la classe fille `Etudiant` tout en restant protégé de l'extérieur.
- **6.3.a** :
  1. Redéfinir `afficher()` dans `Fille` : `Fatal error: Cannot override final method Base::afficher()`.
  2. Étendre `Outil` : `Fatal error: Class SousOutil cannot extend final class Outil`.
  3. Modifier `$p->reference` : `Fatal error: Cannot modify readonly property Produit::$reference`.
- **6.3.b** : `readonly` est pertinent pour un identifiant unique (ID, ISBN, numéro de facture) ou une date de création qui ne doit jamais changer après initialisation. `final` est pertinent pour une classe de sécurité/cryptographie ou une méthode métier critique dont le comportement ne doit pas être altéré par héritage.
- **6.4.a** : Appeler `getAge()` depuis `Etudiant` alors qu'elle est `private` dans `Personne` déclenche une `Fatal error: Call to private method Personne::getAge() from scope Etudiant`. Il faut lui donner la visibilité `protected`.
- **6.4.b** : `$this->dateNaissance` est `private` dans `Personne` : même si `Etudiant` hérite de `Personne`, les membres `private` restent strictement réservés à la classe où ils sont déclarés.
- **6.4.c** : Réutiliser `parent::__toString()` évite la duplication de code et garantit que toute modification future de l'affichage d'une `Personne` sera automatiquement répercutée sur `Etudiant`.

## Partie 7
- **7.1** : Dans `un_an()`, il manque un opérateur entre `$this->montant` et `1` : `($this->montant 1* $this->interet / 100)` provoque une `ParseError: syntax error, unexpected integer "1"`.
- **7.2** : La bonne formule pour appliquer un taux d'intérêt annuel $t\%$ est :
  $$M_{n+1} = M_n \times \left(1 + \frac{t}{100}\right)$$
  En PHP : `$this->montant = $this->montant * (1 + $this->interet / 100);`.
- **7.3** : Non, l'énoncé demande un montant initial puis un intérêt, alors que le constructeur buggé inversait l'ordre (`$interet, $montantInitial`). Cela risque d'inverser les valeurs lors de l'instanciation (ex. `new Compte(10, 400)` crée un compte de 10 DH à 400 % d'intérêt au lieu de 400 DH à 10 %).

## Questions de synthèse
1. **Classe vs Objet** : Une **classe** est un modèle (plan) définissant la structure (attributs) et les comportements (méthodes), tandis qu'un **objet** est une instance concrète créée en mémoire à partir de cette classe via `new`.
2. **Trois avantages de la POO** : Meilleure organisation et modularité du code, réutilisabilité grâce à l'héritage, et protection/intégrité des données grâce à l'encapsulation.
3. **Pourquoi `private` ou `protected`** : Pour respecter l'encapsulation, empêcher la modification directe et incohérente des données depuis l'extérieur, et imposer le passage par des méthodes contrôlées (getters/setters).
4. **`private` vs `protected` avec héritage** : Un membre `private` n'est accessible que dans la classe qui le déclare ; un membre `protected` est accessible dans la classe mère **et** dans toutes ses classes filles.
5. **Visibilité des méthodes magiques** : Oui, toutes les méthodes magiques doivent être déclarées `public` (PHP émet un avertissement sinon). Seules `__construct()`, `__destruct()` et `__clone()` peuvent être `private` ou `protected` (par exemple pour le patron Singleton).