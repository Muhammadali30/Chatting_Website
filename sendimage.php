<?php
session_start();
require 'CLASSES/user.php';
    $user=new user();
    if(isset($_GET['delete'])){
    
        $user=new user();
        $user->delete($_GET['delete']);
        
    }
  if(isset($_GET['load'])){
    
    $user=new user();
    $l= $user->loadstatus();
         if (!empty($l)) {
            while ($s=mysqli_fetch_assoc($l)) {
                if($s['userid']==$_SESSION['USER_ID']){

                    echo"<a href='#' class='filterMembers all latest contact ' data-toggle='list'  >";
                    
                    if(substr($s['file'],0,10)=="chatimages"){
                        echo "<img class='avatar-md' src=".$s['file'].">";
                    }
                    else if(substr($s['file'],0,10)=="chatvideos"){
                        echo "<video class='avatar-md' src=".$s['file']."></video>";
                    }
                    echo " <div class='data'>";
                    echo"<h5>Your Story</h5>";
                    echo"<br>";
                    echo"<span id='time'>". date("d,M,y H:m:s",$s['time'])."</span>";
                    echo"</div><span onclick='del()''><i class='material-icons'>delete</i></span></a>";
                }
        }
        echo"<hr style='border:2px solid lightblue;width:100px'>";
        $p= $user->loadstatus();
            while ($s=mysqli_fetch_assoc($p)) {
                if($s['userid']!=$_SESSION['USER_ID']){
				echo"<a href='#' class='filterMembers all latest contact ' data-toggle='list'  >";
            
                if(substr($s['file'],0,10)=="chatimages"){
                    echo "<img class='avatar-md' src=".$s['file'].">";
                }
                else if(substr($s['file'],0,10)=="chatvideos"){
                    echo "<video class='avatar-md' src=".$s['file']."></video>";
                }
                echo " <div class='data'>";
                echo"<h5>".$s['username']."</h5>";
                echo"<br>";
                echo"<span id='time'>". date("d,M,y H:m:s",$s['time'])."</span>";
                echo"</div>";
            echo"</a>";}
            }
        }
    
}


    if (!empty($_FILES['file']['name'])&&!isset($_GET['load'])) {  
        $dir="";
        $namechange="";
        $ext = substr(strrchr($_FILES['file']['name'], '.'), 1);
            $namechange=time().".".$ext;
        if(strtolower($ext)=="jpg"||strtolower($ext)=="jpeg"||strtolower($ext)=="png"||strtolower($ext)=="webp"||strtolower($ext)=="gif"||strtolower($ext)=="bmp"){
            move_uploaded_file($_FILES['file']['tmp_name'], "chatimages/".$_FILES['file']['name']);
            rename("chatimages/".$_FILES['file']['name'],"chatimages/".$namechange);  
            $dir="chatimages/";
        }
        else if(strtolower($ext)=="mp4"||strtolower($ext)=="mov"||strtolower($ext)=="avi"||strtolower($ext)=="mkv"||strtolower($ext)=="webm"||strtolower($ext)=="mwv"){
            move_uploaded_file($_FILES['file']['tmp_name'], "chatvideos/".$_FILES['file']['name']);
            rename("chatvideos/".$_FILES['file']['name'],"chatvideos/".$namechange);  
            $dir="chatvideos/";
        }
        else if(strtolower($ext)=="mp3"||strtolower($ext)=="wav"||strtolower($ext)=="aiff"||strtolower($ext)=="flac"||strtolower($ext)=="m4a"||strtolower($ext)=="ogg"||strtolower($ext)=="aac"){
            move_uploaded_file($_FILES['file']['tmp_name'], "chataudios/".$_FILES['file']['name']);
            rename("chataudios/".$_FILES['file']['name'],"chataudios/".$namechange);  
            $dir="chataudios/";
        }
        else{
            move_uploaded_file($_FILES['file']['tmp_name'], "chatfiles/".$_FILES['file']['name']);
            rename("chatfiles/".$_FILES['file']['name'],"chatfiles/".$namechange);  
            $dir="chatfiles/";
        }
       
            $user->chatting($dir.$namechange,$_SESSION['USER_ID'],$_SESSION['chatroom']); 

        
       
        
        }  
?>