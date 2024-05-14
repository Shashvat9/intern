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
    class Search{
        public function search($table,$column,$value,$conn){
            $searchTerm = "%".$value."%";
            $query = "SELECT * FROM $table WHERE $column LIKE ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = array();

            //it will check if there is no data in the database
            if($result->num_rows === 0){
                return 101;
            }
            //it will fetch all the data from the database
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
            // return json_encode($data,true);
            return $data;
        }
        public function sendJson($data,$code,$message){
            $response = array();
            $response['data'] = $data;
            $response['code'] = $code;
            $response['message'] = $message;
            return json_encode($response,true);
        }
    }

    $search = new Search();
    if($_SERVER['REQUEST_METHOD'] =='GET'){

        //this will check if the column, value and table is set or not
        if(!isset($_GET['column']) || !isset($_GET['value']) || !isset($_GET['table'])){
            echo $search->sendJson(array(),404,"Invalid Request");
            exit;
        }

        //this will check if the column, value and table is null or not
        if($_GET['column'] == '' || $_GET['value'] == '' || $_GET['table'] == ''){
            echo $search->sendJson(array(),404,"Invalid Request");
            exit;
        }

        $column = $_GET['column'];
        $value = $_GET['value'];
        $table = $_GET['table'];
        $data = $search->search($table,$column,$value,$conn);
        if($data == 101){
            echo $search->sendJson(array(),404,"Data Not Found");
            exit;
        }
        else{
            echo $search->sendJson($data,200,"Data Found");
        }
    }
    else{
        echo $search->sendJson(array(),404,"Invalid Request");
    }