<?php 
require_once 'read.php';
require_once 'update.php';
require_once 'delete.php';
require_once 'create.php';
require_once 'Exceptions.php';

class DynamicObjectDispacture extends GeneralExeption{
    public $con;
    public function __construct($con) {
        $this->con = $con;
        // $con = $this->$con->connect();
    }
    
    public function dispacture($operation,$table_name,$id=0,$data_update=0,$fealds="", $data_create=array()) {
        $json=0;
        switch ($operation) {
            //Create oprations
            case 'create_entry':
                $create = new Create($this->con);
                return $create->create_entry($table_name,$id,$data_create['email'],$data_create['name']);
                break;
            case 'create_table':
                $create = new Create($this->con);
                if($fealds==0)
                    throw new GeneralExeption("There is no name of Collum names provided in the arguments.",501);
                else
                    // echo $fealds; 
                    return $create->create_table($table_name,$fealds);
                    break;

            //Read operations
            case 'read_entry':
                $read = new Read($this->con);
                return $read->read_entry($id,$table_name);
                break;
            case 'read_table':
                $read = new Read($this->con);
                return $read->read_table($table_name);
                break;
                
            
            //Update operations
            case 'update_entry':
                $update = new Update($this->con);
                return $update->update_entry($id,$table_name,$data_update);
                break;

            //Delete operations
            case 'delete_entry':
                $delete = new Delete($this->con);
                return $delete->delete_entry($id,$table_name);
                break;
            case 'delete_table':
                $delete = new Delete($this->con);
                return $delete->delete_table($table_name);
                break;
            default:
                throw new GeneralExeption("Operation not found",502);
                break;
        }
    }

    public function __destruct() {
        // $this->con->close();
    }

    
}