<?php
$pg = 3;
include "includes/header.php";
include "../includes/connect.php";
include "includes/sessions.php";
date_default_timezone_set("Africa/Nairobi");
$date = date("Y-m-d H:i:s");

$chats_qry = "SELECT *, COUNT(case when project_messages.msg_status=0 AND project_messages.msg_type=1 then project_messages.msg_status end) AS unreadmessages FROM project_messages JOIN client_case ON client_case.case_id=project_messages.project_id JOIN lawyer_case ON lawyer_case.case_id=client_case.case_id WHERE lawyer_case.lawyer_id='$lecID' GROUP BY project_messages.project_id ORDER BY MAX(project_messages.proj_msg_id) DESC";
$chats_res = $conn->query($chats_qry);

?>

    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">

            <?php include "includes/navbar.php";?>
            <?php include "includes/sidebar.php";?>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper pb-0">
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid p-0">
                        <!-- Default box -->
                        <div class="row pt-2">
                            <!--Contacts list-->
                            <div class="col-md-5 col-lg-4 col-xl-4 h-100" id="smallhide">


                                <!-- side box -->
                                <div class="card card-solid shadow h-100">
                                    <div class="card-header" id="chatfoot">
                                        <h4>Messages</h4>
                                    </div>
                                    <div id="onlineNavigator" class="bg-danger sr-only p-0 text-sm text-center shadow-sm" ><i class="fas fa-exclamation-triangle"></i> You are offline!</div>
                                    <div class="card-body">
                                    
                                        <div class="input-group input-group-sm border border-dark rounded-pill">
                                            <div class="input-group-append rounded-pill">
                                                <button class="btn bg-white btn-navbar rounded-pill ml-1">
                                        <i class="fas fa-search text-dark"> <span class=""></span></i>
                                      </button>
                                            </div>
                                            <input class="form-control border border-white rounded-pill" type="search" id="myInput" onkeyup="searchFunction()" placeholder="Search for chats..." required autocomplete="off">
                                        </div>
                                        <hr>

                                        <div style="height:383px;overflow-y:auto">

                                            <ul class="products-list product-list-in-card pl-2 pr-2" id="myUL">
                                                <li ><a></a></li>
                                                <?php while($chats_row = $chats_res->fetch_assoc()){
                                                    $ord = $chats_row["project_id"];
                                                    $last_sms_qry = "SELECT * FROM project_messages WHERE project_id='$ord' ORDER BY proj_msg_id DESC LIMIT 1";
                                                    $last_sms_res = $conn->query($last_sms_qry);
                                                    $last_sms_row = $last_sms_res->fetch_assoc();
                                                   
                                                    if($chats_row["unreadmessages"] > 0){
                                                        $unread = $chats_row["unreadmessages"];
                                                    }else{
                                                        $unread = "";
                                                    }
                                                    
                                                    
                                                    ?>
                                                <li class="item">
                                                    <a href="javascript:void(0)" class="msgexact" id="<?php echo $chats_row["project_id"];?>">
                                                        <div class="product-img">
                                                            <img src="../img/orderplaceholder.png" alt="ORDER" class="img-circle img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            <span class="product-tile"><span class="text-dark text-capitalize"><?php echo $chats_row["case_number"] . " - " . $chats_row["title"];?> </span>
                                                            <span class="badge badge-success float-right" id="unr<?php echo $ord;?>"><?php echo $unread;?></span></span>
                                                            <span class="product-description text-sm you" id="sidemessage<?php echo $chats_row["project_id"];?>">
                                                                    <?php  if($last_sms_row["msg_type"] == 0){
                                                                        echo '
                                                                        <span class="text-sm text-secondary you">You:</span> ';
                                                                    }?>
                                                                    <?php echo $last_sms_row["message"];?> </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- /.item -->
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>







                            <!--Chat area-->
                            <div class="col-md-7 col-lg-8 col-xl-8 h-100  d-none d-md-block " id="smallshow">
                                <!-- DIRECT CHAT PRIMARY -->
                                <div  class="card card-prirary direct-chat direct-chat-info " style="min-height:546px">

                                    <div class="pl-1 card-header sticky-top bg-white" style="white-space:nowrap;overflow:hidden;" id="showtopinfo">

                                        <!--<img class="direct-chat-img" src="../img/orderplaceholder.png" alt="message user image"> <span class="mt-3">ORD2598 | RZL34533</span>-->
                                    </div>

                                    <div id="onlineNavigatorsm" class="bg-danger sr-only p-0 text-sm text-center shadow-sm" style="position:absolute;z-index:9999;width:100%;top:11%;opacity:0.8"><i class="fas fa-exclamation-triangle"></i> You are offline!</div>
 <!-- /.card-header -->

                                    <div class="card-body">
                                        <!-- Conversations are loaded here -->
                                        <div class="direct-chat-messages" style="min-height:400px" id="btmScroll">
                                            <div class="text-center pt-5">
                                                <span class="text-info h5"><i class="far fa-comments"></i> SLLS Messenger </span><br/>
                                                <img src="../img/chaticon.png" loading="lazy" class="img-fluid" style="opacity:.5" alt="You can now Chat with your Project Supervisor."  > <br/>
                                                You can now chat with your Clients.<br/>
                                                Simply visit the Case page and start a chat with the Client.<br/>
                                                <span class="text-info"> <span class="">Let's get connected!</span></span>
                                            </div>
                                        </div>
                                        <!--/.direct-chat-messages-->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer invisible pr-0 pl-1" id="cardfooter" tabindex="0">

                                        <div id="referenceBox" class="m-0 alert d-none alert-info shadow" style="position: relative; bottom:13%; width:85%" >
                                        <button type="button" id="refclose" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <span class="text-sm">@about: <a id="reftask" href="#">Mention</a></span>
                                        </div>

                                        <form id="sendmessage" method="post">
                                            <div class="input-group">
                                                <textarea name="message" id="message" placeholder="Type Message ..." class="form-control rounded"></textarea>
                                                <input type="hidden" value="" id="recipient" name="recipient">
                                                <input type="hidden" value="<?php echo (isset($_GET["ref"])) ? $_GET["ref"] : 0; ?>" id="refinput" name="ref">
                                                <input type="hidden" value="<?php echo (isset($_GET["reftyp"])) ? $_GET["reftyp"] : 0; ?>" id="reftypinput" name="reftyp">
                                                <span class="mt-4 ml-0">
                      <button type="submit" class="btn "><i class="text-info text-lg fa fa-paper-plane"></i></button>
                    </span>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.card-footer-->
                                </div>
                                <!--/.direct-chat -->
                            </div>
                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php// include "includes/footer.php";?>


        </div>
        <!-- ./wrapper -->
        <!-- REQUIRED SCRIPTS -->
        <?php include "includes/scripts.php";?>
        <script>
    function searchFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
    }
