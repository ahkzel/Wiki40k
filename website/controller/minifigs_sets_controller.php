<?php
include_once __DIR__."/pdo_controller.php";
include_once __DIR__."/../model/minifigs_model.php";

class Minifigs_controller {
    private $pdo;
    private $model;

    public function __construct($pdo_controller) {
        $this->pdo = $pdo_controller->getPdo();
        $this->model = new Minifigs_model($this->pdo);
    }

    public function show_sets_above_0() {
        $available_sets = $this->get_sets_stock_above_0();

        foreach ($available_sets as &$TEMP_set) {
            foreach ($TEMP_set as &$TEMP_attribute) {
                $TEMP_attribute = $this->handle_NULL($TEMP_attribute);
            }
        }

        return $available_sets;
    }

    public function add_to_basket($forms) {
        $available_sets = $this->show_sets_above_0();
        if (isset($forms["name_set"])) {
            $TEMP_set_name = $forms["name_set"];
            $active_set = $this->get_set_from_name($TEMP_set_name);
            
            if (isset($_SESSION["emailU"])) {
                return $active_set;
            }
            else {
                $error_msg = "Vous devez être connecté pour acheter des sets dans la boutique.";
                return [];
            }
        }
    }

    public function get_all_sets() {
        $all_sets = $this->model->get_sets();
        return $all_sets;
    }

    public function get_sets_stock_above_0() {
        $sets_stock = $this->model->get_sets_stock_above_0();
        return $sets_stock;
    }

    public function get_sets_from_faction($faction_name) {
        $sets = $this->model->get_sets_from_faction($faction_name);
        return $sets;
    }

    public function get_set_from_name($name_set) {
        $set = $this->model->get_sets_from_name($name_set);
        return $set;
    }

    public function handle_NULL($item) {
        if ($item == NULL) {
            return "N/A";
        }
        return $item;
    }
}
?>