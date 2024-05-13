<?php
    require_once 'Exceptions.php';
    class Update extends UpdateExeption{
        public $con;
        public function __construct($con) {
            // $con = $this->$con->connect();
            $this->con = $con;

        }
        
        public function update_entry($id,$table_name,$data):bool {
            // echo "id = $id\n";
            // echo "name = $table_name\n";
            // echo "data = $data\n";
            $update = $this->con->prepare("UPDATE $table_name SET name=? WHERE id = ?");
            $update->bind_param("si", $data, $id);
            $flag=$update->execute();
            if(!$flag)
                throw new UpdateExeption("Error updating entry",301);
            else
                // $update->close();
                return $flag;
        }

        public function __destruct() {
            $this->con->close();
        }
    }