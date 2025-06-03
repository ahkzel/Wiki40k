<?php
include_once __DIR__."/../model/pdo.php";

class Pdo_controller {
    private $pdo;
    
    public function __construct() {
        $con = new CoPDO();
        $this->pdo = $con->connexionPDO();
    }

    public function getPdo() {
        return $this->pdo;
    }
}
?>