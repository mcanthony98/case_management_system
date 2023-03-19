<?php
session_start();
require "../../includes/connect.php";
date_default_timezone_set("Africa/Nairobi");
$date = date("Y-m-d H:i:s");


//Login Page
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
    $encpass = md5($pass);

    $qry = "SELECT * FROM admin WHERE email='$email' AND password='$encpass'";
    $res = $conn->query($qry);
    if($res->num_rows == 0){
        $_SESSION['error'] = "Invalid Credentials!";
        header ("Location: ../index.php");
    }else{
        $row = $res->fetch_assoc();
        $_SESSION['success'] = "Logged in Successfully!";
        $_SESSION['adminid'] = $row['admin_id'];
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
//Student Operations (CRUD)
elseif(isset($_POST['new-student'])){
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $adm = mysqli_real_escape_string($conn, $_POST["adm"]);
    $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
    $encpass = md5($pass);

    $qry = "INSERT INTO student(firstname, lastname, adm_no, password, st_date_created) VALUES ('$fname', '$lname', '$adm', '$encpass','$date')";
    $conn->query($qry);
    $_SESSION["success"] = "Student Added Successfully!";
	header('location: ../students.php');
    exit();

}elseif(isset($_POST['fetch_single_student'])){
    $id = mysqli_real_escape_string($conn, $_POST["fetch_single_student"]);

    $qry = "SELECT * FROM student WHERE student_id='$id'";
    $res = $conn->query($qry);
    $row = $res->fetch_assoc();

    echo json_encode($row);
}elseif(isset($_POST['edit-student'])){
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $adm = mysqli_real_escape_string($conn, $_POST["adm"]);
    $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
    $studid = mysqli_real_escape_string($conn, $_POST["stid"]);
    $encpass = md5($pass);

    $qry = "UPDATE student SET firstname='$fname', lastname='$lname', adm_no='$adm', password='$encpass' WHERE student_id='$studid'";
    $conn->query($qry);
    $_SESSION["success"] = "Student Details Updated Successfully!";
	header('location: ../students.php');
    exit();

}elseif(isset($_GET['delete_student'])){
    $studid = mysqli_real_escape_string($conn, $_GET["delete_student"]);

    $qry = "DELETE FROM student WHERE student_id='$studid'";
    $conn->query($qry);

    $_SESSION["success"] = "Student Deleted Successfully!";
	header('location: ../students.php');
    exit();
}


//Lecturer Operations (CRUD)
elseif(isset($_POST['new-lec'])){
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $adm = mysqli_real_escape_string($conn, $_POST["email"]);
    $cat = mysqli_real_escape_string($conn, $_POST["cat"]);
    $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
    $encpass = md5($pass);

    $qry = "INSERT INTO lawyer(firstname, lastname, email, password, category_id) VALUES ('$fname', '$lname', '$adm', '$encpass', '$cat')";
    $conn->query($qry);
    $_SESSION["success"] = "Lawyer Added Successfully!";
	header('location: ../lawyers.php');
    exit();

}elseif(isset($_POST['fetch_single_lec'])){
    $id = mysqli_real_escape_string($conn, $_POST["fetch_single_lec"]);

    $qry = "SELECT * FROM lecturer WHERE lecturer_id='$id'";
    $res = $conn->query($qry);
    $row = $res->fetch_assoc();

    echo json_encode($row);
}elseif(isset($_POST['edit-lec'])){
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
    $lecid = mysqli_real_escape_string($conn, $_POST["lecid"]);
    $encpass = md5($pass);

    $qry = "UPDATE lecturer SET firstname='$fname', lastname='$lname', email='$email', password='$encpass' WHERE lecturer_id='$lecid'";
    $conn->query($qry);
    $_SESSION["success"] = "Lecturer Details Updated Successfully!";
	header('location: ../lecturers.php');
    exit();

}elseif(isset($_GET['delete_lec'])){
    $lecid = mysqli_real_escape_string($conn, $_GET["delete_lec"]);

    $qry = "DELETE FROM lecturer WHERE lecturer_id='$lecid'";
    $conn->query($qry);

    $_SESSION["success"] = "Lecturer Deleted Successfully!";
	header('location: ../lecturers.php');
    exit();
}

//Class Operations (CRUD)
elseif(isset($_POST['new-class'])){
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $code = mysqli_real_escape_string($conn, $_POST["code"]);

    $qry = "INSERT INTO class(class_name, class_code, cl_date_created) VALUES ('$name', '$code', '$date')";
    $conn->query($qry);
    $_SESSION["success"] = "Class Added Successfully!";
	header('location: ../classes.php');
    exit();

}elseif(isset($_POST['fetch_single_class'])){
    $id = mysqli_real_escape_string($conn, $_POST["fetch_single_class"]);

    $qry = "SELECT * FROM class WHERE class_id='$id'";
    $res = $conn->query($qry);
    $row = $res->fetch_assoc();

    echo json_encode($row);
}elseif(isset($_POST['edit-class'])){
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $code = mysqli_real_escape_string($conn, $_POST["code"]);
    $classid = mysqli_real_escape_string($conn, $_POST["classid"]);

    $qry = "UPDATE class SET class_name='$name', class_code='$code' WHERE class_id='$classid'";
    $conn->query($qry);
    $_SESSION["success"] = "Class Details Updated Successfully!";
	header('location: ../classes.php');
    exit();

}elseif(isset($_GET['delete_class'])){
    $clid = mysqli_real_escape_string($conn, $_GET["delete_class"]);

    $qry = "DELETE FROM class WHERE class_id='$clid'";
    $conn->query($qry);

    $_SESSION["success"] = "Class Deleted Successfully!";
	header('location: ../classes.php');
    exit();
}

//Enroll student to class
elseif(isset($_POST['enroll-new-std-to-class'])){
    $std = mysqli_real_escape_string($conn, $_POST["std"]);
    $class = mysqli_real_escape_string($conn, $_POST["classid"]);

    $chkqry = "SELECT * FROM student_class WHERE student_id='$std' AND class_id='$class'";
    $chkres = $conn->query($chkqry);
    if($chkres->num_rows > 0){
        $_SESSION["error"] = "Student Already Exists!";
    }else{
        $qry = "INSERT INTO student_class (student_id, class_id, sc_date_created) VALUES ('$std', '$class', '$date')";
        $conn->query($qry);
        $_SESSION["success"] = "Student Added to Class Successfully!";
    }
    
	header('location: ../class.php?class='.$class);
    exit();

}

//Unenroll Stuent FRom Class
elseif(isset($_GET['unenroll_student'])){
    $clid = mysqli_real_escape_string($conn, $_GET["class"]);
    $scid = mysqli_real_escape_string($conn, $_GET["unenroll_student"]);

    $qry = "DELETE FROM student_class WHERE student_class_id='$scid'";
    $conn->query($qry);

    $_SESSION["success"] = "Student Removed Successfully!";
	header('location: ../class.php?class='.$clid);
    exit();
}

//Approve Project Concept
elseif(isset($_GET['approveconcept'])){
    $clid = mysqli_real_escape_string($conn, $_GET["class"]);
    $pid = mysqli_real_escape_string($conn, $_GET["approveconcept"]);

    $qry = "UPDATE project SET concept_status='Approved', project_status='Ongoing' WHERE project_id='$pid'";
    $conn->query($qry);

    $_SESSION["success"] = "Project Approved Successfully!";
	header('location: ../class.php?class='.$clid);
    exit();
}

//Reject Project Concept
elseif(isset($_GET['rejectconcept'])){
    $clid = mysqli_real_escape_string($conn, $_GET["class"]);
    $pid = mysqli_real_escape_string($conn, $_GET["rejectconcept"]);

    $qry = "UPDATE project SET concept_status='Rejected' WHERE project_id='$pid'";
    $conn->query($qry);

    $_SESSION["success"] = "Project Rejection Successfully!";
	header('location: ../class.php?class='.$clid);
    exit();
}

//Allocate Supervisor
elseif(isset($_POST['allocate_supervisor'])){
    $lec = mysqli_real_escape_string($conn, $_POST["lec"]);
    $pid = mysqli_real_escape_string($conn, $_POST["allocate_supervisor"]);
    $clid = mysqli_real_escape_string($conn, $_POST["clid"]);

    $chksupqry = "SELECT * FROM supervision WHERE project_id='$pid'";
    $chksupres = $conn->query($chksupqry);
    if($chksupres->num_rows == 0){
        $qry = "INSERT INTO supervision (project_id, lecturer_id) VALUES ('$pid', '$lec')";
    }else{
        $qry = "UPDATE supervision SET lecturer_id='$lec' WHERE project_id='$pid'";
    }
    
    $conn->query($qry);

    //Start a new chat
    $text = "Hello, I am your supervisor for this project. Check the Project Details. Let's talk about the project here. ";
    $type = 0;
    $notif_qry = "INSERT INTO project_messages (project_id, msg_type, message, date_sent) VALUES ('$pid', '$type', '$text', '$date')";
    $notif_res = $conn->query($notif_qry);

    $_SESSION["success"] = "Supervisor Allocated Successfully!";
	header('location: ../class.php?class='.$clid);
    exit();
}

//Grading a Project
elseif(isset($_POST['grade_project'])){
    $grade = mysqli_real_escape_string($conn, $_POST["grade"]);
    $pid = mysqli_real_escape_string($conn, $_POST["grade_project"]);
    $clid = mysqli_real_escape_string($conn, $_POST["clid"]);


    $chksupqry = "SELECT * FROM project WHERE project_id='$pid' AND project_status='Completed'";
    $chksupres = $conn->query($chksupqry);
    if($chksupres->num_rows == 0){
        $_SESSION["error"] = "Project is not complete yet!";
    }else{
        $qry = "UPDATE project SET grade='$grade' WHERE project_id='$pid'";
        $conn->query($qry);
        $_SESSION["success"] = "Project Graded Successfully!";
    }
    
    
	header('location: ../class.php?class='.$clid);
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


//New Event
elseif(isset($_POST['new-event'])){
    $ename = mysqli_real_escape_string($conn, $_POST["ename"]);
    $edate = mysqli_real_escape_string($conn, $_POST["edate"]);
    $clid = mysqli_real_escape_string($conn, $_POST["classid"]);

    $qry = "INSERT INTO class_dates (class_id, event_name, event_date) VALUES ('$clid', '$ename', '$edate')";
    $conn->query($qry);
    $_SESSION["success"] = "Event Created Successfully!";
	header('location: ../class.php?class='.$clid);
    exit();

}
?>