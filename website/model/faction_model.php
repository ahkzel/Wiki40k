<?php
// inclue le controller pdo dans le model
include_once(__DIR__."/controller/pdo_controller.php");

// on créé une classe dont on se servira pour appeler ses méthodes
class Faction_model {
    private $pdo;

    public function __construct() {
        // dans le construct, prend la variable pdo du controlleur pdo pour créer la connexion
        if (isset($_GET["con"])) $this->pdo = $_GET["con"];
    }

    public function get_factions() {
        // cette fonction renvoie toutes les factions de la table faction
        $result = array();

        try {
            $req = $this->pdo->prepare("select * from faction;");
            $req->execute();

            // on créé une boucle pour être sûr d'avoir tous les éléments séparés dans notre tableau result
            $a_faction = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_faction) {
                $result[] = $a_faction;
                $a_faction = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        // renvoie le message d'erreur par défaut si erreur il y a
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_faction_from_appartenance($appartenance) {
        // cette fonction renvoie toutes les factions appartenant à une autre faction dont le nom est donné
        $result = array();

        try {
            $req = $this->pdo->prepare("select * from faction where appartenance = :appartenance;");
            $req->bindValue(':appartenance', $appartenance, PDO::PARAM_STR);
            $req->execute();

            $a_faction = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_faction) {
                $result[] = $a_faction;
                $a_faction = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_faction_from_name($name) {
        // cette fonction renvoie une faction singulière dont le nom est donné
        try {
            $req = $this->pdo->prepare("select * from faction where nom = :name;");
            $req->bindValue(':name', $name, PDO::PARAM_STR);
            $req->execute();

            $result = $req->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function testAll() {
        // fonction de test qui teste toutes les méthodes de la classe avec un exemple
        if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
            header('Content-type:text/plain');

            echo "All factions with get_factions() : \n";
            print_r($this->get_factions());

            echo "SubFactions of The Ancients with get_faction_from_appartenance() : \n";
            print_r($this->get_faction_from_appartenance("Les Anciens"));

            echo "Faction Aeldari with get_faction_from_name() : \n";
            print_r($this->get_faction_from_name("Aeldari"));
        }
    }
}
?>