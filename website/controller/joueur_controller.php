<?php
include_once __DIR__."/pdo_controller.php";
include_once __DIR__."/utilisateur_controller.php";
include_once __DIR__."/../model/joueur_model.php";

class Joueur_controller {
    private $pdo;
    private $model;
    private $faction_controller;

    public function __construct($pdo_controller, $faction_controller) {
        $this->pdo = $pdo_controller->getPdo();
        $this->model = new Joueur_model($this->pdo);
        $this->faction_controller = $faction_controller;
    }

    public function submit_add_joueur($forms) {
        if (isset($forms["faction_joueur"])) {
            if ($forms["points"] == "" || !ctype_digit($forms["points"])) $TEMP_pts =  0;
            $TEMP_pts = $forms["points"] ?? 0;
            $TEMP_pseudo = $_SESSION["pseudo"] ?? NULL;
            $this->add_player($_SESSION["emailU"], $forms["faction_joueur"], $TEMP_pseudo, $TEMP_pts);
        }

        header("Location: index.php");
        exit();
    }

    public function show_add_joueur() {
        $factions_played = [];
        $TEMP_comptes_joueur = $this->get_players_by_emailU($_SESSION["emailU"]);
        if ($TEMP_comptes_joueur) {
            foreach ($TEMP_comptes_joueur as $TEMP_joueur) {
                $factions_played[] = $this->get_faction_name($TEMP_joueur["idF"]);
            }
        }

        return $factions_played;
    }

    public function get_players_by_emailU($emailU) {
        $players = $this->model->get_players_by_emailU($emailU);
        return $players;
    }

    public function get_player_by_emailU_faction($emailU, $name_faction) {
        $player = $this->model->get_player_by_emailU_faction($emailU, $name_faction);
        return $player;
    }

    public function add_player($emailU, $name_faction, $pseudo, $pts) {
        $player = $this->model->add_player($emailU, $name_faction, $pseudo, $pts);
        return $player;
    }

    public function delete_player($emailU, $name_faction) {
        $player = $this->model->delete_player($emailU, $name_faction);
        return $player;
    }

    public function update_player_in_points($emailU, $name_faction, $pts) {
        $player = $this->model->update_player_in_points($emailU, $name_faction, $pts);
        return $player;
    }

    public function get_faction_name($idF) {
        $faction = $this->faction_controller->get_faction_from_id($idF);
        $faction_name = $faction["nom"];
        return $faction_name;
    }
}
?>