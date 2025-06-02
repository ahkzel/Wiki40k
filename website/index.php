<?php
include_once "controller/faction_controller.php";
include_once "controller/achat_controller.php";
include_once "controller/joueur_controller.php";
include_once "controller/minifigs_sets_controller.php";
include_once "controller/personnage_controller.php";
include_once "controller/planete_controller.php";
include_once "controller/utilisateur_controller.php";

$url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$datas = $_GET ?? NULL;
$forms = $_POST ?? NULL;

$factionC = new Faction_controller();
$characterC = new Personnage_controller($factionC);
$planeteC = new Planete_controller($factionC);
$userC = new Utilisateur_controller();
$setsC = new Minifigs_controller($factionC);
$joueurC = new Joueur_controller($userC);
$achatC = new Achat_controller($userC);

switch (TRUE) {
    case ($url === "") :
        include "vue/accueil.php"; // vue
        break;
    case ($url === "factions") :
        $factionC->show_all_factions();
        break;
    case ($url === "personnages") :
        $characterC->show_personnages($datas);
        break;
    case ($url === "planetes") :
        $planeteC->show_planetes($datas);
        break;
    case ($url === "faction_detail") :
        $factionC->show_faction_detail($datas);
        break;
    case ($url === "personnage_detail") :
        $characterC->show_personnage_detail($datas);
        break;
    case ($url === "planete-detail") :
        $planeteC->show_planete_detail($datas);
        break;
    case ($url === "create-account") :
        include "vue/create_account.php"; // vue
        break;
    case ($url === "connexion") :
        include "vue/connexion.php"; // vue
        break;
    case ($url === "shop") :
        $setsC->show_sets_above_0($datas);
        break;
    default :
        header("Location : /");
        exit;
};
?>