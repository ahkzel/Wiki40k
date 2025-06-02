<?php
include_once __DIR__."/../model/personnage_model.php";

class Personnage_controller {
    private $pdo;
    private $faction_controller;

    public function __construct($faction_controller) {
        $this->pdo = new Personnage_model();
        $this->faction_controller = $faction_controller;
    }

    public function show_personnages($datas) {
        if ($datas["parent_faction"]) {
            $TEMP_faction_name = htmlspecialchars($datas["parent_faction"]);
            $personnages = $this->get_personnages_from_faction($TEMP_faction_name);
        }
        else {
            $personnages = $this->get_all_personnages();
        }
        include __DIR__."/../vue/personnages.php"; //vue
    }

    public function show_personnage_detail($datas) {
        if (isset($datas["personnage_name"])) {
            $TEMP_personnage_name = htmlspecialchars($datas["personnage_name"]);
            $active_character = $this->this_personnage($TEMP_personnage_name);

            if (isset($active_character["idF"])) {
                $TEMP_idF = $active_character["idF"];
                $faction_parent_personnage_name = $this->get_faction_name($TEMP_idF);
            }
        }
        
        include __DIR__."/../vue/personnage_detail.php"; //vue
    }

    public function get_all_personnages() {
        $all_characters = $this->pdo->get_personnages();
        return $all_characters;
    }

    public function this_personnage($name) {
        $character = $this->pdo->get_personnage_from_name($name);
        return $character;
    }

    public function get_personnages_from_faction($name_faction) {
        $characters = $this->pdo->get_personnage_from_faction($name_faction);
        return $characters;
    }

    public function get_personnages_from_sous_faction($name_s_faction) {
        $characters = $this->pdo->get_personnage_from_sous_faction($name_s_faction);
        return $characters;
    }

    public function get_personnages_from_classe($classe) {
        $characters = $this->pdo->get_personnage_from_classe($classe);
        return $characters;
    }

    public function get_faction_name($idF) {
        $faction = $this->faction_controller->get_faction_from_id($idF);
        $faction_name = $faction["nom"];
        return $faction_name;
    }
}
?>