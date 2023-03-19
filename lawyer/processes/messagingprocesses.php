<?php 
session_start();	
include "../../includes/connect.php";
include "../includes/sessions.php";
date_default_timezone_set("Africa/Nairobi");
$date = date("Y-m-d H:i:s");

if(isset($_POST["topinfo"])){
    $orid = mysqli_real_escape_string($conn, $_POST["topinfo"]);

        $qry = "SELECT * FROM client_case WHERE case_id='$orid'";
        $res = $conn->query($qry);
        $row = $res->fetch_assoc();
        
        echo '
        <div class="d-flex flex-row">
        <a href="javascript:void(0)" class="font-weight-normal mt-2 border-right d-md-none" id="back-btn"><i class="mr-1 text-lg text-info fas fa-arrow-left"></i></a>
        <a class="text-dark" target=_blank>
        <img class="pl-1 direct-chat-img" src="../img/orderplaceholder.png" alt="ORDER"> 
        <span class="mt-1">'.$row["case_number"].' - '.$row["title"].'</span>
        </a>
        </div>
              
              <script>
                  $(document).ready(function(){   
                      $(\'#back-btn\').click(function(){
                            backBtn();
                      });  
                 }); 
                 
                 
                 </script>
        ';
    
}
elseif(isset($_POST["chatarea"])){
		
    $orid = mysqli_real_escape_string($conn, $_POST["chatarea"]);
    $output = "";
        
    $qry = "SELECT * FROM project_messages JOIN client_case ON client_case.case_id=project_messages.project_id JOIN client ON client.client_id=client_case.client_id WHERE project_messages.project_id = '$orid' ORDER BY proj_msg_id ASC";
    
    
    $res = $conn->query($qry);
    
    while($row = $res->fetch_assoc()){
        $grey_ref = '';
        $info_ref = '';


        if($row["ref_id"] != 0){
            $refqry = "SELECT * FROM msg_references WHERE ref_id=".$row["ref_id"];
            $refres = $conn->query($refqry);
            $refrow = $refres->fetch_assoc();
            
            if($row["msg_type"] == 0){
                if($refrow["ref_type"] == 0){
                    $info_ref = '<div class="m-1 alert alert-info shadow">
                                    <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'" target=_blank>Order Progress/Milestone</a></span>
                                </div>';    
                }elseif($refrow["ref_type"] == 1){
                    $info_ref = '<div class="m-1 alert alert-info shadow">
                                    <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'#order-submission" target=_blank>Final Submission</a></span>
                                </div>';  
                }elseif($refrow["ref_type"] == 2){
                    $info_ref = '<div class="m-1 alert alert-info shadow">
                                   <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'#revision" target=_blank>Order Revision</a></span>
                                </div>';  
                }
            }elseif($row["msg_type"] == 1){
                if($refrow["ref_type"] == 0){
                    $grey_ref = '<div class="m-1 alert alert-grey shadow">
                                    <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'" target=_blank >Progress submission</a></span>
                                </div>'; 
                }elseif($refrow["ref_type"] == 1){
                    $$grey_ref = '<div class="m-1 alert alert-grey shadow">
                                    <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'#order-submission" target=_blank>Order Submission</a></span>
                                </div>';  
                }elseif($refrow["ref_type"] == 2){
                    $$grey_ref = '<div class="m-1 alert alert-grey shadow">
                                   <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'#revision" target=_blank>Order Revision</a></span>
                                </div>';  
                }
            }
            
        }


        if($row["msg_type"] == 0){
            if($row['msg_status'] == 0){
                $readstatus = '<span class="text-xs font-weight-light pt-2 float-right"><i class="fas fa-check"></i> Sent</span>';
            }elseif($row['msg_status'] == 1){
                $readstatus = '<span class="text-xs font-weight-light pt-2 float-right"><i class="fas fa-check-double"></i> Read</span>';
            }

            $output .= '
                 <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-right">You</span>
                        <span class="direct-chat-timestamp float-left">'.date('d M h:i a', strtotime($row['date_sent'])).'</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="../img/userplaceholder.png" alt="user">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        '.$info_ref.'
                        '.$row["message"].'
                        '.$readstatus.'
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->
            ';
        }elseif($row["msg_type"] == 1){
            $output .= '
            <div class="direct-chat-msg">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">'.$row["firstname"].' '.$row["lastname"].'</span>
                    <span class="direct-chat-timestamp float-right">'.date('d M h:i a', strtotime($row['date_sent'])).'</span>
                </div>
                <!-- /.direct-chat-infos -->
                <img class="direct-chat-img" src="../img/userplaceholder.png" alt="message user image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    '.$grey_ref.'
                    '.$row["message"].'
                </div>
                <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->
            ';
        }
    }
    
    echo $output;
}
elseif(isset($_POST["unreadstatus"])){
    $orid = mysqli_real_escape_string($conn, $_POST["unreadstatus"]);
    
    $qry = "UPDATE project_messages SET msg_status=1 WHERE project_id='$orid' AND msg_status=0 AND msg_type=1";
       
    if($conn->query($qry) === TRUE){
        //echo "walalalal";
    }
}
elseif(isset($_POST["recipient"])){
    $text = mysqli_real_escape_string($conn, $_POST["message"]);
    $orid = mysqli_real_escape_string($conn, $_POST["recipient"]);
    $ref = mysqli_real_escape_string($conn, $_POST["ref"]);
    $reftyp = mysqli_real_escape_string($conn, $_POST["reftyp"]);
    $type = 0;
    if($ref == 0){
        $qry = "INSERT INTO project_messages (project_id, msg_type, message, date_sent) VALUES ('$orid', '$type', '$text', '$date')";
    }else{
        $refqry = "INSERT INTO msg_references (ref_type, referenced_id) VALUES ('$reftyp', '$ref')";
        if($conn->query($refqry) === TRUE){
            $ref_id = $conn->insert_id;
            $qry = "INSERT INTO order_messages (order_id, msg_type, message, ref_id, date_sent) VALUES ('$orid', '$type', '$text', '$ref_id', '$date')";
        }
    }
    
    
    if($conn->query($qry) === TRUE){
        
    }
    //echo "walalalalmy";
}
elseif(isset($_POST["mileref"])){
    $ref = mysqli_real_escape_string($conn, $_POST["mileref"]);

    $res = $conn->query("SELECT task FROM job_milestones WHERE milestone_id='$ref'");
    $row = $res->fetch_assoc();
    echo $row["task"];
}


