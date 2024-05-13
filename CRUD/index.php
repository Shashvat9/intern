<?php
    require_once 'Operations/Exceptions.php';
    require_once 'Operations/dynamic_object_dispacture.php';
    require_once 'Operations/conn.php';

    //now this file will be used to dispacture the request to the correct operation based on request method
    //POST for create, PUT for update, DELETE for delete, GET for read

    

    $request_methode=$_SERVER['REQUEST_METHOD'];

    //POST

    // create entry
    // {
    // operation : 'op',
    // id : 'id',
    // table_name: 'name',
    // data : 'data'
    // }

    // create table
    // {
    // operation : 'op',
    // table_name: 'name',
    // fealds : 'fealds'    
    // }
    $con=$conn;

    if($request_methode==='POST'){
        $data = json_decode(file_get_contents('php://input'), true);

        print_r($data);

        //this will check is the request body is empty or not
        if(!isset($data['operation'])||!isset($data['table_name'])||!isset($data['id'])||!isset($data['email'])||!isset($data['name'])){
            echo send_json(503,"Check the request body.");
            // echo "operation : ".$data['operation']."<br>";
            return;
        }
        // this will check the data in the request body is null or not
        if($data['operation']==='create_entry'){
            if($data['id']==null||$data['table_name']==null||$data['email']==null||$data['name']==null){
                echo send_json(503,"Check the request body.");
                return;
            }
        }
        else if($data['operation']==='create_table'){
            if($data['table_name']==null||$data['fealds']==null){
                echo send_json(503,"Check the request body.");
                return;
            }
        }
        //this will check the data in request body is empty or not
        if($data['operation']==='create_entry'){
            if(empty($data['id'])||empty($data['table_name'])||empty($data['email'])||empty($data['name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }
        else if($data['operation']==='create_table'){
            if(empty($data['table_name'])||empty($data['fealds'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }


        $operation=$data['operation'];
        if($operation==='create_table'){
            // if(!isset($data['fealds'])){
            //     echo send_json(503,"Check the request body.");
            //     print_r($data);
            //     return;
            // }
            $table_name=$data['table_name'];
            $fealds=$data['fealds'];
            $dispacture = new DynamicObjectDispacture($con);
            try{
                echo send_json(100,$dispacture->dispacture($operation,$table_name,0,0,$fealds));
            }
            catch(GeneralExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(CreateExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
        }
        else if ($operation==='create_entry'){
            $id=$data['id'];
            $table_name=$data['table_name'];
            $email=$data['email'];
            $name=$data['name'];
            // $data=$data['data'];
            $dispacture = new DynamicObjectDispacture($con);
            try{
                $dataarr = array("email"=>$email,"name"=>$name);
                echo send_json(100,$dispacture->dispacture($operation,$table_name,$id,0,"",$dataarr));
            }
            catch(GeneralExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(CreateExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(Exception $e){
                echo send_json(504,$e->getMessage().$e->getCode());
            }
        }
        else{
            echo send_json(503,"Operation not found for POST method.");
        }
    }

    //put update entry
    // {
    // id : 'id',
    // table_name: 'name',
    // data : 'data'
    // }
    else if($request_methode==='PUT'){
        $data = json_decode(file_get_contents('php://input'), true);
        $operation="update_entry";
        //this will check is the request body is empty or not
        if(!isset($data['id'])||!isset($data['table_name'])||!isset($data['data'])){
            echo send_json(503,"Check the request body.");
            return;
        }

        //this will check the data in the request body is null or not
        if($data['id']==null||$data['table_name']==null||$data['data']==null){
            echo send_json(503,"Check the request body.");
            return;
        }

        //this will check the data in request body is empty or not
        if(empty($data['id'])||empty($data['table_name'])||empty($data['data'])){
            echo send_json(503,"Check the request body.");
            return;
        }

        $id=$data['id'];
        $table_name=$data['table_name'];
        $data=$data['data'];
        $dispacture = new DynamicObjectDispacture($con);
        try{
            echo send_json(200,$dispacture->dispacture($operation,$table_name,$id,$data));
        }
        catch(GeneralExeption $e){
            echo send_json($e->getCode(),$e->getMessage());
        }
        catch(UpdateExeption $e){
            echo send_json($e->getCode(),$e->getMessage());
        }
        catch(Exception $e){
            echo send_json(504,$e->getMessage().$e->getCode());
        }
    }

    //DELETE

    //delete entry
    // {
    // operation : 'op',
    // id : 'id',
    // table_name: 'name'
    // }

    else if($request_methode==='DELETE'){
        $data = json_decode(file_get_contents('php://input'), true);

        //this will check is the request body is empty or not
        if(!isset($data['operation'])){
            echo send_json(503,"Operation not fild found for DELETE method.");
            return;
        }

        //this will check the data in the request body is null or not
        if($data['operation']==='delete_table'){
            if(!isset($data['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }
        else if($data['operation']==='delete_entry'){
            if(!isset($data['id'])||!isset($data['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }

        //this will check the data in request body is empty or not
        if($data['operation']==='delete_table'){
            if(empty($data['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }
        else if($data['operation']==='delete_entry'){
            if(empty($data['id'])||empty($data['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }


        $operation=$data['operation'];


        if($operation==='delete_table'){
            if(!isset($data['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
            $table_name=$data['table_name'];
            $dispacture = new DynamicObjectDispacture($con);
            try{
                echo send_json(300,$dispacture->dispacture($operation,$table_name));
            }
            catch(GeneralExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(DeleteExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(Exception $e){
                echo send_json(504,$e->getMessage().$e->getCode());
            }
        }
        else if ($operation==='delete_entry'){
            if(!isset($data['id'])||!isset($data['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
            $id=$data['id'];
            $table_name=$data['table_name'];
            $dispacture = new DynamicObjectDispacture($con);
            try{
                echo send_json(300,$dispacture->dispacture($operation,$table_name,$id));
            }
            catch(GeneralExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(DeleteExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(Exception $e){
                echo send_json(504,$e->getMessage().$e->getCode());
            }
        }
        else{
            echo send_json(503,"Operation not found for DELETE method.");
        }
    }
    //GET

    //get read entry
    // {
    // operation : 'op',
    // id : 'id',
    // table_name: 'name'
    // }
    else if($request_methode==='GET'){
        // $data = json_decode(file_get_contents('php://input'), true);
        if(!isset($_GET['operation'])){
            echo send_json(503,"Operation not found for GET method.");
            return;
        }

        //this will check the data in the request body is null or not
        if($_GET['operation']==='read_table'){
            if(!isset($_GET['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }
        else if($_GET['operation']==='read_entry'){
            if(!isset($_GET['id'])||!isset($_GET['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }

        //this will check the data in request body is empty or not
        if($_GET['operation']==='read_table'){
            if(empty($_GET['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }
        else if($_GET['operation']==='read_entry'){
            if(empty($_GET['id'])||empty($_GET['table_name'])){
                echo send_json(503,"Check the request body.");
                return;
            }
        }

        

        $operation=$_GET['operation'];
        if($operation==='read_table'){
            $table_name=$_GET['table_name'];
            $dispacture = new DynamicObjectDispacture($con);
            try{
                echo send_json(400,$dispacture->dispacture($operation,$table_name));
            }
            catch(GeneralExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(ReadExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(Exception $e){
                echo send_json(504,$e->getMessage().$e->getCode());
            }
        }
        else if ($operation==='read_entry'){
            $id=$_GET['id'];
            $table_name=$_GET['table_name'];
            $dispacture = new DynamicObjectDispacture($con);
            try{
                echo send_json(400,$dispacture->dispacture($operation,$table_name,$id));
            }
            catch(GeneralExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(ReadExeption $e){
                echo send_json($e->getCode(),$e->getMessage());
            }
            catch(Exception $e){
                echo send_json(504,$e->getMessage().$e->getCode());
                // echo $e->getMessage().$e->getCode();

            }
        }
        else{
            echo send_json(503,"Operation not found for GET method.");
        }
    }
    //100 success post
    //200 success put
    //300 success delete
    //400 success get
    function send_json($code,$message){
        $json=array();
        $json['code']=$code;
        $json['message']=$message;
        return json_encode($json);
    }