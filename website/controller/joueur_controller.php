<?php
include_once __DIR__."/utilisateur_controller.php";
include_once __DIR__."/../model/joueur_model.php";

class Joueur_controller {
    private $pdo;
    private $user_controller;

    public function __construct($user_controller) {
        $this->pdo = new Joueur_model();
        $this->user_controller = $user_controller;
    }

    public function get_players_by_emailU() {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];

        $players = $this->pdo->get_players_by_emailU($emailU);
        return $players;
    }

    public function get_player_by_emailU_faction($name_faction) {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];
        
        $player = $this->pdo->get_player_by_emailU_faction($emailU, $name_faction);
        return $player;
    }

    public function add_player($name_faction, $pseudo, $pts) {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];

        $player = $this->pdo->add_player($emailU, $name_faction, $pseudo, $pts);
        return $player;
    }

    public function delete_player($name_faction) {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];
        
        $player = $this->pdo->delete_player($emailU, $name_faction);
        return $player;
    }

    public function update_player_in_points($name_faction, $pts) {
        if ($this->user_controller->is_connected() == FALSE) return NULL;
        $emailU = $_SESSION["emailU"];
        
        $player = $this->pdo->update_player_in_points($emailU, $name_faction, $pts);
        return $player;
    }
}

$user_controller = new Utilisateur_controller();
$player_controller = new Joueur_controller($user_controller);

include ""; //vue;
include ""; //vue;
include ""; //vue;
?>