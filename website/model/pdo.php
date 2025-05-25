<?php
class CoPDO {
    private $host = 'localhost';
    private $db_name = 'wiki40k';
    private $username = 'root';
    private $password = 'FrouFrou';
    private $con;

    public function connexionPDO() {
        $this->con = NULL;

        try {
            $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
        return $this->con;
    }
}
?>