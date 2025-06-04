<?php
include_once __DIR__."/pdo_controller.php";
include_once __DIR__."/utilisateur_controller.php";
include_once __DIR__."/../model/achat_model.php";

class Achat_controller {
    private $pdo;
    private $model;

    public function __construct($pdo_controller) {
        $this->pdo = $pdo_controller->getPdo();
        $this->model = new Achat_model($this->pdo);
    }

    public function buy_everything($forms) {
        if (!isset($_SESSION["emailU"])) {
            $error_msg = "Vous devez être connecté pour pouvoir faire cette action";
            return FALSE;
        }
        if (isset($forms["sets"])) {
            foreach ($forms["sets"] as $set_id => $set_data) {
                $TEMP_name_set = $set_data["nom"];
                $TEMP_number_set = intval($set_data["quantite"]);
                for ($i=0; $i < $TEMP_number_set; $i++) {
                    $this->add_achat_from_name_emailU($TEMP_name_set, $_SESSION["emailU"]);
                }
            }
        }
        return TRUE;
    }

    public function add_achat_from_name_emailU($name_set, $emailU) {
        $achat = $this->model->add_achat_from_name_email($name_set, $emailU);
        return $achat;
    }

    public function get_all_achat_from_emailU($emailU) {
        $achats = $this->model->get_all_achat_from_email($emailU);
        return $achats;
    }

    public function get_achat_from_name_emailU($name_set, $emailU) {
        $achats = $this->model->get_achat_from_name_email($name_set, $emailU);
        return $achats;
    }

    public function delete_all_achat_from_emailU($emailU) {
        $deletes = $this->model->delete_all_achat_from_email($emailU);
        return $deletes;
    }

    public function delete_achat_from_name_emailU($name_set, $emailU) {
        $deletes = $this->model->delete_achat_from_name_email($name_set, $emailU);
        return $deletes;
    }

    public function delete_nb_achat_from_name_emailU($limit, $name_set, $emailU) {
        $deletes = $this->model->delete_nb_achat_from_name_email($limit, $name_set, $emailU);
        return $deletes;
    }
}
?>