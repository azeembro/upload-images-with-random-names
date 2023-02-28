<?php
include_once ('./assests/connections.php');
 
if(isset($_POST['submit']))
{
        
     // Get profile Info 
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "uploads/" . $filename;
    $filename = str_replace(" ", "", $filename);
    $tempname = str_replace(" ", "", $tempname);
    move_uploaded_file($tempname, $folder);


    // Get Multi Images    
    $targetDir = "multi/"; 

    $file_name_form = $_FILES["files"]["name"];           

        foreach($file_name_form as $key=>$val)        
        {
            $file_name = basename($_FILES['files']['name'][$key]);     
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);

            $randomnumber = time() - rand(0, 999999);
            $file_name = "IMG".$randomnumber.'.'.$ext; 
            $targetFile = $targetDir.$file_name;
            move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFile);

            $insertQrySplit[] = $file_name;                  
            $image_str = implode(',', $insertQrySplit); 
        }
     
       $query="select * from images";
       $result=mysqli_query($conn,$query);
        if ($result->num_rows > -1){  
            $sql = "INSERT INTO images (id, singleimage, multiimage)
            VALUES ('', '$filename', ' $image_str');";
            if ($conn->query($sql) == TRUE) {
                $message = "Data Added Succesfully";
               // echo $message;
            }else{
                $message = "Data Not Added";
               // echo $message;
            }

    }else{
    }

}else{
    // NO Message
}

