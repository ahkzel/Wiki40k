<?php
// on créé une classe dont on se servira pour appeler ses méthodes
class Personnage_model {
    private $pdo;

    public function __construct($pdo) {
        // dans le construct, prend la variable pdo du controlleur pdo pour créer la connexion
        if (isset($pdo)) $this->pdo = $pdo;
    }

    public function get_personnages() {
        // cette fonction renvoie tous les éléments de la table personnage
        $result = array();

        try {
            $req = $this->pdo->prepare("select * from personnage;");
            $req->execute();

            $a_personnage = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_personnage) {
                $result[] = $a_personnage;
                $a_personnage = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        // renvoie le message d'erreur par défaut si erreur il y a
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_personnage_from_faction($faction_name) {
        // cette fonction renvoie tous les personnages appartenant à une faction dont le nom est donnée
        $result = array();

        try {
            // la faction est renseignée dans la table personnage par son id donc une jointure est nécessaire
            $req = $this->pdo->prepare("select personnage.* from personnage inner join faction on faction.idF = personnage.idF where faction.nom = :name;");
            $req->bindValue(':name', $faction_name, PDO::PARAM_STR);
            $req->execute();

            $a_personnage = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_personnage) {
                $result[] = $a_personnage;
                $a_personnage = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_personnage_from_sous_faction($s_faction_name) {
        // cette fonction renvoie tous les personnages appartenant à une sous-faction dont le nom est donnée
        $result = array();

        try {
            $req = $this->pdo->prepare("select * from personnage where sousFaction = :name;");
            $req->bindValue(':name', $s_faction_name, PDO::PARAM_STR);
            $req->execute();

            $a_personnage = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_personnage) {
                $result[] = $a_personnage;
                $a_personnage = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_personnage_from_classe($classe) {
        // cette fonction renvoie tous les personnages appartenant à une classe dont le nom est donnée
        $result = array();

        try {
            $req = $this->pdo->prepare("select * from personnage where classe = :classe;");
            $req->bindValue(':classe', $classe, PDO::PARAM_STR);
            $req->execute();

            $a_personnage = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_personnage) {
                $result[] = $a_personnage;
                $a_personnage = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function get_personnage_from_name($name) {
        // cette fonction renvoie un personnage seul dont le nom est donné
        try {
            $req = $this->pdo->prepare("select * from personnage where nom = :name;");
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

            echo "All personnages with get_personnages() : \n";
            print_r($this->get_personnages());

            echo "Personnages from faction Aeldari : \n";
            print_r($this->get_personnage_from_faction("Aeldari"));

            echo "Personnages from sous-faction Vaisseau Monde Ulthwé : \n";
            print_r($this->get_personnage_from_sous_faction("Vaisseau Monde Ulthwé"));

            echo "Personnages from classe Divin : \n";
            print_r($this->get_personnage_from_classe("Divin"));

            echo "Personnage Eldrad Ulthran : \n";
            print_r($this->get_personnage_from_name("Eldrad Ulthran"));
        }
    }
}
?>