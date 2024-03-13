<?php
    class GeneralDatabase {
        private $host = "localhost";
        private $name = "root";
        private $password = "";
        private $dbname = "general";
    
        public $db;
    
        public function getConnection() {
            $this->db = null;
        
            try {
                $this->db = new mysqli($this->host, $this->name, $this->password, $this->dbname);
            }
            catch (mysqli_sql_exception $e){
                echo $e->getMessage();
            }
        
            return $this->db;
        }
    
    }
?>