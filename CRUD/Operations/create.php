<?php 
require_once 'Exceptions.php';
    class Create extends CreateExeption{
        public $con;
        public function __construct($con) {
            $this->con = $con;

        }
        
        public function createEntry($table_name, $id, $email, $name): bool {
            try{
                $query = "INSERT INTO $table_name (`id`,`email`,`name`) VALUES (?,?,?)";
                $create = $this->con->prepare($query);
                $create->bind_param("iss", $id, $email, $name);
                $flag = $create->execute();
            }
            catch(Exception $e){
                throw new CreateExeption($e->getMessage(), 101);
            }
            return $flag;
        }
        public function createTable($name,$fields): bool{
            $create="";
            $sql="CREATE TABLE $name ($fields)";
            // echo $sql; 
            try{
                $create = $this->con->prepare($sql);
                $flag = $create->execute();
            }
            catch(Exception $e){
                // echo $e->getMessage();
                throw new CreateExeption("Error creating table",102);
            }
            return $flag;
        }

        public function __destruct() {
            $this->con->close();
        }
    }

