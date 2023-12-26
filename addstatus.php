<?php
session_start();
require 'CLASSES/user.php';
if (isset($_POST['uio'])) {
    $user=new user();
    $dir="";
    $namechange="";
    $ext = substr(strrchr($_FILES['file']['name'], '.'), 1);
    $del= $user->getstatus();
    if(file_exists($del['file'])){
        $deletefile= unlink($del['file']);  
    }
        $namechange=$_SESSION['USER_ID'].".".$ext;
    if(strtolower($ext)=="jpg"||strtolower($ext)=="jpeg"||strtolower($ext)=="png"||strtolower($ext)=="webp"||strtolower($ext)=="gif"||strtolower($ext)=="bmp"){
        move_uploaded_file($_FILES['file']['tmp_name'], "chatimages/".$_FILES['file']['name']);
        rename("chatimages/".$_FILES['file']['name'],"chatimages/".$namechange);  
        $dir="chatimages/";
        echo "moved";
    }
    else if(strtolower($ext)=="mp4"||strtolower($ext)=="mov"||strtolower($ext)=="avi"||strtolower($ext)=="mkv"||strtolower($ext)=="webm"||strtolower($ext)=="mwv"){
        move_uploaded_file($_FILES['file']['tmp_name'], "chatvideos/".$_FILES['file']['name']);
        rename("chatvideos/".$_FILES['file']['name'],"chatvideos/".$namechange);  
        $dir="chatvideos/";
    }
    echo "uploaded";
    $user->status($dir.$namechange,$_SESSION['USER_ID']);
    header("location:index.php");
}
         
    
   
    
?>