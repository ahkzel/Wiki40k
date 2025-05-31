<?php
include_once __DIR__."/../model/utilisateur_model.php";

class Utilisateur_controller {
    private $pdo;

    public function __construct() {
        $this->pdo = new Utilisateur_model();
    }

    public function is_connected() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION["emailU"])) {
            $util = $this->get_user_from_email($_SESSION["emailU"]);
            if ($util["emailU"] == $_SESSION["emailU"] && $util["mdpU"] == $_SESSION["mdpU"]) return TRUE;
        }
        return FALSE;
    }

    public function connexion($emailU, $mdpU) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $user = $this->get_user_from_email($emailU);
        if ($user == FALSE) {
            return FALSE;
        }
        $mdp_user = $user["mdpU"];

        if ($mdp_user == $mdpU) {
            $_SESSION["emailU"] = $emailU;
            $_SESSION["mdpU"] = $mdp_user;
            return TRUE;
        }
        return FALSE;
    }

    public function create_account() {
        $emailU = $_POST["emailU"] ?? NULL;
        $mdpU = $_POST["mdpU"] ?? NULL;
        $pseudo = $_POST["pseudo"] ?? NULL;
        $ville = $_POST["ville"] ?? NULL;
        $codePostal = $_POST["codePostal"] ?? NULL;
        $numeroRue = $_POST["numeroRue"] ?? NULL;
        $nomRue = $_POST["nomRue"] ?? NULL;
        $nameFaction = $_POST["nameFaction"] ?? NULL;
        $namePersonnage = $_POST["namePersonnage"] ?? NULL;

        $new_account = $this->pdo->add_user($emailU, $mdpU, $pseudo, $ville, $codePostal, $numeroRue, $nomRue, $nameFaction, $namePersonnage);
        return $new_account;
    }

    public function get_user_from_email($emailU) {
        $user = $this->pdo->get_user_from_email($emailU);
        return $user;
    }

    public function change_faction($emailU) {
        if (!$this->is_connected()) {
            return FALSE;
        }

        $nameFaction = $_POST["name_faction"] ?? NULL;
        $user_update = $this->pdo->change_faction($emailU, $nameFaction);
        return $user_update;
    }
}

$user_controller = new Utilisateur_controller();

include ""; //vue;
include ""; //vue;
include ""; //vue;
?>