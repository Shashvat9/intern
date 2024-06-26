<?php
    require_once 'Exceptions.php';
    class Read extends ReadExeption{
        public $con;
        public function __construct($con) {
            $this->con = $con;
        }
        
        public function readEntry($id, $table_name): array {
            $read = $this->con->prepare("SELECT * FROM $table_name WHERE id = ?");
            $read->bind_param("i", $id);
            $flag = $read->execute();

            if (!$flag) {
                throw new ReadExeption("Error reading entry", 201);
            } else {
                $result = $read->get_result();
                $data = $result->fetch_assoc();
                return $data;
            }
        }    

        public function readTable($name): array {
            $read = $this->con->prepare("SELECT * FROM ?");
            $read->bind_param("s", $name);
            $flag = $read->execute();

            if (!$flag) {
                throw new ReadExeption("Error reading entry", 202);
            } else {
                $result = $read->get_result();
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($data, $row);
                }
                return $data;
            }
        }

        public function __destruct() {
            $this->con->close();
        }
    }