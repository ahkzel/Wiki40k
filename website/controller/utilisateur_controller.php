<?php
include_once __DIR__."/../model/utilisateur_model.php";

class Utilisateur_controller {
    private $pdo;

    public function __construct() {
        $this->pdo = new Utilisateur_model();
    }

    public function show_connexion($forms) {
        if (!isset($forms["emailU"], $forms["mdpU"])) {
            $_SESSION["error_msg"] = "Les champs email et mot de passe sont obligatoires";
            header("Location : index.php?url=connexion");
            exit;
        }
        $TEMP_user = $this->get_user_from_email($forms["emailU"]);
        if (!$TEMP_user) {
            $_SESSION["error_msg"] = "Votre adresse mail ne correspond à aucun compte";
            header("Location : index.php?url=connexion");
            exit;
        }
        elseif ($TEMP_user["mdpU"] != $forms["mdpU"]) {
            $_SESSION["error_msg"] = "Votre mot de passe est incorrect, essayez plutôt : ".$TEMP_user["mdpU"];
            header("Location : index.php?url=connexion");
            exit();
        }
        $connexion = $this->connexion($forms["emailU"], $forms["mdpU"]);
        header("Location : index.php");
    }

    public function show_create_account($forms) {
        if (!isset($forms["emailU"], $forms["mdpU"])) {
            $_SESSION["error_msg"] = "Les champs email et mot de passe sont obligatoires";
            header("Location : index.php?url=create-account");
            exit;
        }
        $TEMP_emailU = $forms["emailU"];
        $TEMP_mdpU = $forms["mdpU"];
        $TEMP_pseudo = $forms["pseudo"] ?? NULL;
        $TEMP_ville = $forms["ville"] ?? NULL;
        $TEMP_codePostal = $forms["codePostal"] ?? NULL;
        $TEMP_numeroRue = $forms["numeroRue"] ?? NULL;
        $TEMP_nomRue = $forms["nomRue"] ?? NULL;
        $TEMP_nameFaction = $forms["faction_name"] ?? NULL;
        $TEMP_namePersonnage = $forms["personnage_name"] ?? NULL;

        $new_account = $this->create_account($TEMP_emailU, $TEMP_mdpU, $TEMP_pseudo, $TEMP_ville, $TEMP_codePostal, $TEMP_numeroRue, $TEMP_nomRue, $TEMP_nameFaction, $TEMP_namePersonnage);
        $TEMP_connexion = $this->connexion($TEMP_emailU, $TEMP_mdpU);
        header("Location : index.php");
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
        if (!$user || $mdpU !== $user["mdpU"]) {
            return FALSE;
        }

        $TEMP_keys = ["emailU", "mdpU", "pseudo", "ville", "codePostal", "numeroRue", "nomRue"];
        $_SESSION = array_intersect_key($user, array_flip($TEMP_keys));
        return TRUE;
    }

    public function create_account($emailU, $mdpU, $pseudo, $ville, $codePostal, $numeroRue, $nomRue, $nameFaction, $namePersonnage) {
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
?>