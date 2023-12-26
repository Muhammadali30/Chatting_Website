<?php
require 'CLASSES/user.php';
session_start();
if(!isset($_SESSION['USER_ID'])){
    header('location:sign-in.php');
}
if (isset($_GET['log'])) {
	session_destroy();
	if (!isset($_SESSION['USER_ID'])) {
		$user=new user();
		$user->active(0,$_SESSION['USER_ID']);
	}
  header('location:sign-in.php');
}
$user=new user();
    $user->active(1,$_SESSION['USER_ID']);
if (isset($_GET['msgid'])) {
	$user=new user();
	$user->star($_GET['msgid']);
}
if (isset($_GET['msgdel'])) {
	$user=new user();
	$user->delmsg($_GET['msgdel']);
	header('location:index.php?id='.$_GET['id']);
}
if (isset($_POST['edit'])) {
	$user=new user();
	$user->updateprofile($_POST['first'],$_POST['last'],$_POST['password'],$_SESSION['USER_ID']);
}

function add(){
    $user=new user();
    $get=$user->getdata($_SESSION['USER_ID']);
    $namechange="";
    if (!empty($_FILES['file']['name'])) {  
        $ext = substr(strrchr($_FILES['file']['name'], '.'), 1);
        $namechange=time().".".$ext;
        // if($_FILES['file']['size']>=2090152){ 
        //     echo "<script>alert('File size muse be less than 2mb');</script>"; 
        //     return;
        //     }
        // if($ext!="jpg"){ 
        //     echo "<script>alert('Extension must be jpg');</script>"; 
        //     return;
        //     }
            move_uploaded_file($_FILES['file']['tmp_name'], "IMAGES/".$_FILES['file']['name']);
            rename("IMAGES/".$_FILES['file']['name'],"IMAGES/".$namechange);  
            if(file_exists("IMAGES/".$get['u_pic'])){
                $deletefile= unlink("IMAGES/".$get['u_pic']);  
            }
            $user->updatedp($namechange,$get['u_id']);  
        }
    }  
    if (isset($_POST['upload'])) {
        add();
    }
    if (!isset($_GET['id'])) {
		if (isset($_SESSION['chatroom'])) {
			unset($_SESSION['chatroom']);
		}
    }
	// LOAD Profile
    $user=new user();
    $row=$user->getdata($_SESSION['USER_ID']);
	// LOAD CONTACTS
    $contacts=$user->getcon($_SESSION['USER_ID']);
    $status=$user->loadstatus($_SESSION['USER_ID']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Swipe – The Simplest Chat Platform</title>
		<meta name="description" content="#">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap core CSS -->
		<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
		<!-- Swipe core CSS -->
		<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
		<!-- Favicon -->
		<link href="dist/img/favicon.png" type="image/png" rel="icon">
		<style>
			<?php 
			$display="";
			
			if (isset($_GET['id'])) {
				$display="block";
			}else{
				$display="none";
			}
			?>
			#chatmanu{
					display: <?php echo $display; ?>;							
				}
			@media screen and (max-width: 991px ) {
				#chatmanu{
					display: <?php echo $display; ?>;					
				position: fixed;
				top: 0%;
				}
			}
			.imgsize{
				height:150px;
				width:150px;
				object-fit:cover;
			}
			body, html {
  height: 100%;
  margin: 0;
}

