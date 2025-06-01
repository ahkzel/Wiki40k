<?php
include_once __DIR__."controller/utilisateur_controller.php";
include_once __DIR__."controller/faction_controller.php";
include_once __DIR__."controller/personnage_controller.php";
include_once __DIR__."controller/planete_controller.php";
include_once __DIR__."controller/minifigs_sets_controller.php";
include_once __DIR__."controller/joueur_controller.php";
include_once __DIR__."controller/achat_controller.php";

class Controller_principal {
    private $factionController;
    private $userController;
    private $characterController;
    private $planeteController;
    private $setController;
    private $playerController;
    private $achatController;

    public function __construct() {
        $this->factionController = new Faction_controller();
        $this->userController = new Utilisateur_controller();
        $this->characterController = new Personnage_controller();
        $this->planeteController = new Planete_controller();
        $this->setController = new Minifigs_controller();
        $this->playerController = new Joueur_controller($this->userController);
        $this->achatController = new Achat_controller($this->userController);
    }

    public function get_factionC() {
        return $this->factionController;
    }
    public function get_userC() {
        return $this->userController;
    }
    public function get_characterC() {
        return $this->characterController;
    }
    public function get_planeteC() {
        return $this->planeteController;
    }
    public function get_setC() {
        return $this->setController;
    }
    public function get_playerC() {
        return $this->playerController;
    }
    public function get_achatC() {
        return $this->achatController;
    }
}

$main_controller = new Controller_principal();

$main_factions = $main_controller->get_factionC()->get_factions_with_no_appartenance();
$all_factions = $main_controller->get_factionC()->get_all_factions();

if (isset($_GET["faction_name"])) {
    $faction_name = htmlspecialchars($_GET["faction_name"]);
    $active_faction = $main_controller->get_factionC()->this_faction($faction_name);
}

include ""; //vue;
include ""; //vue;
include ""; //vue;
?>