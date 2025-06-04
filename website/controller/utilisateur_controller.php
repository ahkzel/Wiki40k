<?php
include_once __DIR__."/pdo_controller.php";
include_once __DIR__."/../model/utilisateur_model.php";

class Utilisateur_controller {
    private $pdo;
    private $model;

    public function __construct($pdo_controller) {
        $this->pdo = $pdo_controller->getPdo();
        $this->model = new Utilisateur_model($this->pdo);
    }

    public function show_deconnexion() {
        $this->deconnexion();
        header("Location: /");
        exit();
    }

    public function show_connexion() {
        include __DIR__."/../vue/connexion.php";
    }

    public function submit_connexion($forms) {
        if (!isset($forms["emailU"], $forms["mdpU"])) {
            $_SESSION["error_msg"] = "Les champs email et mot de passe sont obligatoires";
            header("Location: index.php?url=connexion");
            exit();
        }
        $TEMP_user = $this->get_user_from_email($forms["emailU"]);

        if (!$TEMP_user) {
            $_SESSION["error_msg"] = "Votre adresse mail ne correspond à aucun compte";
            header("Location: index.php?url=connexion");
            exit();
        }
        elseif (!password_verify($forms["mdpU"], $TEMP_user["mdpU"])) {
            $_SESSION["error_msg"] = "Votre mot de passe est incorrect, essayez plutôt : ".$TEMP_user["mdpU"];
            header("Location: index.php?url=connexion");
            exit();
        }
        $this->connexion($forms["emailU"], $forms["mdpU"]);
        header("Location: index.php");
        exit();
    }

    public function show_create_account() {
        include __DIR__."/../vue/create_account.php";
    }

    public function submit_create_account($forms) {
        if (!isset($forms["emailU"], $forms["mdpU"])) {
            $_SESSION["error_msg"] = "Les champs email et mot de passe sont obligatoires";
            header("Location: index.php?url=create-account");
            exit();
        }

        if (!filter_var($forms["emailU"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error_msg"] = "Email invalide";
            header("Location: index.php?url=create-account");
            exit();
        }
        if (strlen($forms["mdpU"]) > 30) {
            $_SESSION["error_msg"] = "Le mot de passe doit faire moins de 30 caractères";
            header("Location: index.php?url=create-account");
            exit();
        }
        if ($forms["codePostal"] == "" || !ctype_digit($forms["codePostal"])) {
            $TEMP_codePostal = NULL;
        }
        if ($forms["numeroRue"] == "" || !ctype_digit($forms["numeroRue"])) {
            $TEMP_numeroRue = NULL;
        }

        $TEMP_emailU = $forms["emailU"];
        $TEMP_mdpU = $forms["mdpU"];
        $TEMP_pseudo = $forms["pseudo"] ?? NULL;
        $TEMP_ville = $forms["ville"] ?? NULL;
        $TEMP_codePostal = intval($forms["codePostal"]) ?? NULL;
        $TEMP_numeroRue = intval($forms["numeroRue"]) ?? NULL;
        $TEMP_nomRue = $forms["nomRue"] ?? NULL;
        $TEMP_nameFaction = $forms["faction_name"] ?? NULL;
        $TEMP_namePersonnage = $forms["personnage_name"] ?? NULL;

        $this->create_account($TEMP_emailU, $TEMP_mdpU, $TEMP_pseudo, $TEMP_ville, $TEMP_codePostal, $TEMP_numeroRue, $TEMP_nomRue, $TEMP_nameFaction, $TEMP_namePersonnage);
        $this->connexion($TEMP_emailU, $TEMP_mdpU);
        header("Location: index.php");
        exit();
    }

    public function is_connected() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION["emailU"])) {
            $util = $this->get_user_from_email($_SESSION["emailU"]);
            if ($util["emailU"] == $_SESSION["emailU"] && $util["mdpU"] == $_SESSION["mdpU"]) return TRUE;
        }
        return FALSE;
    }

    public function connexion($emailU, $mdpU) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = $this->get_user_from_email($emailU);
        var_dump($user);
        var_dump($_SESSION);
        if (!$user || !password_verify($mdpU, $user["mdpU"])) {
            return FALSE;
        }

        $TEMP_keys = ["emailU", "mdpU", "pseudo", "ville", "codePostal", "numeroRue", "nomRue"];
        $_SESSION = array_intersect_key($user, array_flip($TEMP_keys));
        return TRUE;
    }

    public function deconnexion() {
        if (!isset($_SESSION)) {
            session_start();
        }

        session_unset();
        session_destroy();
    }

    public function create_account($emailU, $mdpU, $pseudo, $ville, $codePostal, $numeroRue, $nomRue, $nameFaction, $namePersonnage) {
        $hashed_mdp = password_hash($mdpU, PASSWORD_DEFAULT);
        $new_account = $this->model->add_user($emailU, $hashed_mdp, $pseudo, $ville, $codePostal, $numeroRue, $nomRue, $nameFaction, $namePersonnage);
        return $new_account;
    }

    public function get_user_from_email($emailU) {
        $user = $this->model->get_user_from_email($emailU);
        return $user;
    }

    public function change_faction($emailU) {
        if (!$this->is_connected()) {
            return FALSE;
        }

        $nameFaction = $_POST["name_faction"] ?? NULL;
        $user_update = $this->model->change_faction($emailU, $nameFaction);
        return $user_update;
    }
}
?>