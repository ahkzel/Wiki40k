<?php
include_once __DIR__."/pdo_controller.php";
include_once __DIR__."/../model/planete_model.php";

class Planete_controller {
    private $pdo;
    private $model;
    private $faction_controller;

    public function __construct($pdo_controller, $faction_controller) {
        $this->pdo = $pdo_controller->getPdo();
        $this->model = new Planete_model($this->pdo);
        $this->faction_controller = $faction_controller;
    }

    public function show_planetes_accueil() {
        $planetes = $this->get_all_planetes();

        foreach ($planetes as &$TEMP_planete) {
            if (isset($TEMP_planete["idF"])) {
                $TEMP_idF = $TEMP_planete["idF"];
                $TEMP_faction_parent_planete_name = $this->get_faction_name($TEMP_idF);
                $TEMP_planete["appartenance_name"] = $TEMP_faction_parent_planete_name;
            }
            foreach ($TEMP_planete as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }
        $datas = $planetes ?? [];
        return $datas;
    }

    public function show_planetes($datas) {
        if (isset($datas["parent_faction"])) {
            $TEMP_faction_name = $datas["parent_faction"];
            $planetes = $this->get_planetes_from_faction($TEMP_faction_name);
        }
        else {
            $planetes = $this->get_all_planetes();
        }
        foreach ($planetes as &$TEMP_planete) {
            if (isset($TEMP_planete["idF"])) {
                $TEMP_idF = $TEMP_planete["idF"];
                $faction_parent_planete_name = $this->get_faction_name($TEMP_idF);
            }
            foreach ($TEMP_planete as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }

        include __DIR__."/../vue/planetes.php"; //vue
    }

    public function show_planete_detail($datas) {
        if (isset($datas["planete_name"])) {
            $TEMP_planete_name = $datas["planete_name"];
            $active_planete = $this->this_planete($TEMP_planete_name);

            if (isset($active_planete["idF"])) {
                $TEMP_idF = $active_planete["idF"];
                $faction_parent_planete_name = $this->get_faction_name($TEMP_idF);
            }
            foreach ($active_planete as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }

        include __DIR__."/../vue/planete_detail.php"; //vue
    }

    public function get_all_planetes() {
        $all_planetes = $this->model->get_planetes();
        return $all_planetes;
    }

    public function this_planete($name) {
        $planete = $this->model->get_planete_from_name($name);
        return $planete;
    }

    public function get_planetes_from_faction($name_faction) {
        $planetes = $this->model->get_planete_from_faction($name_faction);
        return $planetes;
    }

    public function get_faction_name($idF) {
        $faction = $this->faction_controller->get_faction_from_id($idF);
        $faction_name = $faction["nom"];
        return $faction_name;
    }

    public function handle_NULL($item) {
        if ($item == NULL) {
            return "N/A";
        }
        return $item;
    }
}
?>