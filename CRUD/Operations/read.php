<?php
    require_once 'Exceptions.php';
    class Read extends ReadExeption{
        public $con;
        public function __construct($con) {
            $this->con = $con;
        }
        
        public function read_entry($id, $table_name): array {
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

        public function read_table($name): array {
            $read = $this->con->prepare("SELECT * FROM $name");
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