<?php
// inclue le controller pdo dans le model
include_once __DIR__."/../controller/pdo_controller.php";

// on créé une classe dont on se servira pour appeler ses méthodes
class Minifigs_model {
    private $pdo;

    public function __construct() {
        // dans le construct, prend la variable pdo du controlleur pdo pour créer la connexion
        if (isset($pdo_con)) $this->pdo = $pdo_con;
    }

    public function get_sets() {
        // cette fonction renvoie tous les sets de la table minifigs_sets
        $result = array();
        
        try {
            $req = $this->pdo->prepare("select * from minifigs_sets;");
            $req->execute();

            // on créé une boucle pour être sûr d'avoir tous les éléments séparés dans notre tableau result
            $a_set = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_set) {
                $result[] = $a_set;
                $a_set = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        // renvoie le message d'erreur par défaut si erreur il y a
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_sets_stock_above_0() {
        // cette fonction renvoie tous les sets dont le stock est supérieur à 0
        $result = array();

        try {
            $req = $this->pdo->prepare("select * from minifigs_sets where stock >= 0;");
            $req->execute();

            $a_set = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_set) {
                $result[] = $a_set;
                $a_set = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_sets_under_price($price) {
        // cette fonction renvoie tous les sets qui coûtent moins cher qu'un certain prix
        $result = array();

        try {
            $req = $this->pdo->prepare("select * from minifigs_sets where prix <= :price;");
            // il n'y a pas de PDO::PARAM_FLOAT donc il faut définir le format de notre entrée autrement
            $req->bindValue(':price', number_format($price, 2, '.', ''), PDO::PARAM_STR);
            $req->execute();

            $a_set = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_set) {
                $result[] = $a_set;
                $a_set = $req->fetcht(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_sets_from_faction($faction_name) {
        // cette fonction renvoie les sets appartenant à une faction dont le nom est donné
        $result = array();

        try {
            // la table faction est référencée dans la table minifigs_sets via son id, une jointure est
            // donc nécessaire
            $req = $this->pdo->prepare("select * from minifigs_sets inner join faction on faction.idF = minifigs_sets.idF where faction.nom = :name and minifigs_sets.stock >= 0;");
            $req->bindValue(':name', $faction_name, PDO::PARAM_STR);
            $req->execute();

            $a_set = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_set) {
                $result[] = $a_set;
                $a_set = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_sets_from_name($name) {
        // cette fonction renvoie un set singulier dont le nom est donné
        try {
            $req = $this->pdo->prepare("select * from minifigs_sets where nom = :name;");
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

            echo "All sets with get_sets() : \n";
            print_r($this->get_sets());

            echo "Sets where stock is above 0 : \n";
            print_r($this->get_sets_stock_above_0());

            echo "Sets where the price is under 40€ : \n";
            print_r($this->get_sets_under_price(40.00));

            echo "Sets from faction space marine : \n";
            print_r($this->get_sets_from_faction("Space marines"));

            echo "Set escouade d'intercesseurs : \n";
            print_r($this->get_sets_from_name("escouade d'intercesseurs"));
        }
    }
}
?>