</script>
<script>
var objDiv = document.getElementById("btmScroll");
objDiv.scrollTop = objDiv.scrollHeight;
var elmnt = document.getElementById("chatfoot");
elmnt.scrollIntoView();
var reloadByOrid = "";
var ref_info = "";
var submitref = 0;
var loading = '<div class="d-flex mt-4 justify-content-center">\
				<div class="spinner-border text-info" role="status">\
					<span class="sr-only">Loading...</span>\
				  </div>\
				</div>\
				'; 				
</script> 
<?php if(isset($_GET["oid"])){?>
<script>
		var directTo = <?php echo mysqli_real_escape_string($conn, $_GET["oid"]);?>;
		
		if(screen.width < 768){
			var smallshow = document.getElementById("smallshow");
			smallshow.className = smallshow.className.replace(/\bd-none\b/g, "");
			$("#smallhide").fadeOut('fast');
			$("#smallshow").fadeIn();  
		  }
		  
		  var elmnt = document.getElementById("cardfooter");
		  elmnt.scrollIntoView();
		  
		  var chatOnSide = document.getElementById(directTo);
			$(chatOnSide).parent().addClass('bg-light'); 
		    $('#unr'+directTo).html("");
		  
		  $.ajax({  
                url:"processes/messagingprocesses.php",  
                method:"POST",  
                data:{topinfo:directTo},
				beforeSend:function(){  
					  $('.direct-chat-messages').html(loading);   
				 }, 
                success:function(data){  
                     $('#showtopinfo').html(data);  
                }  
           });  
		   var cardfooter = document.getElementById("cardfooter");
		   cardfooter.className = cardfooter.className.replace(/\binvisible\b/g, "");
		   document.getElementById('message').focus();
		   		   
		    $.ajax({  
                url:"processes/messagingprocesses.php",  
                method:"POST",  
                data:{chatarea:directTo},  
                success:function(data){ 
					$('.direct-chat-messages').html(data); 
					objDiv.scrollTop = objDiv.scrollHeight;
                }  
           });
		   
		    $.ajax({  
                url:"processes/messagingprocesses.php",  
                method:"POST",  
                data:{unreadstatus:directTo},  
                success:function(data){  
                     $('#recipient').val(directTo);  
                }  
           });
		   reloadByOrid = directTo;
</script>
<?php } ?>

