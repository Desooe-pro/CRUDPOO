<?php

/* Class Database
 * Se connecter à la base de données
 * Bien gérer les ressources (pattern Singleton)
 *
*/

class Database {
    // Propriétés privées - instance unique de la connexion
    private static $instance = null;

    // Pour stocker l'objet $pdo
    private $pdo;

    // Constructeur privé (Il ne peut être appelé qu'une seule fois)
    private function __construct() {
        // Configuration de la base de données
        $host = "localhost"; // sans le port
        $dbname = "cafthe";
        $user = "root";
        $pass = "";

        try {
            $this -> pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this -> pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e -> getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        // retourn l'objet PDO. Pourquoi ? Pour pouvoir faire des requêtes
        return $this -> pdo;
    }
}

// $db = Database::getInstance() -> getConnection();