<?php
include_once __DIR__."/pdo_controller.php";
include_once __DIR__."/../model/personnages_model.php";

class Personnage_controller {
    private $pdo;
    private $model;
    private $faction_controller;

    public function __construct($pdo_controller, $faction_controller) {
        $this->pdo = $pdo_controller->getPdo();
        $this->model = new Personnage_model($this->pdo);
        $this->faction_controller = $faction_controller;
    }

    public function show_personnages_accueil() {
        $personnages = $this->get_all_personnages();

        foreach ($personnages as &$TEMP_personnage) {
            if (isset($TEMP_personnage["idF"])) {
                $TEMP_idF = $TEMP_personnage["idF"];
                $TEMP_faction_parent_personnage_name = $this->get_faction_name($TEMP_idF);
                $TEMP_personnage["appartenance_name"] = $TEMP_faction_parent_personnage_name;
            }
            foreach ($TEMP_personnage as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }
        $datas = $personnages ?? [];
        return $datas;
    }

    public function show_personnages($datas) {
        if (isset($datas["parent_faction"])) {
            $TEMP_faction_name = $datas["parent_faction"];
            $personnages = $this->get_personnages_from_faction($TEMP_faction_name);
        }
        else {
            $personnages = $this->get_all_personnages();
        }
        foreach ($personnages as &$TEMP_personnage) {
            if (isset($TEMP_personnage["idF"])) {
                $TEMP_idF = $TEMP_personnage["idF"];
                $faction_parent_personnage_name = $this->get_faction_name($TEMP_idF);
            }
            foreach ($TEMP_personnage as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }

        include __DIR__."/../vue/personnages.php"; //vue
    }

    public function show_personnage_detail($datas) {
        if (isset($datas["personnage_name"])) {
            $TEMP_personnage_name = $datas["personnage_name"];
            $active_character = $this->this_personnage($TEMP_personnage_name);

            if (isset($active_character["idF"])) {
                $TEMP_idF = $active_character["idF"];
                $faction_parent_personnage_name = $this->get_faction_name($TEMP_idF);
            }
            foreach ($active_character as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }
        
        include __DIR__."/../vue/personnage_detail.php"; //vue
    }

    public function get_all_personnages() {
        $all_characters = $this->model->get_personnages();
        return $all_characters;
    }

    public function this_personnage($name) {
        $character = $this->model->get_personnage_from_name($name);
        return $character;
    }

    public function get_personnages_from_faction($name_faction) {
        $characters = $this->model->get_personnage_from_faction($name_faction);
        return $characters;
    }

    public function get_personnages_from_sous_faction($name_s_faction) {
        $characters = $this->model->get_personnage_from_sous_faction($name_s_faction);
        return $characters;
    }

    public function get_personnages_from_classe($classe) {
        $characters = $this->model->get_personnage_from_classe($classe);
        return $characters;
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