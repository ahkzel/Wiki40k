<?php
// on inclue tous les controlleurs
include_once "controller/pdo_controller.php";
include_once "controller/faction_controller.php";
include_once "controller/achat_controller.php";
include_once "controller/joueur_controller.php";
include_once "controller/minifigs_sets_controller.php";
include_once "controller/personnage_controller.php";
include_once "controller/planete_controller.php";
include_once "controller/utilisateur_controller.php";

// on démarre la session vide
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// on récupère le path des url de la vue en ne gardant que ce qu'il y a après la partie "index.php?url="
$request = str_replace('/index.php', '', $_SERVER['REQUEST_URI']); 
$queryString = parse_url($request, PHP_URL_QUERY) ?? '';
parse_str($queryString, $queryParams);
$url = trim($queryParams["url"] ?? "", '/');

// on récupère les données GET et POST
$datas = $_GET ?? NULL;
$forms = $_POST ?? NULL;

// on instancie tous les controleurs, une seule fois
$PDOC = new Pdo_controller();
$factionC = new Faction_controller($PDOC);
$characterC = new Personnage_controller($PDOC, $factionC);
$planeteC = new Planete_controller($PDOC, $factionC);
$userC = new Utilisateur_controller($PDOC);
$setsC = new Minifigs_controller($PDOC);
$joueurC = new Joueur_controller($PDOC, $factionC);
$achatC = new Achat_controller($PDOC);

// selon l'url on va rediriger vers une méthode d'un controleur qui va nous permettre d'afficher la page
switch (TRUE) {
    case ($url === "") :
        $first_factions = $factionC->show_first_factions();
        $personnages = $characterC->show_personnages_accueil();
        $planetes = $planeteC->show_planetes_accueil();
        include __DIR__."/vue/accueil.php"; //vue;
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
        $userC->show_create_account();
        break;
    case ($url === "submit-create-account") :
        $userC->submit_create_account($forms);
        break;
    case ($url === "connexion") :
        $userC->show_connexion();
        break;
    case ($url === "submit-connexion") :
        $userC->submit_connexion($forms);
        break;
    case ($url === "deconnexion") :
        $userC->show_deconnexion();
        break;

    case ($url === "shop") :
        $available_sets = $setsC->show_sets_above_0();
        if (!isset($_SESSION["sets_to_cart"])) {
            $_SESSION["sets_to_cart"] = [];
        }
        $sets_to_cart = $_SESSION["sets_to_cart"];
        include __DIR__."/vue/shop.php"; //vue
        break;

    case ($url === "add-set") :
        $available_sets = $setsC->show_sets_above_0();
        $set_to_add = $setsC->add_to_basket($forms);
        if ($set_to_add) {
            $exists = false;
            foreach ($_SESSION["sets_to_cart"] as $set) {
                if ($set["nom"] === $set_to_add["nom"]) {
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $_SESSION["sets_to_cart"][] = $set_to_add;
            }
        }
        $sets_to_cart = $_SESSION["sets_to_cart"];
        include __DIR__."/vue/shop.php"; //vue
        break;

    case ($url === "buy-shop") :
        $available_sets = $setsC->show_sets_above_0();
        $buy_everything = $achatC->buy_everything($forms);
        if ($buy_everything == TRUE) {
            $_SESSION["sets_to_cart"] = [];
        }
        include __DIR__."/vue/shop.php"; //vue
        break;

    case ($url === "add-joueur") :
        $faction_names = $factionC->show_add_joueur();
        $factions_played = $joueurC->show_add_joueur();
        include __DIR__."/vue/add_joueur.php"; //vue
        break;
    case ($url === "submit-add-joueur") :
        $joueurC->submit_add_joueur($forms);
        break;
    default :
        header("Location : /");
        exit;
};
?>