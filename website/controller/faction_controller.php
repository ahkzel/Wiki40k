<?php
include_once(__DIR__."/model/faction_model.php");

class Faction_controller {
    private $controller;

    public function __construct() {
        $this->controller = new Faction_model();
    }

    public function get_all_factions() {
        $tab_factions = $this->controller->get_factions();
        return $tab_factions;
    }
    
    public function this_faction($name) {
        $faction = $this->controller->get_faction_from_name($name);
        return $faction;
    }

    public function get_faction_name($name) {
        $faction = $this->controller->get_faction_from_name($name);
        $faction_name = $faction["nom"];
        return $faction_name;
    }
}

  
?>