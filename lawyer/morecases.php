<?php
$pg = 4;
include "includes/header.php";
include "../includes/connect.php";
include "includes/sessions.php";

$lawres = $conn->query("SELECT * FROM lawyer WHERE lawyer_id = '$lecID'");
$lawrow = $lawres->fetch_assoc();
$lawcat = $lawrow['category_id'];
$proqry = "SELECT * FROM client_case JOIN client On client.client_id=client_case.client_id WHERE client_case.case_status = 0 AND client_case.category_id = '$lawcat'";
$prores = $conn->query($proqry);
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
            <h1 class="m-0">New Cases</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Lawyer</a></li>
              <li class="breadcrumb-item active">New Cases</li>
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
                            <div class="card-header">
                                
                            </div>
                            <div class="card-body">

                                <table id="example1" class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>Client</th>
                                            <th>Case</th>
                                            <th>Description</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($prorow = $prores->fetch_assoc()){?>
                                        <tr>
                                            <td><?php echo $prorow['firstname']." ". $prorow['lastname'];?><br><?php echo $prorow['email'];?></td>
                                            <td><?php echo $prorow['case_number'];?><br><?php echo $prorow['title'];?></td>
                                            <td><?php echo $prorow['description'];?></td>
                                            <td><?php echo date('d M Y', strtotime($prorow['date_created']));?></td>
                                            <td class="text-nowrap">
                                                <a href="processes/processes.php?takecase=<?php echo $prorow["case_id"];?>" class="btn btn-sm btn-primary">Take case </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <!-- /.card-body -->

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
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create A New Project</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form method="post" action="processes/processes.php">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Project Name</label>
                    <input class="form-control" placeholder="Project Name" name="pname" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Class</label>
                    <select class="form-control"  name="class" required>
                        <?php
                        $classenrolledqry = "SELECT * FROM student_class JOIN class ON student_class.class_id=class.class_id WHERE student_class.student_id='$studID'";
                        $classenrolledres = $conn->query($classenrolledqry);
                        while($classenrolledrow = $classenrolledres->fetch_assoc()){
                            echo '<option value="'.$classenrolledrow['student_class_id'].'">'.$classenrolledrow['class_code'].' '.$classenrolledrow['class_name'].'</option>';
                        }
                        ?>
                    </select>
                  </div>
                </div>


                <div class="col-md-12">
                  <div class="form-group">
                    <label>Project Concept</label>
                    <textarea class="form-control" rows="10" name="concept" required></textarea>
                  </div>
                </div>
                


              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="new-project" class="btn btn-primary">Submit</button>
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
      $('.editstd').click(function(){  
          var studid = $(this).attr("id");
          $.ajax({  
                  url:"processes/processes.php",  
                  method:"POST",  
                  data:{fetch_single_student:studid}, 
                  dataType: 'json',
                  success:function(data){
                    $('#fname').val(data.firstname);
                    $('#lname').val(data.lastname);
                    $('#adm').val(data.adm_no);
                    $('#studentid').val(data.student_id);
                  }  
          }); 
		  
      });  
 });  
 </script>

</body>
</html>
