<?php 
    class file_mani 
    {

        //101 -> too large file size
        //102 -> file transfer error
        //103 -> file type not allowed

        function uplode($FileName,array $AllowedExtansion,$FileDestinationPath,$AllowedFileSize=5242880)
        {
            $file=$_FILES[$FileName];
            $file_name=$_FILES[$FileName]["name"];
            $file_tmp_name=$_FILES[$FileName]["tmp_name"];
            $file_size=$_FILES[$FileName]["size"];
            $file_error=$_FILES[$FileName]["error"];
            $file_type=$_FILES[$FileName]["type"];

            $file_get_ex=explode('.',$file_name);
            $file_ex=strtolower(end($file_get_ex));

            $allowed_ex=$AllowedExtansion;

            if(in_array($file_ex,$allowed_ex))//this will chack if the file formate is alloud or not
            {
                if($file_error==0)
                {
                    if($file_size < $AllowedFileSize)
                    {
                        $uid=uniqid('',true);
                        $file_new_name=$uid.".".$file_ex;
                        
                        $file_destination=$FileDestinationPath. $file_new_name;
                        move_uploaded_file($file_tmp_name,$file_destination);
                        return $uid.",". $file_ex;
                    }
                    else
                    {
                        return 101;
                    }
                }
                else
                {
                    return 102;
                }
            }
            else
            {
                return 103;
            }

        }   
    }