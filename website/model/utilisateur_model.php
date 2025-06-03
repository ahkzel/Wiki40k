<?php
// on créé une classe dont on se servira pour appeler ses méthodes
class Utilisateur_model {
    private $pdo;

    public function __construct($pdo) {
        // dans le construct, prend la variable pdo du controlleur pdo pour créer la connexion
        if (isset($pdo)) $this->pdo = $pdo;
    }

    public function get_user_from_email($emailU) {
        // cette fonction renvoie un utilisateur singulier dont l'email est donnée
        try {
            $req = $this->pdo->prepare("select * from utilisateur where emailU = :emailU;");
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->execute();

            $result = $req->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function add_user($emailU, $mdpU, $pseudo, $ville, $codePostal, $numeroRue, $nomRue, $name_faction = NULL, $name_personnage = NULL) {
        try {
            if ($name_faction) {
                try {
                    $req = $this->pdo->prepare("select idF from faction where nom = :name_faction;");
                    $req->bindValue(':name_faction', $name_faction, PDO::PARAM_STR);
                    $req->execute();

                    $idF_ = $req->fetch(PDO::FETCH_ASSOC);
                }
                catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
            if ($name_personnage) {
                try {
                    $req = $this->pdo->prepare("select idPers from personnage where nom = :name_personnage;");
                    $req->bindValue(':name_personnage', $name_personnage, PDO::PARAM_STR);
                    $req->execute();

                    $idPers_ = $req->fetch(PDO::FETCH_ASSOC);
                }
                catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
            if ($idF_ and $idPers_) {
                $idF = $idF_["idF"];
                $idPers = $idPers_["idPers"];

                $req = $this->pdo->prepare("insert into utilisateur (emailU, mdpU, pseudo, ville, codePostal, numeroRue, nomRue, idF, idPers) values (:emailU, :mdpU, :pseudo, :ville, :codePostal, :numeroRue, :nomRue, :idF, :idPers);");
                $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
                $req->bindValue(':mdpU', $mdpU, PDO::PARAM_STR);
                $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                $req->bindValue(':ville', $ville, PDO::PARAM_STR);
                $req->bindValue(':codePostal', $codePostal, PDO::PARAM_INT);
                $req->bindValue(':numeroRue', $numeroRue, PDO::PARAM_INT);
                $req->bindValue(':nomRue', $nomRue, PDO::PARAM_STR);
                $req->bindValue(':idF', $idF, PDO::PARAM_INT);
                $req->bindValue(':idPers', $idPers, PDO::PARAM_INT);
                $req->execute();
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
        return TRUE;
    }

    public function change_faction($emailU, $name_faction) {
        try {
            $req = $this->pdo->prepare("update utilisateur join faction on faction.idF = utilisateur.idF set utilisateur.idF = :idF where faction.nom = :name_faction and utilisateur.emailU = :emailU;");
            $req->bindValue(':name_faction', $name_faction, PDO::PARAM_STR);
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->execute();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
        return TRUE;
    }

    public function testAll() {
        // fonction de test qui teste toutes les méthodes de la classe avec un exemple
        if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
            header('Content-type:text/plain');
        
            echo("emailU with get_user_from_email() : \n");
            print_r($this->get_user_from_email("emailU"));

            echo "Add user emailU with add_user() : \n";
            print_r($this->add_user("emailU", "mdpU", "melo", "montcuq", 40410, 13, "rue du caca", "Aeldari"));
        }
    }
}
?>