<?php
$pg = 2;
include "includes/header.php";
include "../includes/connect.php";
include "includes/sessions.php";

function setStatus($status){
  if($status == 1){
    return "Assigned to Lawyer";
  }elseif($status == 0){
    return "Pending";
  }
}

$proqry = "SELECT * FROM client_case JOIN category ON client_case.category_id=category.category_id WHERE client_case.client_id='$clientID'";
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
            <h1 class="m-0">My Cases</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Client</a></li>
              <li class="breadcrumb-item active">My Cases</li>
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
                                <div class="card-tools">
                                    <button class="btn btn-sm btn-primary bg-gradient-primary" data-toggle="modal" data-target="#modal-new"><i class="fa fa-plus"></i> Create New</button>
                                </div>
                            </div>
                            <div class="card-body">

                                <table id="example1" class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>Case</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($prorow = $prores->fetch_assoc()){
                                          
                                          ?>
                                        <tr>
                                            <td><?php echo $prorow['title'];?><br/><?php echo $prorow['case_number'];?></td>
                                            <td><?php echo $prorow['category_name'];?></td>
                                            <td><?php echo setStatus($prorow['case_status']);?></td>
                                            <td><?php echo date('d M Y', strtotime($prorow['date_created']));?></td>
                                            <td class="text-nowrap">
                                                <?php if($prorow['case_status'] == 1){?>
                                                <a href="case.php?case=<?php echo $prorow["case_id"];?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> </a>
                                                <?php }else{?>
                                                  <a href="case2.php?case=<?php echo $prorow["case_id"];?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> </a>
                                                  <?php }?>
                                                <a class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
              <h4 class="modal-title">Create A Case</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form method="post" action="processes/processes.php">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Case Title</label>
                    <input class="form-control" placeholder="Case Title" name="title" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Case Category</label>
                    <select class="form-control"  name="cat" required>
                        <?php
                        $classenrolledqry = "SELECT * FROM category";
                        $classenrolledres = $conn->query($classenrolledqry);
                        while($classenrolledrow = $classenrolledres->fetch_assoc()){
                            echo '<option value="'.$classenrolledrow['category_id'].'">'.$classenrolledrow['category_name'].'</option>';
                        }
                        ?>
                    </select>
                  </div>
                </div>


                <div class="col-md-12">
                  <div class="form-group">
                    <label>Describe your case</label>
                    <textarea class="form-control" id="summernote" name="concept" required></textarea>
                  </div>
                </div>
                


              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="new-case" class="btn btn-primary">Submit</button>
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
