<?php
    require_once 'Manipulation.php';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "crud";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        //this will check if the perameaters are empty
        if(empty($_FILES["img"]["name"])){
            sendJson(105,"error","Please select a file to upload.");
            return;
        }
        //this will check if the perameaters are null
        if($_FILES["img"]["name"]==null){
            sendJson(105,"error","Please select a file to upload.");
            return;
        }
        // echo $_POST["img"];
        $file_name=$_FILES["img"]["name"];
        $allowd_ext=["jpg","jpeg","png"];
        $file_destination_path="uploads/";
        $file_seze=5242880;

        // print_r($_POST);
        $file_mani = new file_mani();
        $filename=$file_mani->uplode("img",$allowd_ext,$file_destination_path,$file_seze,$file_name);

        if($filename==101){
            sendJson(101,"error","This is too large file.");
        }
        else if($filename==102){
            sendJson(102,"error","There is a error in file uplode please try again.");
        }
        else if($filename==103){
            sendJson(103,"error","This file type is not allowed please enter a valid file type.");
        }
        else{
            $filearr=explode(",",$filename);
            $fileext=$filearr[1];
            $file_name=$filearr[0];
            $sql="INSERT INTO image (name,format) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $file_name,$fileext);
            if($stmt->execute()){
                sendJson(200,"success","file has uploaded with the name of ".$file_name);
            }
            else{
                sendJson(104,"error","There is a error in file uplode please try again.");
            }

            // if ($conn->query($sql) === TRUE) {
            //     sendJson(200,"success","file has uploaded with the name of ".$filename);
            // } else {
            //     sendJson(104,"error","There is a error in file uplode please try again.");
            // }
        }
    }

    // function get_last_key($array){
    //     end($array);
    //     return key($array);
    // }


    function sendJson($code,$status,$message){
        $response = array(
            "code" => $code,
            "status" => $status,
            "message" => $message
        );
        echo json_encode($response);
    }