<?php
include_once __DIR__."/pdo_controller.php";
include_once __DIR__."/../model/faction_model.php";

class Faction_controller {
    private $pdo;
    private $model;

    public function __construct($pdo_controller) {
        $this->pdo = $pdo_controller->getPdo();
        $this->model = new Faction_model($this->pdo);
    }

    public function show_all_factions() {
        $all_factions = $this->get_all_factions();

        foreach ($all_factions as &$TEMP_faction) {
            foreach ($TEMP_faction as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }
        include __DIR__."/../vue/factions.php"; //vue
    }

    public function show_first_factions() {
        $TEMP_all_factions = $this->get_all_factions();
        $TEMP_nb_factions = 8;
        $first_factions = array_slice($TEMP_all_factions, 0, $TEMP_nb_factions, true);

        foreach ($first_factions as &$TEMP_faction) {
            foreach ($TEMP_faction as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }
        $datas = $first_factions ?? [];
        return $datas;
    }

    public function show_faction_detail($datas) {
        if (isset($datas["faction_name"])) {
            $TEMP_faction_name = $datas["faction_name"];
            $active_faction = $this->this_faction($TEMP_faction_name);

            foreach ($active_faction as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }

        include __DIR__."/../vue/faction_detail.php"; //vue
    }

    public function show_add_joueur() {
        $TEMP_all_factions = $this->get_all_factions();
        $faction_names = [];
        foreach ($TEMP_all_factions as $TEMP_faction) {
            $faction_names[] = $TEMP_faction["nom"];
        }

        return $faction_names;
    }

    public function get_all_factions() {
        $tab_factions = $this->model->get_factions();
        return $tab_factions;
    }
    
    public function this_faction($name) {
        $faction = $this->model->get_faction_from_name($name);
        return $faction;
    }

    public function get_faction_from_id($idF) {
        $faction = $this->model->get_faction_from_id($idF);
        return $faction;
    }

    public function get_factions_belonging_to($appartenance) {
        $faction = $this->model->get_faction_from_appartenance($appartenance);
        return $faction;
    }

    public function get_factions_with_no_appartenance() {
        $all_factions = $this->model->get_factions();
        $root_factions = array();
        foreach ($all_factions as $faction) {
            if ($faction["appartenance"] == NULL) {
                $faction_name = $faction["nom"];
                $root_factions[$faction_name] = $faction;
            }
        }
        return $root_factions;
    }

    public function handle_NULL($item) {
        if ($item == NULL) {
            return "N/A";
        }
        return $item;
    }
}
?>