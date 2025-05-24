<?php
// inclue le controller pdo dans le model
include_once(__DIR__."/controller/pdo_controller.php");

// on créé une classe dont on se servira pour appeler ses méthodes
class Utilisateur_model {
    private $pdo;

    public function __construct() {
        // dans le construct, prend la variable pdo du controlleur pdo pour créer la connexion
        if (isset($_GET["con"])) $this->pdo = $_GET["con"];
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
}
?>