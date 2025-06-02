<?php
include_once __DIR__."/../model/faction_model.php";

class Faction_controller {
    private $pdo;

    public function __construct() {
        $this->pdo = new Faction_model();
    }

    public function show_all_factions() {
        $all_factions = $this->get_all_factions();

        include __DIR__."/../vue/factions.php"; //vue
    }

    public function show_first_factions() {
        $TEMP_all_factions = $this->get_all_factions();
        $TEMP_nb_factions = 8;
        $first_factions = array_slice($TEMP_all_factions, 0, $TEMP_nb_factions, true);

        include __DIR__."/../vue/factions.php"; //vue
    }

    public function show_faction_detail($datas) {
        if (isset($datas["faction_name"])) {
            $TEMP_faction_name = htmlspecialchars($datas["faction_name"]);
            $active_faction = $this->this_faction($TEMP_faction_name);
        }
        include __DIR__."/../vue/faction_detail.php"; //vue
    }

    public function show_add_joueur() {
        $TEMP_all_factions = $this->get_all_factions();
        $faction_names = [];
        foreach ($TEMP_all_factions as $TEMP_faction) {
            $faction_names[] = $TEMP_faction["nom"];
        }

        include __DIR__."/../vue/add-joueur"; //vue
    }

    public function get_all_factions() {
        $tab_factions = $this->pdo->get_factions();
        return $tab_factions;
    }
    
    public function this_faction($name) {
        $faction = $this->pdo->get_faction_from_name($name);
        return $faction;
    }

    public function get_faction_from_id($idF) {
        $faction = $this->pdo->get_faction_from_id($idF);
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
?>