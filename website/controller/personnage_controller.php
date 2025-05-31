<?php
include_once __DIR__."/../model/personnage_model.php";

class Personnage_controller {
    private $pdo;

    public function __construct() {
        $this->pdo = new Personnage_model();
    }

    public function get_all_personnages() {
        $all_characters = $this->pdo->get_personnages();
        return $all_characters;
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
}

$character_controller = new Personnage_controller();

$all_characters = $character_controller->get_all_personnages();

include ""; //vue;
include ""; //vue;
include ""; //vue;
?>