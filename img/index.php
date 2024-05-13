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
        if(empty($_FILES["img"]["name"])){
            send_json(105,"error","Please select a file to upload.");
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
            send_json(101,"error","This is too large file.");
        }
        else if($filename==102){
            send_json(102,"error","There is a error in file uplode please try again.");
        }
        else if($filename==103){
            send_json(103,"error","This file type is not allowed please enter a valid file type.");
        }
        else{
            $filearr=explode(",",$filename);
            $fileext=$filearr[1];
            $file_name=$filearr[0];
            $sql="INSERT INTO image (name,format) VALUES ('$file_name','$fileext')";
            if ($conn->query($sql) === TRUE) {
                send_json(200,"success","file has uploaded with the name of ".$filename);
            } else {
                send_json(104,"error","There is a error in file uplode please try again.");
            }
        }
    }

    // function get_last_key($array){
    //     end($array);
    //     return key($array);
    // }


    function send_json($code,$status,$message){
        $response = array(
            "code" => $code,
            "status" => $status,
            "message" => $message
        );
        echo json_encode($response);
    }