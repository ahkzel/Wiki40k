<?php
include_once __DIR__."/../model/minifigs_model.php";

class Minifigs_controller {
    private $pdo;

    public function __construct() {
        $this->pdo = new Minifigs_model();
    }

    public function show_sets_above_0($datas) {
        if (isset($datas["parent_faction"])) {
            $TEMP_faction_name = htmlspecialchars($datas["parent_faction"]);
            $available_sets = $this->get_sets_from_faction($TEMP_faction_name);
        }
        $available_sets = $this->get_sets_stock_above_0();

        include __DIR__."/../vue/shop.php"; //vue
    }

    public function add_to_basket($forms) {
        if (isset($forms["name_set"])) {
            $TEMP_set_name = htmlspecialchars($forms["name_set"]);
            $active_set = $this->get_set_from_name($TEMP_set_name);
            
            if (isset($_SESSION["emailU"])) {
                if (!isset($_SESSION["basket"])) {
                    $_SESSION["basket"] = [];
                }
                if (!in_array($active_set, $_SESSION["basket"])) {
                    $_SESSION["basket"][$TEMP_set_name] = $active_set;
                }
            }
            else {
                $error_msg = "Vous devez être connecté pour acheter des sets dans la boutique.";
            }
        }
        include __DIR__."/../vue/shop.php"; //vue
    }

    public function get_all_sets() {
        $all_sets = $this->pdo->get_sets();
        return $all_sets;
    }

    public function get_sets_stock_above_0() {
        $sets_stock = $this->pdo->get_sets_stock_above_0();
        return $sets_stock;
    }

    public function get_sets_from_faction($faction_name) {
        $sets = $this->pdo->get_sets_from_faction($faction_name);
        return $sets;
    }

    public function get_set_from_name($name_set) {
        $set = $this->pdo->get_sets_from_name($name_set);
        return $set;
    }
}
?>