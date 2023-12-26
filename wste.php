	<div id="notifications" class="tab-pane fade">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="notice" placeholder="Filter notifications...">
											<button type="button" class="btn btn-link loop"><i class="material-icons filter-list">filter_list</i></button>
										</form>
									</div>
									<div class="list-group sort">
										<button class="btn filterNotificationsBtn active show" data-toggle="list" data-filter="all">All</button>
										<button class="btn filterNotificationsBtn" data-toggle="list" data-filter="latest">Latest</button>
										<button class="btn filterNotificationsBtn" data-toggle="list" data-filter="oldest">Oldest</button>
									</div>						
									<div class="notifications">
										<h1>STORIES</h1>
										<div class="list-group " id="alerts" role="tablist">	
												<div class="status">
												<div class="upload">
															<div class="data">
																<label>
																	<input type="file" style="visibility:hidden;" id="uploadstory">
																	<span class="btn button">Upload Story</span>
																</label>
															</div>
														</div>
												</div>
												<a href="#" class="filterNotifications all latest notification " data-toggle="list" id="mystatus">
												<img class='avatar-md' id="storyimage" style="display:none;" data-toggle='tooltip' data-placement='top'>
												<video class='avatar-md' id="storyvideo" style="display:none;" data-toggle='tooltip' data-placement='top'></video>
												<div class="data">
													<p>Your Story</p>
													<span id="time"></span>
												</div>
												<span id="deleteicon"><i class="material-icons">delete</i></span>
												</a>
												
										<!-- hkqewfjkhwekjfhe -->
										<?php 
										while ($statu=mysqli_fetch_assoc($status)) {?>
											<a href="#" class="filterNotifications all latest notification" data-toggle="list">
												<?php if(substr($statu['file'],0,10)=="chatimages"){
												echo "<img class='avatar-md' src=".$statu['file']." data-toggle='tooltip' data-placement='top'>";
													}?>
												
												<div class="data">
													<p><?php echo $statu['username']; ?></p>
													<span><?php echo date("d,M,y H:m:s",$statu['time']); ?></span>
												</div>
											</a>
											<?php }?>
										hkqewfjkhwekjfhe


										//ajax();
// function ajax() {	
// 	alert("in ajax");	
// 	var xmlhttp = new XMLHttpRequest();
// 	xmlhttp.onreadystatechange = function() {
//       if (this.readyState == 4 && this.status == 200) {
// 		 var data=JSON.parse(this.responseText);
// 		 alert(data);
// 		 for (let i = 0; i < data.length; i++) {
// 		 if (data[i].userid=="<?php echo $_SESSION['USER_ID'] ?>") {
// 			 var img=data[i].file;
// 			 if(img.substring(0,11)=="chatimages/"){
// 				 document.getElementById('storyimage').style.display="block";
// 				 document.getElementById('storyvideo').style.display="none";
// 				 document.getElementById('storyimage').src=data[i].file; 
// 				}
// 				else if(img.substring(0,11)=="chatvideos/"){
// 					document.getElementById('storyimage').style.display="none";
// 					document.getElementById('storyvideo').style.display="block";
// 					document.getElementById('storyvideo').src=data[i].file;
					
// 				}
// 				document.getElementById('time').innerText=data[i].time;
			
// 			}
		 
//       }
//     };
// 	xmlhttp.open("GET", "sendimage.php?story=1", true);
//     xmlhttp.send();
// }}






<!-- <?php while ($sta=mysqli_fetch_assoc($status)) {
													echo "<script>alert(".$sta['username'].")</script>";		
													?>
															
													<a href='' class='filterMembers all online contact' data-toggle='list'>
													  <?php if(substr($sta['file'],0,10)=="chatimages"){
														   echo "<img class='avatar-md' src=".$sta['file'].">";
													   }
													   else if(substr($sta['file'],0,10)=="chatvideos"){
														   echo "<video class='avatar-md' src=".$sta['file']."></video>";
													   }
													?>
													
													<div class="data">
														<h5><?php echo $sta['username']; ?></h5>
														<p>Washington, USA</p>
													</div>
													
													</a> -->
													
													<?php 
											}
													 ?>