elseif(isset($_POST["reloadChats"])){
    //$ref = mysqli_real_escape_string($conn, $_POST["reloadChats"]);
    //echo "dfdfdf";
    $date_now = new DateTime($date);
    $date_ago = $date_now->getTimestamp() - 5;
    $date_ago = date("Y-m-d H:i:s",$date_ago);
    //echo json_encode($date_ago);
    $res = $conn->query("SELECT *, COUNT(case when project_messages.msg_status=0 AND project_messages.msg_type=1 then   project_messages.msg_status end) AS unreadmessages FROM project_messages JOIN client_case ON client_case.case_id=project_messages.project_id JOIN lawyer_case ON lawyer_case.case_id=client_case.case_id WHERE lawyer_case.lawyer_id='$lecID' AND project_messages.date_sent >= '$date_ago' AND project_messages.msg_status=0 AND project_messages.msg_type=1 GROUP BY project_messages.project_id ORDER BY MAX(project_messages.proj_msg_id) ");
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            $ord = $row["project_id"];
            $last_sms_qry = "SELECT * FROM project_messages WHERE project_id='$ord' AND msg_type=1 ORDER BY proj_msg_id DESC LIMIT 1";
            $last_sms_res = $conn->query($last_sms_qry);
            $last_sms_row = $last_sms_res->fetch_assoc();
            
            //$output['time'] = $date_ago;
            $output['order'] = $row["project_id"];
            $output['count'] = $row["unreadmessages"];
            $output['message'] = $last_sms_row["message"];
			
        }
        echo json_encode($output); 
    }
}
elseif(isset($_POST["reloadByOrid"])){
    $orid = mysqli_real_escape_string($conn, $_POST["reloadByOrid"]);
    $output = "";
    $date_now = new DateTime($date);
    $date_ago = $date_now->getTimestamp() - 5;
    $date_ago = date("Y-m-d H:i:s",$date_ago);

    $qry = "SELECT * FROM project_messages JOIN client_case ON client_case.case_id=project_messages.project_id JOIN client ON client.client_id=client_case.client_id WHERE project_messages.project_id = '$orid' AND project_messages.date_sent >= '$date_ago' AND project_messages.msg_type=1 ORDER BY proj_msg_id ASC";
    
    
    $res = $conn->query($qry);
    
    while($row = $res->fetch_assoc()){
        $grey_ref = '';
        $info_ref = '';
        if($row["ref_id"] != 0){
            $refqry = "SELECT * FROM msg_references WHERE ref_id=".$row["ref_id"];
            $refres = $conn->query($refqry);
            $refrow = $refres->fetch_assoc();
            
            if($row["msg_type"] == 0){
                if($refrow["ref_type"] == 0){
                    $info_ref = '<div class="m-1 alert alert-info shadow">
                                    <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'" target=_blank >Order Progress/Milestone</a></span>
                                </div>';    
                }elseif($refrow["ref_type"] == 1){
                    $info_ref = '<div class="m-1 alert alert-info shadow">
                                    <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'#order-submission" target=_blank >Final Submission</a></span>
                                </div>';  
                }elseif($refrow["ref_type"] == 2){
                    $info_ref = '<div class="m-1 alert alert-info shadow">
                                   <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'#revision" target=_blank >Order Revision</a></span>
                                </div>';  
                }
            }elseif($row["msg_type"] == 1){
                if($refrow["ref_type"] == 0){
                    $grey_ref = '<div class="m-1 alert alert-grey shadow">
                                    <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'" target=_blank>Progress submission</a></span>
                                </div>'; 
                }elseif($refrow["ref_type"] == 1){
                    $$grey_ref = '<div class="m-1 alert alert-grey shadow">
                                    <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'#order-submission" target=_blank >Order Submission</a></span>
                                </div>';  
                }elseif($refrow["ref_type"] == 2){
                    $$grey_ref = '<div class="m-1 alert alert-grey shadow">
                                   <span class="text-sm">@about: <a href="order.php?job='.$row["job_id"].'#revision" target=_blank >Order Revision</a></span>
                                </div>';  
                }
            }
            
        }


        if($row["msg_type"] == 0){
            $output .= '
                 <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-right">You</span>
                        <span class="direct-chat-timestamp float-left">'.date('d M h:i a', strtotime($row['date_sent'])).'</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="../img/userplaceholder.png" alt="user">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        '.$info_ref.'
                        '.$row["message"].'
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->
            ';
        }elseif($row["msg_type"] == 1){
            $output .= '
            <div class="direct-chat-msg">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">'.$row["firstname"].' '.$row["lastname"].'</span>
                    <span class="direct-chat-timestamp float-right">'.date('d M h:i a', strtotime($row['date_sent'])).'</span>
                </div>
                <!-- /.direct-chat-infos -->
                <img class="direct-chat-img" src="../img/userplaceholder.png" alt="message user image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    '.$grey_ref.'
                    '.$row["message"].'
                </div>
                <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->
            ';
        }
    }
    
    echo $output;

    $uqry = "UPDATE project_messages SET msg_status=1 WHERE project_id='$orid' AND msg_status=0 AND msg_type=1";
       
    if($conn->query($uqry) === TRUE){
        //echo "walalalal";
    }

}
?>