.bg {

  background-image: url("img_girl.jpg");

 
  height: 100%; 

  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

/* Safari */

		</style>
	</head>
	<body>
		<main>
			<div class="layout">
				<!-- Start of Navigation -->
				<div class="navigation">
					<div class="container">
						<div class="inside">
							<div class="nav nav-tab menu">
								<button class="btn"><img class="avatar-xl" style="object-fit:cover;" src="IMAGES/<?php echo $row['u_pic']?>"></button>
								<a onclick="TOGGLECHAT(0)" href="#members" data-toggle="tab"><i class="material-icons dp48">linked_camera</i></a>
								<a href="#discussions" data-toggle="tab" class="active"><i class="material-icons active">chat_bubble_outline</i></a>
								<a onclick="TOGGLECHAT(0)" href="#settings" data-toggle="tab"><i class="material-icons">settings</i></a>
							<a href="index.php?log=out">	<button class="btn power" ><i class="material-icons">power_settings_new</i></button></a>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Navigation -->
				<!-- Start of Sidebar -->
				<div class="sidebar" id="sidebar">
					<div class="container">
						<div class="col-md-12">
							<div class="tab-content">
								<!-- Start of Contacts -->
								<div class="tab-pane fade" id="members">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="people" placeholder="Search for people...">
											<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
										</form>
										
									</div>					
								<div class="contacts">
										<h1>STORIES</h1>
										
															<div class="data">
																<form action="addstatus.php" method="post" enctype="multipart/form-data">
																	<input type="file" name="file"  id="uploadstory" accept=".jpg">
																<label>
																	<input type="submit" name="uio" style="visibility:hidden;">
																	<span class="btn button">Upload Story</span>
																</label>
																</form>
															</div>
										<div class="list-group" id="contacts" role="tablist">
											
										</div>
									</div>
								</div>
								<!-- End of Contacts -->
								
								<!-- Start of Discussions -->
								<div id="discussions" class="tab-pane fade active show">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="conversations" placeholder="Search for conversations...">
											<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
										</form>
									</div>
														
									<div class="discussions">
										<h1>Contacts</h1>
											<?php          
											while ($contact=mysqli_fetch_assoc($contacts)) {	
											?>
											<div class="con">
										<div class="list-group" id="chats" role="tablist">
											<a href="index.php?id=<?php echo $contact['u_id']; ?>"  class="filterDiscussions all unread single active" id="list-chat-list"  role="tab">
												<img class="avatar-md" style="object-fit:cover;" src="IMAGES/<?php echo $contact['u_pic']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $contact['username']; ?>" alt="avatar">
												<!-- <div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div> -->
												<!-- <div class="new bg-yellow">
													<span>+7</span>
												</div> -->	
												
												<div class="data">
													<h5><?php echo $contact['username'];?></h5>											
												</div>
												</a>
										</div>
										</div>
											<?php 											
											}
											?>									
									</div>
								</div>
								<!-- End of Discussions -->
								<!-- Start of Notifications -->
								
								<!-- End of Notifications -->
								<!-- Start of Settings -->
								<div class="tab-pane fade" id="settings">			
									<div class="settings">
										<div class="profile">
											<img  class="avatar-xl" style="object-fit:cover;" src="IMAGES/<?php echo $row['u_pic']?>">
											<h1><a href="#"><?php echo $row['First']." ".$row['Last']?></a></h1>
											<span><?php echo $row['username']?></span>
											<div class="stats">
												<div class="item">
													<h2>122</h2>
													<h3>Fellas</h3>
												</div>
												<div class="item">
													<h2>305</h2>
													<h3>Chats</h3>
												</div>
												<div class="item">
													<h2>1538</h2>
													<h3>Posts</h3>
												</div>
											</div>
										</div>
										<div class="categories" id="accordionSettings">
											<h1>Settings</h1>
											<!-- Start of My Account -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
													<i class="material-icons md-30 online">person_outline</i>
													<div class="data">
														<h5>My Account</h5>
														<p>Update your profile details</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionSettings">
													<div class="content">
														<div class="upload">
                                                            <form action="index.php" method="post" enctype="multipart/form-data">
															<div class="data">
																<img class="avatar-xl" src="IMAGES/<?php echo $row['u_pic']?>" alt="image">
																<label>
																	<input type="file" name="file">
																	<span class="btn">CHOOSE</span>
                                                                    <button type="submit" name="upload" style="border:0px"><span class="btn button">UPLOAD</span></button>
																</label>
															</div>
															<p>For best results, use an image at least 256px by 256px in either .jpg or .png format!</p>
                                                            </form>
														</div>
														<form action="index.php" method="POST">
															<div class="parent">
																<div class="field">
																	<label for="firstName">First name <span>*</span></label>
																	<input type="text" name="first" class="form-control" id="firstName" placeholder="First name"  required>
																</div>
																<div class="field">
																	<label for="lastName">Last name <span>*</span></label>
																	<input type="text" name="last" class="form-control" id="lastName" placeholder="Last name"  required>
																</div>
															</div>
															<div class="field">
																<label for="password">Password</label>
																<input type="password" name="password" class="form-control" id="password" placeholder="Enter a new password"  required>
															</div>
															<button type="submit" name="edit" class="btn button w-100">Apply</button>
														</form>
													</div>
												</div>
											</div>
											<!-- End of My Account -->
											
											<!-- Start of Notifications Settings -->
										
											
											<!-- End of Notifications Settings -->
											
											
											
											<!-- Start of Logout -->
											<div class="category">
												<a href="index.php?log=out" class="title collapsed">
													<i class="material-icons md-30 online">power_settings_new</i>
													<div class="data">
														<h5>Power Off</h5>
														<p>Log out of your account</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
											</div>
											<!-- End of Logout -->
										</div>
									</div>
								</div>
								<!-- End of Settings -->
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sidebar -->
				
				
				<div class="main" id="chatmanu">
					<div class="tab-content" id="nav-tabContent">
						<!-- Start of Babble -->
						<div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat1">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div onclick="TOGGLECHAT(0)" style="color: black;float: left; margin-left: -10px;padding-right: 10px;margin-top: 6px; cursor: pointer;"><h3><a href="index.php"><</a></h3></div>
											<div class="inside">
												<?php
												if ($display=="block") {
													$user=new user();
													$chat=$user->getdata($_GET['id']);
													$chat_room=$user->chatroom($_SESSION['USER_ID'],$_GET['id']);
													if($chat_room!=null){
													$_SESSION['chatroom']=$chat_room;
													$user->seen($_GET['id'],$_SESSION['chatroom']);
													}
												?>
												<a href="#"><img class="avatar-md" style="object-fit:cover;" src="IMAGES/<?php echo $chat['u_pic']?>" data-toggle="tooltip" data-placement="top" title="<?php echo $chat['username']?>" alt="avatar"></a>
												
												<div class="data">
													<h5><a href="#"><?php echo $chat['First']." ".$chat['Last']?></a></h5>
													<i id="activeicon" style="font-size: 15px;display:none;"  class="material-icons offline">fiber_manual_record</i>
													<span id="active" style="display:inline-block;"></span>
												</div>
												<?php 
												}
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="content" id="content">
									
									<div class="container">
										<div class="col-md-12"  id="msgss">
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<div class="position-relative w-100">
												<textarea name="msg" id="msg" class="form-control" placeholder="Start typing for reply..." rows="1"></textarea>
												<button type="submit" onclick="send()" class="btn send" name="send"><i class="material-icons">send</i></button>
							</div>
											<label>
												<input type="file" id="uploadfile">
												<span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
						</div>
						<!-- End of Babble -->
						<!-- Start of Babble -->
						<div class="babble tab-pane fade" id="list-empty" role="tabpanel" aria-labelledby="list-empty-list">
							</div>
			</div> <!-- Layout -->
			
		</main>
		<!-- Bootstrap/Swipe core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
		<script src="dist/js/vendor/popper.min.js"></script>
		<script src="dist/js/swipe.min.js"></script>
		<script src="dist/js/bootstrap.min.js"></script>
		<script>
			function scrollToBottom(el) { el.scrollTop = el.scrollHeight; }
			scrollToBottom(document.getElementById('content'));
		</script>
		<script>
			function TOGGLECHAT(val) {if(val==0){document.getElementById('chatmanu').style.display="none";}else{document.getElementById('chatmanu').style.display="block";}}
		</script>
<script>


	document.addEventListener('visibilitychange',()=>{
	var active=0;
	if(document.hidden){
	var active=0;
	 }
	 else{
	var active=1;

	}
	var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			};
			xmlhttp.open("GET", "deletestatus.php?active="+active, true);
			xmlhttp.send();
});
<?php if (isset($_GET['id'])) {
	echo "if(true){"
?>
setInterval(() => {
	var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			document.getElementById('active').innerHTML=this.responseText;
			document.getElementById('activeicon').style.display="inline-block";
			if (this.responseText=="ONLINE") {
				
				document.getElementById('activeicon').style.color=" lightblue";
			}
			else {
				
				document.getElementById('activeicon').style.color=" lightgray";
			}
			};
			xmlhttp.open("GET", "deletestatus.php?check=<?php echo $_GET['id'];?>", true);
			xmlhttp.send();
}, 5000);
<?php 
	echo "}";
}?>

		var file=document.getElementById('uploadfile');
		file.addEventListener("change", ()=>{
			var property=file.files[0];
			//var img_name=property.name;
			var form_data=new FormData();
			form_data.append("file",property);
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				//alert(this.responseText);
			};
			xmlhttp.open("POST", "sendimage.php", true);
			xmlhttp.send(form_data);
		});


