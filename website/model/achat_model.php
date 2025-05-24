<?php
// inclue le controller pdo dans le model
include_once(__DIR__."controller/pdo_controller.php");

// on créé une classe dont on se servira pour appeler ses méthodes
class Achat_model {
    private $pdo;

    public function __construct() {
        // dans le construct, prend la variable pdo du controlleur pdo pour créer la connexion
        if (isset($_GET["con"])) $this->pdo = $_GET["con"];
    }

    public function get_achat_from_name_email($name, $emailU) {
        // Cette fonction renvoie tous les achats d'un meme set fait par un utilisateur dont l'email est donné
        $results = array();

        try {
            $req = $this->pdo->prepare("select * from achat inner join minifigs_sets on minifigs_sets.idM = achat.idM where minifigs_sets.nom = :name and achat.emailU = :emailU;");
            $req->bindValue(':name', $name, PDO::PARAM_STR);
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->execute();

            // on créé une boucle pour être sûr d'avoir tous les éléments séparés dans notre tableau result
            $an_item = $req->fetch(PDO::FETCH_ASSOC);
            while ($an_item) {
                $results[] = $an_item;
                $an_item = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        // renvoie le message d'erreur par défaut si erreur il y a
        catch (PDOException $e) {
            print($e->getMessage());
            return [];
        }
        return $results;
    }

    public function delete_achat_from_name_email($name, $emailU) {
        // Cette fonction renvoie TRUE si on réussi à supprimer les achats d'un set fais par un utilisateur dont l'email est donné
        try {
            $req = $this->pdo->prepare("delete from achat join minifigs_sets on minifigs_sets.idM = achat.idM where minifigs_sets.nom = :name and achat.emailU = :emailU;");
            $req->bindValue(':name', $name, PDO::PARAM_STR);
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->execute();
        }
        catch (PDOException $e) {
            print($e->getMessage());
            return FALSE;
        }
        return TRUE;
    }

    public function get_all_achat_from_email($emailU) {
        // Cette fonction renvoie tous les achats effectués par un utilisateur dont l'email est donné
        $results = array();

        try {
            $req = $this->pdo->prepare("select * from achat where emailU = :emailU;");
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->execute();

            $an_item = $req->fetch(PDO::FETCH_ASSOC);
            while ($an_item) {
                $results[] = $an_item;
                $an_item = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            return [];
        }
        return $results;
    }

    public function delete_all_achat_from_email($emailU) {
        // Cette fonction renvoie TRUE si elle réussi à supprimer  tous les achats d'un utilisateur dont l'email est donné
        try {
            $req = $this->pdo->prepare("delete from achat where emailU = :emailU;");
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->execute();
        }
        catch (PDOException $e) {
            print($e->getMessage());
            return FALSE;
        }
        return TRUE;
    }

    public function delete_nb_achat_from_name_email($limit, $name, $emailU) {
        // Cette fonction renvoie TRUE si elle réussi à supprimer un certain nombre d'achats d'un set donné d'un utilisateur donné
        try {
            $req = $this->pdo->prepare("delete from achat where idM in (select idM from minifigs_sets where nom = :name order by idM limite :limit) and emailU = :emailU;");
            $req->bindValue(':name', $name, PDO::PARAM_STR);
            $req->bindValue(':limit', $limit, PDO::PARAM_INT);
            $req->bindvalue(':emailU', $emailU, PDO::PARAM_STR);
            $req->execute();
        }
        catch (PDOException $e) {
            print($e->getMessage());
            return FALSE;
        }
        return TRUE;
    }

    public function add_achat_from_name_email($name, $emailU) {
        // Cette fonction renvoie TRUE si elle réussi à ajouter un achat du set donné par l'utilisateur donné
        try {
            // Ici on va faire deux requêtes (car plus simple en terme de syntaxe) afin de d'abord récupérer l'id de du set pour ensuite l'injecter dans l'insert into
            $req = $this->pdo->prepare("select idM from minifigs_sets where nom = :name;");
            $req->bindValue(':name', $name, PDO::PARAM_STR);
            $req->execute();
            $set = $req->fetch(PDO::FETCH_ASSOC);

            if ($set) {
                // Si la première opération s'est bien déroulée on récupère l'idM du set dans le tableau associatif
                $set_idM = $set['idM'];
                
                $req = $this->pdo->prepare("insert into achat (emailU, idM) values (:emailU, :idM);");
                $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
                $req->bindValue(':idM', $set_idM, PDO::PARAM_INT);
                $req->execute();
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            return FALSE;
        }
        return TRUE;
    }

    public function testAll() {
        // fonction de test qui teste toutes les méthodes de la classe avec un exemple
        if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
            header('Content-type:text/plain');

            echo("All intercessors purchase from email with get_achat_from_name_email() : \n");
            print_r($this->get_achat_from_name_email("escouade d'intercesseurs", "email"));

            echo "Delete all intercessors purchase from email with delete_achat_from_name_email() : \n";
            print_r($this->delete_achat_from_name_email("escouade d'intercesseurs", "email"));

            echo "All purchase from email with get_all_achat_from_email() : \n";
            print_r($this->get_all_achat_from_email("email"));

            echo("Delete every purchase from email delete_all_achat_from_email() : \n");
            print_r($this->delete_all_achat_from_email("email"));

            echo("Delete 2 sets of intercessors from email with delete_nb_achat_from_name_email() : \n");
            print_r($this->delete_nb_achat_from_name_email(2, "escouade d'intercesseurs", "email"));

            echo("Add intercessor purhcase from email with add_achat_from_name_email() : \n");
            print_r($this->add_achat_from_name_email("escouade d'intercesseurs", "email"));
        }
    }
}
?>