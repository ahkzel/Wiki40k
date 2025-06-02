<?php
include_once __DIR__."/../model/minifigs_model.php";

class Minifigs_controller {
    private $pdo;
    private $faction_controller;

    public function __construct($faction_controller) {
        $this->pdo = new Minifigs_model();
        $this->faction_controller = $faction_controller;
    }

    public function show_sets_above_0($datas) {
        if (isset($datas["parent_faction"])) {
            $TEMP_faction_name = htmlspecialchars($datas["parent_faction"]);
            $available_sets = $this->get_sets_from_faction($TEMP_faction_name);
        }
        $available_sets = $this->get_sets_stock_above_0();

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