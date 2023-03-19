<?php
session_start();
require "../../includes/connect.php";
date_default_timezone_set("Africa/Nairobi");
$date = date("Y-m-d H:i:s");

//Login
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
    $encpass = md5($pass);

    $qry = "SELECT * FROM lawyer WHERE email='$email' AND password='$encpass'";
    $res = $conn->query($qry);
    if($res->num_rows == 0){
        $_SESSION['error'] = "Invalid Credentials!";
        header ("Location: ../index.php");
    }else{
        $row = $res->fetch_assoc();
        $_SESSION['success'] = "Logged in Successfully!";
        $_SESSION['lecturerid'] = $row['lawyer_id'];
        $_SESSION['fname'] = $row['firstname'];
        $_SESSION['lname'] = $row['lastname'];
        header ("Location: ../dashboard.php");
    }
    exit();

}

//Logout
elseif(isset($_GET['logout'])){
    session_destroy();
	session_start();
    $_SESSION["success"] = "Logged out successfully!";
	header('location: ../index.php');
    exit();
    
}

//takecase
elseif(isset($_GET['takecase'])){
    $caseid = mysqli_real_escape_string($conn, $_GET["takecase"]);
    $lawyerid = $_SESSION['lecturerid'];
    $type = 0;
    $text = "Hello, I have been assigned to this/your case.";

    $qry = "INSERT INTO lawyer_case (lawyer_id, case_id) VALUES ('$lawyerid', '$caseid')";
    $conn->query($qry);

    $updqry = "UPDATE client_case SET case_status = 1 WHERE case_id = '$caseid'";
    $conn->query($updqry);

    $smsqry = "INSERT INTO project_messages (project_id, msg_type, message, date_sent) VALUES ('$caseid', '$type', '$text', '$date')";
    $conn->query($smsqry);

    header('location: ../case.php?case='.$caseid);
    exit();


}

//New Progress
elseif(isset($_POST['new-progress'])){
    $sub = mysqli_real_escape_string($conn, $_POST["subject"]);
    $proj = mysqli_real_escape_string($conn, $_POST["prid"]);
    $desc = mysqli_real_escape_string($conn, $_POST["desc"]);

    $qry = "INSERT INTO progress(case_id, pr_title, pr_description, date_created) VALUES ('$proj', '$sub', '$desc', '$date')";
    $conn->query($qry);
    $_SESSION["success"] = "Activity Created Successfully!";
	header('location: ../case.php?case='.$proj);
    exit();

}

//New Progress file
elseif(isset($_POST['progfile'])){
    $caseid = mysqli_real_escape_string($conn, $_POST["prid"]);
    $prog = mysqli_real_escape_string($conn, $_POST["progfile"]);

    $image = $_FILES['photos']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));
    
    date_default_timezone_set("Europe/London");
    $ddate = date("Y_m_d_H_i_s");	
    $thisdate = date("Y-m-d H:i:s");
    
    $file_name = $_FILES["photos"]["name"];
    $_FILES["photos"]["type"];
    $tmp_file = $_FILES["photos"]["tmp_name"];
    
    $destination = "../../files/" . $file_name;
    
    move_uploaded_file($tmp_file, $destination);
    $new = $ddate.$file_name;
    $new_name = rename('../../files/'.$file_name , '../../files/'.$new);
    
    if($new_name === TRUE){
        $qry = "INSERT INTO progress_files (file_name, progress_id) VALUES ('$new', '$prog')";
        $res = $conn->query($qry);
        if($res === TRUE){
            $_SESSION['success'] = "File Uploaded Successfully!";
        }else{
            $_SESSION['error'] = "An error occured! Try Again!";
        }
    }else{
        $_SESSION['error'] = "An error occured! Try Again";
    }

    header('location: ../case.php?case='.$caseid);
    exit();
}

//New progress comment
elseif(isset($_POST['new-progress-comment'])){
    $prog = mysqli_real_escape_string($conn, $_POST["progid"]);
    $proj = mysqli_real_escape_string($conn, $_POST["prid"]);
    $comm = mysqli_real_escape_string($conn, $_POST["comm"]);

    $qry = "UPDATE progress SET progress_comment='$comm' WHERE progress_id='$prog'";
    $conn->query($qry);
    $_SESSION["success"] = "Progress Comment Successfully!";
	header('location: ../project.php?project='.$proj);
    exit();

}	

//Complete Project
elseif(isset($_POST['project_complete'])){
    $proj = mysqli_real_escape_string($conn, $_POST["prid"]);
    $ocomm = mysqli_real_escape_string($conn, $_POST["ocomm"]);


    $qry = "UPDATE project SET project_comment='$ocomm', date_completed='$date', project_status='Completed' WHERE project_id='$proj'";
    $conn->query($qry);
    $_SESSION["success"] = "Project Completed Successfully!";
	header('location: ../project.php?project='.$proj);
    exit();

}	
?>