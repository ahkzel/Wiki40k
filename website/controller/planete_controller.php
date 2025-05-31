<?php
include_once __DIR__."/../model/planete_model.php";

class Planete_controller {
    private $pdo;

    public function __construct() {
        $this->pdo = new Planete_model();
    }

    public function get_all_planetes() {
        $all_planetes = $this->pdo->get_planetes();
        return $all_planetes;
    }

    public function get_planetes_from_faction($name_faction) {
        $planetes = $this->pdo->get_planete_from_faction($name_faction);
        return $planetes;
    }
}

$planete_controller = new Planete_controller();

$all_planetes = $planete_controller->get_all_planetes();

include ""; //vue;
include ""; //vue;
include ""; //vue;
?>