<script >  
 $(document).ready(function(){  
      $('.msgexact').click(function(){  
          var orid = $(this).attr("id");
		  var ul = document.getElementById("myUL");
		  var li = ul.getElementsByTagName("li");
		  var unr = 'unr'+orid;
		  reloadByOrid = orid;
		  for (i = 0; i < li.length; i++) {
				li[i].className = li[i].className.replace(/\bbg-light\b/g, "");
		  }
		  $(this).parent().addClass('bg-light');
		  $('#'+unr).html("");
		  
		  if(submitref == 1){
            $(refbox).addClass('d-none'); 
            submitref = 0;
            adjustChatareaSize("400px");
          }

          $('#refinput').val("0");
          $('#reftypinput').val("0");

		  if(screen.width < 768){
			smallScreen();  
		  }
		  var elmnt = document.getElementById("cardfooter");
		  elmnt.scrollIntoView();
		  
		  $.ajax({  
                url:"processes/messagingprocesses.php",  
                method:"POST",  
                data:{topinfo:orid},
				beforeSend:function(){  
					  $('.direct-chat-messages').html(loading);   
				 }, 
                success:function(data){  
                     $('#showtopinfo').html(data);  
                }  
           });  
		   var cardfooter = document.getElementById("cardfooter");
		   cardfooter.className = cardfooter.className.replace(/\binvisible\b/g, "");
		   
		   
		   $.ajax({  
                url:"processes/messagingprocesses.php",  
                method:"POST",  
                data:{chatarea:orid},  
                success:function(data){  
                     $('.direct-chat-messages').html(data); 
					 objDiv.scrollTop = objDiv.scrollHeight;
                }  
           });
		   
		   $.ajax({  
                url:"processes/messagingprocesses.php",  
                method:"POST",  
                data:{unreadstatus:orid},  
                success:function(data){  
                     $('#recipient').val(orid); 
                }  
           });
      });  
 });  
 </script>
<script>
 $('#sendmessage').on("submit", function(event){ 
	newMessage();	  
   });  
 </script>
 <script>
 $('#message').on('keydown', function(e) {
  if (e.which == 13 && !e.shiftKey) {
    newMessage();
    return false;
  }
});
 </script>
 <script>
 function smallScreen() {
	 var smallshow = document.getElementById("smallshow");
	 smallshow.className = smallshow.className.replace(/\bd-none\b/g, "");
		$("#smallhide").fadeOut('fast');
		$("#smallshow").fadeIn();
		
 }
 </script>
<script>
 function newMessage() {
	event.preventDefault();
			
          var message = $('#sendmessage').serialize();
		  var text = $("#message").val();
		  if($.trim(text) == '') {
			  
		  }else{
              if(submitref == 0){

                  $('<div class="direct-chat-msg right">\
                    <div class="direct-chat-infos clearfix">\
                        <span class="direct-chat-name float-right">You</span>\
                        <span class="direct-chat-timestamp float-left"><?php echo date('d M h:i a', strtotime($date)); ?></span>\
                    </div>\
                    <!-- /.direct-chat-infos -->\
                    <img class="direct-chat-img" src="../img/userplaceholder.png" alt="user">\
                    <!-- /.direct-chat-img -->\
                    <div class="direct-chat-text">\
                        '+ text +'\
                    </div>\
                    <!-- /.direct-chat-text -->\
                </div>\
                <!-- /.direct-chat-msg -->\
            ').appendTo($('.direct-chat-messages')); 
              }else if(submitref == 1){
               
                $('<div class="direct-chat-msg right">\
                    <div class="direct-chat-infos clearfix">\
                        <span class="direct-chat-name float-right">You</span>\
                        <span class="direct-chat-timestamp float-left"><?php echo date('d M h:i a', strtotime($date)); ?></span>\
                    </div>\
                    <!-- /.direct-chat-infos -->\
                    <img class="direct-chat-img" src="../img/userplaceholder.png" alt="user">\
                    <!-- /.direct-chat-img -->\
                    <div class="direct-chat-text">\
                        '+ref_info +text +'\
                    </div>\
                    <!-- /.direct-chat-text -->\
                </div>\
                <!-- /.direct-chat-msg -->\
            ').appendTo($('.direct-chat-messages'));

            $(refbox).addClass('d-none'); 
            submitref = 0;
            adjustChatareaSize("400px");
              }    
				  
			  $('#message').val("");  
			  
				
            $('#myUL .bg-light .you ').html('<span>You: </span>' + text);
            objDiv.scrollTop = objDiv.scrollHeight;
            $('#myUL li:first').after($('#myUL .bg-light'));
            
				 
			  
			$.ajax({  
                url:"processes/messagingprocesses.php",  
                method:"POST",  
                data: message, 
                success:function(data){  
                }  
           }); 
		  }
};
 </script>
