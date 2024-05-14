<?php
class Delete extends DeleteExeption{
    public $con;
    public function __construct($con) {
        $this->con = $con;
    }
    
    public function deleteEntry($id,$table_name):bool {
        $delete = $this->con->prepare("DELETE FROM $table_name WHERE id = ?");
        $delete->bind_param("i", $id);
        try{
            $flag=$delete->execute();
        }
        catch(Exception $e){
            throw new DeleteExeption("Error deleting entry",401);
        }
        return $flag;
    }

    public function deleteTable($name):bool {
        $delete = $this->con->prepare("DELETE FROM ?");
        $delete->bind_param("s", $name);
        $flag=$delete->execute();
        // $flag=$delete->execute();
        if(!$flag)
            throw new DeleteExeption("Error deleting entry",402);
        else
            return $flag;
    }

    public function __destruct() {
        $this->con->close();
    }
}