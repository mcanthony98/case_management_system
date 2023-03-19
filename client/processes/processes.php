<?php
session_start();
require "../../includes/connect.php";
date_default_timezone_set("Europe/London");
$date = date("Y-m-d H:i:s");

//Register
if(isset($_POST['register'])){
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
    $cpass = mysqli_real_escape_string($conn, $_POST["cpass"]);
    $counter = 0;
    $sms = "";

    if($pass != $cpass){
        $counter++;
        $sms = "Passwords do not match!"; 
    }

    $chkqry = "SELECT * FROM client WHERE email = '$email'";
    $chkres = $conn->query($chkqry);
    if($chkres->num_rows > 0){
        $counter++;
        $sms = "Email already exists. Use another email or Login!"; 
    }

    if($counter != 0){
        $_SESSION['error'] = $sms;
        header ("Location: ../register.php");
    }else{
        $encpass = md5($pass);
        $qry = "INSERT INTO client (firstname, lastname, email, phone, password, date_created) VALUES ('$fname', '$lname', '$email', '$phone', '$encpass', '$date')";

        $conn->query($qry);
        $_SESSION['clientID'] = $conn->insert_id;
        $_SESSION['success'] = "Logged in Successfully!";
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;

        header ("Location: ../cases.php");
    }

}
//Login
if(isset($_POST['login'])){
    $adm = mysqli_real_escape_string($conn, $_POST["adm"]);
    $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
    $encpass = md5($pass);

    $qry = "SELECT * FROM client WHERE email='$adm' AND password='$encpass'";
    $res = $conn->query($qry);
    if($res->num_rows == 0){
        $_SESSION['error'] = "Invalid Credentials!";
        header ("Location: ../index.php");

    }else{
        $row = $res->fetch_assoc();
        $_SESSION['success'] = "Logged in Successfully!";
        $_SESSION['clientID'] = $row['client_id'];
        $_SESSION['fname'] = $row['firstname'];
        $_SESSION['lname'] = $row['lastname'];
        header ("Location: ../cases.php");
    }
    exit();

//Logout
}elseif(isset($_GET['logout'])){
    session_destroy();
	session_start();
    $_SESSION["success"] = "Logged out successfully!";
	header('location: ../index.php');
    exit();
    
}
//Create New Case
elseif(isset($_POST['new-case'])){
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $desc = mysqli_real_escape_string($conn, $_POST["concept"]);
    $cat = mysqli_real_escape_string($conn, $_POST["cat"]);
    $set = '1234567890';
    $case_number = 'CASE'.substr(str_shuffle($set), 0, 4);
    $client = $_SESSION['clientID'];

    $qry = "INSERT INTO client_case(client_id, case_number, title, category_id, description, case_status, date_created) VALUES ('$client',  '$case_number', '$title', '$cat', '$desc', '0', '$date')";
    $conn->query($qry);
    $_SESSION["success"] = "Case Created Successfully!";
	header('location: ../cases.php');
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
?>