<script>
 function adjustChatareaSize(value) {
    $(".direct-chat-messages").css("min-height", value);
};
</script>
<script>
<?php if(isset($_GET["ref"])){?>
    adjustChatareaSize("347px");
    submitref = 1;
    var ref = <?php echo mysqli_real_escape_string($conn, $_GET["ref"]);?>;
    var reftyp = <?php echo mysqli_real_escape_string($conn, $_GET["reftyp"]);?>;
    var oid = <?php echo mysqli_real_escape_string($conn, $_GET["oid"]);?>;

    var refbox = document.getElementById("referenceBox");
    refbox.className = refbox.className.replace(/\bd-none\b/g, "");

    if(reftyp == 0){
        $('#reftask').html("Order Progress/Milestone");
        ref_info = '<div class="m-1 alert alert-info shadow">\
                        <span class="text-sm">@about: <a href="#">Order Progress/Milestone</a></span>\
                    </div>';

    }else if(reftyp == 1){
        $('#reftask').html("Final Submission");
        ref_info = '<div class="m-1 alert alert-info shadow">\
                        <span class="text-sm">@about: <a href="#">Final Submission</a></span>\
                    </div>';
    }else if(reftyp == 2){
        $('#reftask').html("Order Revision");
        ref_info = '<div class="m-1 alert alert-info shadow">\
                        <span class="text-sm">@about: <a href="#">Order Revision</a></span>\
                    </div>';
    }


<?php }else{ ?>
    adjustChatareaSize("400px");
<?php }?> 
</script>
<script >  
 $(document).ready(function(){  
      $('#refclose').click(function(){  
        adjustChatareaSize("400px");
        submitref = 0;
        $('#refinput').val("0");
        $('#reftypinput').val("0");
      });  
 });  
 </script>

 
 <script>
	//if(reloadByShid != ""){
		setInterval(updateChat, 5000);
		function updateChat() {
            $.ajax({  
					url:"processes/messagingprocesses.php",  
					method:"POST",  
					data:{reloadChats:reloadByOrid},
					dataType: "json",
					success:function(data){  
						if(data){
                            var pa = document.getElementById(data.order);
							var pali = $(pa).parent();
                            $('#myUL li:first').after(pali);

                            if(reloadByOrid == data.order){
								 $('#unr'+data.order).html(""); 
							 }else{
								 $('#unr'+data.order).html(data.count); 
							 }
							 $('#sidemessage'+data.order).html(data.message); 
                        }
					}  
			   });

            if(reloadByOrid == ""){
				
			}else{
			   				   
			   $.ajax({  
					url:"processes/messagingprocesses.php",  
					method:"POST",  
					data:{reloadByOrid:reloadByOrid},  
					success:function(data){  
						if(data){
                            //window.alert("data");
							$(data).appendTo($('.direct-chat-messages'));
							objDiv.scrollTop = objDiv.scrollHeight;
						}
					}  
			   });
			}

            if(navigator.onLine){
                $("#onlineNavigator").addClass('sr-only');
                if(screen.width < 768){
                $("#onlineNavigatorsm").addClass('sr-only'); 
                }
            }else{
            var offline = document.getElementById("onlineNavigator");
            offline.className = offline.className.replace(/\bsr-only\b/g, "");
            if(screen.width < 768){
                var offlinesm = document.getElementById("onlineNavigatorsm");
                offlinesm.className = offlinesm.className.replace(/\bsr-only\b/g, "");
                }
            }
            
		}
 </script>
<script>
  function backBtn() {
	 $('#smallshow').addClass('d-none');
		$("#smallshow").fadeOut('fast');
		$("#smallhide").fadeIn();
 }
 </script>
    </body>

    </html>