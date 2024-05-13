<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
class Join{
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }
    public function inner_join($table1,$table2){
        $query = "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.did = $table2.did;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return json_encode($data,true);
    }
    public function left_join($table1,$table2){
        $query = "SELECT * FROM $table1 LEFT JOIN $table2 ON $table1.did = $table2.did;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return json_encode($data,true);
    }
    public function right_join($table1,$table2){
        $query = "SELECT * FROM $table1 RIGHT JOIN $table2 ON $table1.did = $table2.did;;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return json_encode($data,true);
    }

    public function outer_join($table1,$table2){
        $query = "SELECT * FROM test 
                    LEFT JOIN test2 ON $table1.did = $table2.did
                    UNION 
                    SELECT * FROM test 
                    RIGHT JOIN test2 ON $table1.did = $table2.did;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return json_encode($data,true);
    }
}

if($_SERVER["REQUEST_METHOD"]==="GET"){
    
    //this will check if the perameaters are empty
    if(!isset($_GET['table1']) || !isset($_GET['table2']) || !isset($_GET['operation'])){
        echo "Invalid perameters";
        return;
    }

    //this will check if the perameaters are null
    if($_GET['table1']==null || $_GET['table2']==null || $_GET['operation']==null){
        echo "Invalid perameters";
        return;
    }

    $table1 = $_GET['table1'];
    $table2 = $_GET['table2'];
    $operation = $_GET['operation'];
    $join = new Join($conn);

    if($operation==='inner_join'){
        echo $join->inner_join($table1,$table2);
    }
    else if($operation==='left_join'){
        echo $join->left_join($table1,$table2);
    }
    else if($operation==='right_join'){
        echo $join->right_join($table1,$table2);
    }
    else if($operation==='outer_join'){
        echo $join->outer_join($table1,$table2);
    }
    else{
        echo "Invalid operation";
    }
}