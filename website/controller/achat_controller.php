<?php
include_once __DIR__."controller/utilisateur_controller.php";
include_once __DIR__."/../model/achat_model.php";

class Achat_controller {
    private $pdo;
    private $user_controller;

    public function __construct($user_controller) {
        $this->pdo = new Achat_model();
        $this->user_controller = $user_controller;
    }

    public function count_achats($liste) {
        return count($liste);
    }

    public function get_all_achat_from_emailU() {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];

        $achats = $this->pdo->get_all_achat_from_email($emailU);
        return $achats;
    }

    public function get_achat_from_name_emailU($name_set) {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];

        $achats = $this->pdo->get_achat_from_name_email($name_set, $emailU);
        return $achats;
    }

    public function delete_all_achat_from_emailU() {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];

        $deletes = $this->pdo->delete_all_achat_from_email($emailU);
        return $deletes;
    }

    public function delete_achat_from_name_emailU($name_set) {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];

        $deletes = $this->pdo->delete_achat_from_name_email($name_set, $emailU);
        return $deletes;
    }

    public function delete_nb_achat_from_name_emailU($limit, $name_set) {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];

        $deletes = $this->pdo->delete_nb_achat_from_name_email($limit, $name_set, $emailU);
        return $deletes;
    }

    public function add_achat_from_name_emailU($name_set) {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];

        $achat = $this->pdo->add_achat_from_name_email($name_set, $emailU);
        return $achat;
    }
}

$user_controller = new Utilisateur_controller();
$achat_controller = new Achat_controller($user_controller);

include ""; //vue;
include ""; //vue;
include ""; //vue;
?>