setInterval(() => {
	var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				loading();
			};
			xmlhttp.open("POST", "deletestatus.php", true);
			xmlhttp.send();
}, 10000);


	// 	var story=document.getElementById('uploadstory');
	// 	story.addEventListener("change", ()=>{
	// 		var property=file.files[0];
	// 		var form_data=new FormData();
	// 		form_data.append("file",property);
	// 		var xmlhttp = new XMLHttpRequest();
    // xmlhttp.onreadystatechange = function() {
	// 	//loading();
	// 	//document.getElementById('mystatus').innerHTML=this.responseText;
	// 	alert(this.responseText);
    // };
    // xmlhttp.open("POST", "sendimage.php?status=1", true);
    // xmlhttp.send(form_data);
	// 	});
function del() {
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		loading();
    };
    xmlhttp.open("GET", "sendimage.php?delete=<?php echo $_SESSION['USER_ID'];?>", true);
    xmlhttp.send();
}
loading();
function loading() {
			var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
			document.getElementById('contacts').innerHTML=this.responseText;
			// alert(this.responseText);
    };
    xmlhttp.open("GET", "sendimage.php?load=<?php echo $_SESSION['USER_ID'];?>", true);
    xmlhttp.send();
}
// for (var i = 0; i < document.getElementById('contacts').children.length; i++)
// {
//     (function(index){
//         document.getElementById('contacts').children[i].onclick = function(){
			
