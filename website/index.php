<?php
include_once "controller/pdo_controller.php";
include_once "controller/faction_controller.php";
include_once "controller/achat_controller.php";
include_once "controller/joueur_controller.php";
include_once "controller/minifigs_sets_controller.php";
include_once "controller/personnage_controller.php";
include_once "controller/planete_controller.php";
include_once "controller/utilisateur_controller.php";

// on récupère le path des url de la vue en ne gardant que ce qu'il y a après la partie "index.php?url="
$request = str_replace('/index.php', '', $_SERVER['REQUEST_URI']); 
$queryString = parse_url($request, PHP_URL_QUERY) ?? '';
parse_str($queryString, $queryParams);
$url = trim($queryParams["url"] ?? "", '/');

$datas = $_GET ?? NULL;
$forms = $_POST ?? NULL;

$PDOC = new Pdo_controller();
$factionC = new Faction_controller($PDOC);
$characterC = new Personnage_controller($PDOC, $factionC);
$planeteC = new Planete_controller($PDOC, $factionC);
$userC = new Utilisateur_controller($PDOC);
$setsC = new Minifigs_controller($PDOC);
$joueurC = new Joueur_controller($PDOC, $factionC);
$achatC = new Achat_controller($PDOC);

switch (TRUE) {
    case ($url === "") :
        $first_factions = $factionC->show_first_factions();
        $personnages = $characterC->show_personnages_accueil();
        $planetes = $planeteC->show_planetes_accueil();
        include __DIR__."/vue/accueil.php";
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
    case ($url === "faction-detail") :
        $factionC->show_faction_detail($datas);
        break;
    case ($url === "personnage-detail") :
        $characterC->show_personnage_detail($datas);
        break;
    case ($url === "planete-detail") :
        $planeteC->show_planete_detail($datas);
        break;
    case ($url === "create-account") :
        $userC->show_create_account($forms);
        break;
    case ($url === "connexion") :
        $userC->show_connexion($forms);
        break;
    case ($url === "shop") :
        $setsC->show_sets_above_0($datas);
        break;
    case ($url === "add-set") :
        $setsC->add_to_basket($forms);
        break;
    case ($url === "buy-shop") :
        $achatC->buy_everything($forms);
        break;
    case ($url === "add-joueur") :
        $factionC->show_add_joueur();
        $joueurC->show_add_joueur($forms);
        break;
    default :
        header("Location : /");
        exit;
};
?>