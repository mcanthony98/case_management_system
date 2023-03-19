<?php
if(!isset($_GET['class'])){
    header ("Location: classes.php");
	exit ();
}
$pg = 4;
include "includes/header.php";
include "../includes/connect.php";
include "includes/sessions.php";

$clid = $_GET['class'];
$clqry = "SELECT * FROM class WHERE class_id='$clid'";
$clres = $conn->query($clqry);
$clrow = $clres->fetch_assoc();

?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  

<?php
include "includes/navbar.php";
?>

  <!-- Main Sidebar Container -->
  <?php
include "includes/sidebar.php";
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $clrow['class_name']. " - ". $clrow['class_code'] ;?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Admin</a></li>
              <li class="breadcrumb-item"><a href="classes.php">Classes</a></li>
              <li class="breadcrumb-item active"><?php echo $clrow['class_name']. " - ". $clrow['class_code'] ;?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
                    <div class="container-fluid">
                        <!-- Default box -->
                        <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Enrolled Students</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Project Concepts</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Ongoing Projects</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Important Dates</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">

                <!--START OF TABS CONTENTS-->






                <!--Enrolled Students START-->
                <?php 
                $enrstdqry = "SELECT * FROM student_class JOIN student ON student_class.student_id=student.student_id WHERE student_class.class_id='$clid' ORDER BY student.firstname ASC";
                $enrstdres = $conn->query($enrstdqry);
                ?>
                  <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">


                  <button class="btn btn-sm btn-primary bg-gradient-primary mb-2" data-toggle="modal" data-target="#modal-new"><i class="fa fa-plus"></i>Enroll New Student</button>

                    <table id="example1" class="table table-bordered table-striped mt-2">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Adm. No.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($enrstdrow = $enrstdres->fetch_assoc()){?>
                            <tr>
                                <td><?php echo $enrstdrow['firstname']." ". $enrstdrow['lastname'];?></td>
                                <td><?php echo $enrstdrow['adm_no'];?></td>
                                <td class="text-nowrap">
                                    <a href="#<?php //echo $enrstdrow["class_id"];?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> </a>
                                    <a href="processes/processes.php?class=<?php echo $clid;?>&unenroll_student=<?php echo $enrstdrow["student_class_id"];?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                                
                  </div>
                  <!--Enrolled Students END-->






                  <!--Project Concepts START-->
                  <?php
                  $proconcqry = "SELECT * FROM project JOIN student_class ON project.student_class_id=student_class.student_class_id JOIN student ON student.student_id=student_class.student_id WHERE student_class.class_id='$clid'";
                  $proconcres = $conn->query($proconcqry);
                  ?>
                  <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  
                  
                  <table id="example2" class="table table-bordered table-striped mt-2">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Project Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($proconcrow = $proconcres->fetch_assoc()){?>
                            <tr>
                                <td><?php echo $proconcrow['firstname']." ". $proconcrow['lastname'];?><br><?php echo $proconcrow['adm_no'];?></td>
                                <td><?php echo $proconcrow['project_name'];?></td>
                                <td><span class="badge badge-secondary"><?php echo $proconcrow['concept_status'];?></span></td>
                                <td class="text-nowrap">
                                  <button class="btn btn-sm btn-primary bg-gradient-primary readconcept" id="<?php echo $proconcrow['concept'];?>" data-toggle="modal" data-target="#modal-read"><i class="fa fa-eye"></i></button>

                                  <a href="processes/processes.php?class=<?php echo $clid;?>&approveconcept=<?php echo $proconcrow["project_id"];?>" class="btn btn-sm btn-success"><i class="fas fa-check"></i> </a>

                                  <a href="processes/processes.php?class=<?php echo $clid;?>&rejectconcept=<?php echo $proconcrow["project_id"];?>" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>


                  </div>
                  <!--Project Concepts END-->








                  <!--Ongoing Projects START-->
                  <?php
                  $onproqry = "SELECT * FROM project JOIN student_class ON project.student_class_id=student_class.student_class_id JOIN student ON student.student_id=student_class.student_id WHERE student_class.class_id='$clid' AND project.concept_status='Approved'";
                  $onprores = $conn->query($onproqry);
                  ?>
                  <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                  
                  <table id="example12" class="table table-bordered table-striped mt-2">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Project Name</th>
                                <th>Supervisor</th>
                                <th>Status</th>
                                <th style="width:50px">Grade</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($onprorow = $onprores->fetch_assoc()){
                              $projid = $onprorow['project_id'];
                              $supqry = "SELECT * FROM supervision JOIN lecturer ON supervision.lecturer_id=lecturer.lecturer_id WHERE supervision.project_id='$projid'";
                              $supres = $conn->query($supqry);
                              if($supres->num_rows == 0){
                                $first = '<option>Not Allocated</option>';
                              }else{
                                $suprow = $supres->fetch_assoc();
                                $first = '<option value="'.$suprow['lecturer_id'].'">'.$suprow['firstname'].' '.$suprow['lastname'].'</option>';
                              }
                              
                            ?>
                            <tr>
                                <td><?php echo $onprorow['firstname']." ". $onprorow['lastname'];?><br><?php echo $onprorow['adm_no'];?></td>
                                <td><?php echo $onprorow['project_name'];?></td>
                                <td>
                                  <form method="post" action="processes/processes.php">

                                    <select class="form-control" name='lec' onChange="this.form.submit()" required>
                                      
                                      <?php
                                      echo $first;
                                      $alllecsres = $conn->query("SELECT * FROM lecturer");
                                      while($alllecrow = $alllecsres->fetch_assoc()){
                                        echo '<option value="'.$alllecrow['lecturer_id'].'">'.$alllecrow['firstname'].' '.$alllecrow['lastname'].'</option>';
                                      }
                                      
                                      ?>
                                    </select>

                                    <input type="hidden" name="allocate_supervisor" value="<?php echo $projid;?>">
                                    <input type="hidden" name="clid" value="<?php echo $clid;?>">
                                  </form>
                                </td>
                                <td><span class="badge badge-secondary"><?php echo $onprorow['project_status'];?></span></td>
                                <td>
                                    <form method="post" action="processes/processes.php">
                                      <input type="number" class="form-control" name="grade" value="<?php echo $onprorow['grade'];?>" required onblur="this.form.submit()">
                                      <input type="hidden" name="grade_project" value="<?php echo $projid;?>">
                                      <input type="hidden" name="clid" value="<?php echo $clid;?>">
                                    </form>
                                </td>
                                <td class="text-nowrap">
                                  
                                  <a href="project.php?project=<?php echo $onprorow["project_id"];?>" class="btn btn-sm btn-primary bg-gradient-primary"><i class="fas fa-eye"></i> </a>

                                  
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>


                  </div>
                  <!--Ongoing Projects END-->







                  <!--Important Dates START-->
                  <?php
                  $evqry = "SELECT * FROM class_dates WHERE class_id='$clid'";
                  $evres = $conn->query($evqry);
                  ?>
                  <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                  
                  <button class="btn btn-sm btn-primary bg-gradient-primary mb-2" data-toggle="modal" data-target="#modal-newevent"><i class="fa fa-plus"></i> New Event</button>

                  <table id="example13" class="table table-bordered table-striped mt-2">
                      <thead>
                          <tr>
                              <th>Event Name</th>
                              <th>Date</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php while($evrow = $evres->fetch_assoc()){?>
                          <tr>
                              <td><?php echo $evrow['event_name'];?></td>
                              <td><?php echo date('d M Y H:m', strtotime($evrow['event_date']));?></td>
                              <td class="text-nowrap">
                                  <!--<button class="btn btn-sm btn-info editstd" id="<?php echo $evrow['class_date_id'];?>" data-toggle="modal" data-target="#modal-editevent"><i class="fas fa-edit"></i> </button>
                                  <a href="processes/processes.php?delete_event=<?php echo $evrow["class_date_id"];?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> </a>-->
                                  <button class="btn btn-sm btn-info " id="<?php echo $evrow['class_date_id'];?>" data-toggle="modal" data-target="#modal-editevent"><i class="fas fa-edit"></i> </button>
                                  <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> </a>
                              </td>
                          </tr>
                          <?php } ?>
                      </tbody>
                  </table>
                  </div>
                  <!--Important Dates END-->











                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.card -->

                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
include "includes/footer.php";
?>

 
</div>
<!-- ./wrapper -->


<!--MODALS-->
<div class="modal fade" id="modal-new">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Enroll New Student</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form method="post" action="processes/processes.php">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Student</label>
                    <select class="form-control"  name="std" required>
                        <option>Choose a Student...</option>
                        <?php 
                        $allstdres = $conn->query("SELECT * FROM student");
                        while($allstdrow = $allstdres->fetch_assoc()){
                            echo '<option value="'.$allstdrow['student_id'].'">'.$allstdrow['firstname'].' '.$allstdrow['lastname'].' - '.$allstdrow['adm_no'].'</option>';
                        }
                        
                        ?>
                    </select>
                  </div>
                </div>
                <input type="hidden"  name="classid" value="<?php echo $clid;?>" required>
                

              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="enroll-new-std-to-class" class="btn btn-primary">Submit</button>
            </div>
          </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->



      <div class="modal fade" id="modal-newevent">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create New Event</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form method="post" action="processes/processes.php">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Event Name</label>
                    <input class="form-control" placeholder="Event Name" name="ename" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Event Date</label>
                    <input class="form-control" type="datetime-local" placeholder="" name="edate" required>
                  </div>
                </div>

                <input type="hidden"  name="classid" value="<?php echo $clid;?>" required>

              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="new-event" class="btn btn-primary">Submit</button>
            </div>
          </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->




      <div class="modal fade" id="modal-read">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Project Concept</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form method="post" action="processes/processes.php">
            <div class="modal-body">
              <p id="conceptshow"></p>
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="enroll-new-std-to-class" class="btn btn-primary">Submit</button>
            </div>
          </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->




<?php
include "includes/scripts.php";
?>

<script >  
 $(document).ready(function(){  
      $('.readconcept').click(function(){  
          var concept = $(this).attr("id");
          $('#conceptshow').html(concept);
          /*$.ajax({  
                  url:"processes/processes.php",  
                  method:"POST",  
                  data:{fetch_single_class:clid}, 
                  dataType: 'json',
                  success:function(data){
                    $('#name').val(data.class_name);
                    $('#code').val(data.class_code);
                    $('#classid').val(data.class_id);
                  }  
          }); */
		  
      });  
 });  
 </script>

</body>
</html>
