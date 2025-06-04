<?php
// on créé une classe dont on se servira pour appeler ses méthodes
class Planete_model {
    private $pdo;

    public function __construct($pdo) {
        // dans le construct, prend la variable pdo du controlleur pdo pour créer la connexion
        if (isset($pdo)) $this->pdo = $pdo;
    }

    public function get_planetes() {
        // cette fonction renvoie toutes les planètes de la table planete
        $result = array();

        try {
            $req = $this->pdo->prepare("select * from planete;");
            $req->execute();

            $a_planet = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_planet) {
                $result[] = $a_planet;
                $a_planet = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        // renvoie le message d'erreur par défaut si erreur il y a
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_planete_from_faction($faction_name) {
        // cette fonction renvoie toutes les planètes appartenant à une faction dont le nom est donné
        $result = array();

        try {
            // la faction est renseignée dans la table planete via son id uniquement, une jointure est
            // donc nécessaire
            $req = $this->pdo->prepare("select planete.* from planete inner join faction on faction.idF = planete.idF where faction.nom = :name;");
            $req->bindValue(':name', $faction_name, PDO::PARAM_STR);
            $req->execute();

            $a_planet = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_planet) {
                $result[] = $a_planet;
                $a_planet = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_planete_from_name($name) {
        // cette fonction renvoie une planète singulière dont le nom est donné
        try {
            $req = $this->pdo->prepare("select * from planete where nom = :name;");
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

            echo "All planetes with get_planetes() : \n";
            print_r($this->get_planetes());

            echo "Planetes from faction Imperium : \n";
            print_r($this->get_planete_from_faction("L'Imperium de l'humanité"));

            echo "Planete Cadia : \n";
            print_r($this->get_planete_from_name("Cadia"));
        }
    }
}
?>