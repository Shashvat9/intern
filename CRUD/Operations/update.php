<?php
    require_once 'Exceptions.php';
    class Update extends UpdateExeption{
        public $con;
        public function __construct($con) {
            $this->con = $con;

        }
        
        public function updateEntry($id,$table_name,$data):bool {
            $update = $this->con->prepare("UPDATE $table_name SET name=? WHERE id = ?");
            $update->bind_param("si", $data, $id);
            $flag=$update->execute();
            if(!$flag)
                throw new UpdateExeption("Error updating entry",301);
            else
                return $flag;
        }

        public function __destruct() {
            $this->con->close();
        }
    }