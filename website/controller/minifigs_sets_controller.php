<?php
include_once __DIR__."/../model/minifigs_model.php";

class Minifigs_controller {
    private $pdo;

    public function __construct() {
        $this->pdo = new Minifigs_model();
    }

    public function get_all_sets() {
        $all_sets = $this->pdo->get_sets();
        return $all_sets;
    }

    public function get_sets_stock_above_0() {
        $sets_stock = $this->pdo->get_sets_stock_above_0();
        return $sets_stock;
    }

    public function get_set_from_name($name_set) {
        $set = $this->pdo->get_sets_from_name($name_set);
        return $set;
    }
}

$sets_controller = new Minifigs_controller();

$all_sets = $sets_controller->get_all_sets();

$active_stock = $sets_controller->get_sets_stock_above_0();

include ""; //vue;
include ""; //vue;
include ""; //vue;
?>