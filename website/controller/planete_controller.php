<?php
include_once __DIR__."/../model/planete_model.php";

class Planete_controller {
    private $pdo;
    private $faction_controller;

    public function __construct($faction_controller) {
        $this->pdo = new Planete_model();
        $this->faction_controller = $faction_controller;
    }

    public function show_planetes($datas) {
        if ($datas["parent_faction"]) {
            $TEMP_faction_name = htmlspecialchars($datas["parent_faction"]);
            $planetes = $this->get_planetes_from_faction($TEMP_faction_name);
        }
        else {
            $planetes = $this->get_all_planetes();
        }
        include __DIR__."/../vue/planetes.php"; //vue
    }

    public function show_planete_detail($datas) {
        if (isset($datas["planete_name"])) {
            $TEMP_planete_name = htmlspecialchars($datas["planete_name"]);
            $active_planete = $this->this_planete($TEMP_planete_name);

            if (isset($active_planete["idF"])) {
                $TEMP_idF = $active_planete["idF"];
                $faction_parent_planete_name = $this->get_faction_name($TEMP_idF);
            }
        }

        include __DIR__."/../vue/planete_detail.php"; //vue
    }

    public function get_all_planetes() {
        $all_planetes = $this->pdo->get_planetes();
        return $all_planetes;
    }

    public function this_planete($name) {
        $planete = $this->pdo->get_planete_from_name($name);
        return $planete;
    }

    public function get_planetes_from_faction($name_faction) {
        $planetes = $this->pdo->get_planete_from_faction($name_faction);
        return $planetes;
    }

    public function get_faction_name($idF) {
        $faction = $this->faction_controller->get_faction_from_id($idF);
        $faction_name = $faction["nom"];
        return $faction_name;
    }
}
?>