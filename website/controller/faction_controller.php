<?php
include_once __DIR__."/../model/faction_model.php";

class Faction_controller {
    private $pdo;

    public function __construct() {
        $this->pdo = new Faction_model();
    }

    public function get_all_factions() {
        $tab_factions = $this->pdo->get_factions();
        return $tab_factions;
    }
    
    public function this_faction($name) {
        $faction = $this->pdo->get_faction_from_name($name);
        return $faction;
    }

    public function get_factions_belonging_to($appartenance) {
        $faction = $this->pdo->get_faction_from_appartenance($appartenance);
        return $faction;
    }

    public function get_factions_with_no_appartenance() {
        $all_factions = $this->pdo->get_factions();
        $root_factions = array();
        foreach ($all_factions as $faction) {
            if ($faction["appartenance"] == NULL) {
                $faction_name = $faction["nom"];
                $root_factions[$faction_name] = $faction;
            }
        }
        return $root_factions;
    }
}

$faction_controller = new Faction_controller();

$main_factions = array();
$main_factions = $controller->get_factions_with_no_appartenance();

$all_factions = $controller->get_all_factions();

include ""; //vue;
include ""; //vue;
include ""; //vue;
?>