// 			// if(index!=1){
// 			// 	var newWindow = window.open();
// 			// 	var chktag=this.firstChild.src.substring(0,36);
// 			// 	var tag="";
// 			// 	if (chktag=="http://localhost:8080/chat/chatimage") {
// 			// 		var tag="<img class='bg' src="+this.firstChild.src+" >";
// 			// 	}
// 			// 	else if(chktag=="http://localhost:8080/chat/chatvideo"){
// 			// 		var tag="<video controls class='bg' src="+this.firstChild.src+" ></video>";
// 			// 	}
// 			// 	//alert(chktag);
// 			// 	newWindow.document.write("<html><head><style>.bg {height: 40%;background-position: center;background-repeat: no-repeat;background-size: cover;}</style><script type='text/javascript' src='yourCode.js'></scr"+"ipt></head><body>"+tag+"</body></html>");
// 			// 	newWindow.document.close();
// 			// 	// alert(this.firstChild.src);
// 			// }
//         }    
//     })(i);
// }
	function send() {
		var msg=document.getElementById('msg').value;
		if(msg.length==0){
return;
		}
		var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
		document.getElementById('msg').value="";
      }
    };
    xmlhttp.open("GET", "chatting.php?msg=" + msg, true);
    xmlhttp.send();
	}
	
		<?php
			if(isset($_GET['id'])){
				echo "if(true){";
			
			?>
			function dom(f,s,t,m,ti,tic,seen,chat_id,star) {
				var msgss=	document.getElementById('msgss');
		var div1=document.createElement("div");
		 div1.className=f;
		 var div2=document.createElement("div");
		 div2.className="text-main";
		 var div3=document.createElement("div");
		 div3.className=s;
		 var div4=document.createElement("div");
		 document.getElementById('msgss').appendChild(div1);
		div4.className=t;
		div1.appendChild(div2);
		div2.appendChild(div3);
		div3.appendChild(div4);
		if (m.substring(0,11)=="chatimages/") {
			var img=document.createElement("img");
			img.className="imgsize";
			img.src=m;
			div4.appendChild(img);
		}
		else if(m.substring(0,10)=="chatfiles/"){
			var div5=document.createElement("div");
			div5.className="attachment";
			var div6=document.createElement("div");
			div6.className="file";
			var button=document.createElement("button");
			button.className="btn attach";
			var i=document.createElement("i");
			i.className="material-icons md-18";
			var a=document.createElement("a");
			a.href=m;
			var val=document.createTextNode("FILE");
			a.appendChild(val);
			button.appendChild(i);
			div6.appendChild(button);
			div6.appendChild(a);
			div5.appendChild(div6);
			div4.appendChild(div5);
		}
		else if(m.substring(0,11)=="chatvideos/"){
			var x = document.createElement("VIDEO");

if (x.canPlayType("video/mp4")) {
  x.setAttribute("src",m);
} else {
  x.setAttribute("src",m);
}

x.setAttribute("width", "200");
x.setAttribute("height", "200");
x.setAttribute("controls", "controls");
			div4.appendChild(x);
		}
		else if(m.substring(0,11)=="chataudios/"){
			var x = document.createElement("AUDIO");

if (x.canPlayType("audio/mp4")) {
  x.setAttribute("src",m);
} else {
  x.setAttribute("src",m);
}
x.setAttribute("controls", "controls");
			div4.appendChild(x);
		}
		else{
			var p=document.createElement("a");
			p.href="index.php?id=<?php echo $_GET['id'];?>&msgid="+chat_id;
			var val=document.createTextNode(m);
			p.appendChild(val);
			div4.appendChild(p);
		}
		var span=document.createElement("span");

	


		if (tic=="TIC") {
			if(p){
					p.style.color = 'white';
			}
			var ii=document.createElement("i");
			if (seen==1) {
				ii.style.color = 'orange';
			}
			var icon=document.createTextNode("check");
			ii.className="material-icons";
			ii.appendChild(icon);
			span.appendChild(ii);
		}
		if (star==1) {
			var ii=document.createElement("i");
			var icon=document.createTextNode("star_border");
			ii.className="material-icons dp48";
			ii.style.color = 'green';
			ii.appendChild(icon);
			span.appendChild(ii);
		}
		var time=document.createTextNode(ti);
		span.appendChild(time);
		div2.appendChild(span);

		if (tic=="TIC") {
		var dela=document.createElement("a");
		dela.href="index.php?id=<?php echo $_GET['id'];?>&msgdel="+chat_id;
		var ii=document.createElement("i");
			var icon=document.createTextNode("delete");
			ii.className="material-icons dp48";
			ii.style.color = 'red';
			ii.appendChild(icon);
			dela.appendChild(ii);
			span.appendChild(dela);
		}
	
}
var lastid=0;

	setInterval(function() {
		// document.getElementById('msgss').innerHTML="";
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(this.responseText=="hello"){
return;
					}
					var data=JSON.parse(this.responseText);	
				if(data[0].chat_id>lastid){
					for (let i = 0; i < data.length; i++) {
						if (data[i].sender==<?php echo $_SESSION['USER_ID'];?>) {						
							dom("message me","text-group me","text me",data[i].message,data[i].time,"TIC",data[i].seen,data[i].chat_id,data[i].star);
						}else{
							dom("message","text-group","text",data[i].message,data[i].time,"NOTTIC","",data[i].chat_id,data[i].star);
						}
						lastid=data[i].chat_id;
					}
			
				}
				
				}
			};
			xmlhttp.open("GET", "getchat.php?lid="+lastid, true);
			xmlhttp.send();
		}, 1000);
			<?php
			echo "}";}
			?>
</script>
	</body>
</html>