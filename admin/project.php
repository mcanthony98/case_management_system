<?php
if(!isset($_GET['project'])){
    header ("Location: classes.php");
	exit ();
}
$pg = 4;
include "includes/header.php";
include "../includes/connect.php";
include "includes/sessions.php";

$prid = $_GET['project'];
$proqry = "SELECT * FROM project JOIN student_class ON project.student_class_id=student_class.student_class_id JOIN class ON student_class.class_id=class.class_id JOIN supervision ON supervision.project_id=project.project_id JOIN student ON student.student_id=student_class.student_id WHERE project.project_id='$prid'";
$prores = $conn->query($proqry);
$prorow = $prores->fetch_assoc();

$supqry = "SELECT * FROM supervision JOIN lecturer ON supervision.lecturer_id=lecturer.lecturer_id WHERE supervision.project_id='$prid'";
$supres = $conn->query($supqry);
$suprow = $supres->fetch_assoc();

$progqry = "SELECT * FROM progress WHERE project_id='$prid'";
$progres = $conn->query($progqry);

$counter = 0;
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
            <h1 class="m-0">Project Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Admin</a></li>
              <li class="breadcrumb-item"><a href="classes.php">Projects</a></li>
              <li class="breadcrumb-item active">Project Details</li>
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
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="text-bold">Project: </span>
                                        <span><?php echo $prorow['project_name'];?></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-bold">Student: </span>
                                        <span><?php echo $prorow['firstname'] . ' '. $prorow['lastname'];?></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-bold">Supervisor: </span>
                                        <span><?php echo $suprow['firstname'] . ' '. $suprow['lastname'];?></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-bold">Status: </span>
                                        <span class="badge badge-secondary"><?php echo $prorow['project_status'];?></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-bold">Class: </span>
                                        <span><?php echo $prorow['class_code'] . ' - '. $prorow['class_name'];?></span>
                                    </div>

                                </div>

                                
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer justify-content-between">
                                <button class="btn btn-sm btn-primary bg-gradient-primary readconcept" id="<?php echo $proconcrow['concept'];?>" data-toggle="modal" data-target="#modal-read">View Concept</button>
                                <?php if($prorow['project_status'] != 'Completed'){?>
                                <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modal-complete">Set as Complete</button>
                                <?php } ?>
                            </div>

                        </div>
                        <!-- /.card -->


                        <?php while($progrow = $progres->fetch_assoc()){
                            $progressid = $progrow['progress_id'];
                            $counter ++;

                            $progfileqry = "SELECT * FROM progress_files WHERE progress_id='$progressid'";
                            $progfileres = $conn->query($progfileqry);
                            ?>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="header-title"><?php echo $counter;?> - <?php echo $progrow['progress_name'];?></h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-6"><span class="text-bold">Created: </span><?php echo date('d M Y H:m', strtotime($progrow['pg_date_created']));?> </div>
                                    <div class="col-sm-6"><span class="text-bold">Due: </span> <?php echo date('d M Y H:m', strtotime($progrow['due_date']));?></div>
                                </div>
                                <span class="text-bold h6">Description: </span>
                                <p><?php echo $progrow['progress_desc'];?></p>
                                

                                <?php if($progfileres->num_rows > 0){?>
                                    <hr class="my-2">
                                    <span class="text-bold h6">Uploaded Files: </span>
                                    <table class="table table-sm w-50">
                                        <thead>
                                        <tr>
                                            <th>File</th>
                                            <th style="width: 40px">Download</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php while($progfilerow = $progfileres->fetch_assoc()){?>
                                        <tr>
                                            <td><?php echo $progfilerow['file_name'];?></td>
                                            <td><a href="../files/<?php echo $progfilerow['file_name'];?>" target="_blank" class="btn btn-sm btn-secondary"><i class="fa fa-download"></i></a></td>
                                        </tr>
                                        <?php } ?>

                                        </tbody>
                                    </table>
                                <?php } ?>
                                  <hr class="my-2">

                                <span class="text-bold h6">Comment: </span>
                                <p> 
                                    <?php if($progrow['progress_comment']){?>
                                        <?php echo $progrow['progress_comment'];?>
                                    <?php }else{ ?>
                                        No Comment Yet!
                                    <?php } ?>
                                </p>
                            </div>
                        </div>

                        <?php } ?>



                        <?php if($prorow['project_status'] == 'Completed'){?>
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h5 class="header-title">Final Remarks</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-6"><span class="text-bold">Confirmed Completion: </span><?php echo date('d M Y H:m', strtotime($prorow['date_completed']));?> </div>
                                </div>
                                <p><?php echo $prorow['project_comment'];?></p>
                            </div>
                        </div>
                        <?php }?>


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
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">New Project Progress</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form method="post" action="processes/processes.php">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Subject</label>
                    <input class="form-control"  name="subject" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Due Date</label>
                    <input class="form-control" type="datetime-local" name="due" required>
                  </div>
                </div>

                <input type="hidden" value="<?php echo $prid;?>" name="prid">

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows='7'  name="desc" required></textarea>
                  </div>
                </div>

                


              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="new-progress" class="btn btn-primary">Submit</button>
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
              <p id="conceptshow"><?php echo $prorow['concept'];?></p>
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <div class="modal fade" id="modal-comm">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Progress Comment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form method="post" action="processes/processes.php">
            <div class="modal-body">
              <div class="row">
                
                <input type="hidden" value="" id="progid" name="progid">
                <input type="hidden" value="<?php echo $prid;?>" name="prid">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Write a Comment</label>
                    <textarea class="form-control" rows='7'  name="comm" required></textarea>
                  </div>
                </div>

                


              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="new-progress-comment" class="btn btn-primary">Submit</button>
            </div>
          </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->




      <div class="modal fade" id="modal-complete">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Complete Project</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form method="post" action="processes/processes.php">
            <div class="modal-body">
              <div class="row">
                
                <input type="hidden" value="<?php echo $prid;?>" name="prid">

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Overall Comment</label>
                    <textarea class="form-control" rows='7'  name="ocomm" required></textarea>
                  </div>
                </div>

              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="project_complete" class="btn btn-primary">Submit</button>
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
      $('.newcomm').click(function(){  
          var progid = $(this).attr("id");
          $('#progid').val(progid);
      });  
 });  
 </script>

</body>
</html>
