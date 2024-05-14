<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

class FindNull {
    public function findNull($conn,$id,$table) {
        $sql = "SELECT * FROM $table WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row_assoc=$result->fetch_assoc();
            reset($row_assoc);
            $nullarr=array();
            for($i=0;$i<count($row_assoc)-1;$i++) {
                if(next($row_assoc) == null) {
                    array_push($nullarr,key($row_assoc));
                }
            }
            return $nullarr;
        } else {
            return false;
        }
    }

    public function fillNull($conn,$id,$table,$nullarr,$data){
        for($i=0;$i<count($nullarr);$i++) {
            $sql = "UPDATE $table SET $nullarr[$i] = '$data' WHERE id = $id";
            $conn-> query($sql);
        }
    }
}

$find = new FindNull();



// json = {
//     operation : 'op',    
//     id : 'id',
//     table: 'table',
//     data : 'data'
// }
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $data = json_decode(file_get_contents('php://input'), true);
    //this will check if the json is valid
    if(!isset($data['operation']) || !isset($data['id']) || !isset($data['table']) || !isset($data['data'])) {
        send__json(400,"Invalid JSON","");  
        return;
    }

    //this will check if the perameaters are empty
    if(empty($data['operation']) || empty($data['id']) || empty($data['table']) || empty($data['data'])) {
        send__json(400,"Empty parameters","");  
        return;
    }

    //this will check if the perameaters are null 
    if($data['operation'] == null || $data['id'] == null || $data['table'] == null || $data['data'] == null) {
        send__json(400,"Null parameters","");  
        return;
    }
    
    $operation=$data['operation'];
    if($operation==='put_value'){
        $id=$data['id'];
        $table=$data['table'];
        $data=$data['data'];
        $null_arr=$find->findNull($conn,$id,$table);
        if($null_arr == false) {
            send__json(200,"No null values found","");  
        }
        else {
            $find->fillNull($conn,$id,$table,$null_arr,$data);
            send__json(200,"Data filled successfully","Null columns: ".implode(",",$null_arr)." filled with data: ".$data);
        }
    }
    else if($operation==='put_none'){
        $id=$data['id'];
        $table=$data['table'];
        $data = "";
        $null_arr=$find->findNull($conn,$id,$table);
        if($null_arr == false) {
            send__json(200,"No null values found","");  
        }
        else {
            $find->fillNull($conn,$id,$table,$null_arr,$data);
            send__json(200,"Data filled successfully","Null columns: ".implode(",",$null_arr)." filled with data: ".$data);
        }
    }
    else {
        echo "Operation not found for PUT method.";
    }

}

function send__json($code, $message, $data) {
    $response = array(
        'code' => $code,
        'message' => $message,
        'data' => $data
    );
    echo json_encode($response);
}
