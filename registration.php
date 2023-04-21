<?php
include_once 'connectdb.php';
if(session_status()!=PHP_SESSION_ACTIVE){
	session_start();
}

if($_SESSION['email']=='' OR $_SESSION['role']=='User'){
	header('location:index.php');
	
}


include_once 'header.php';
error_reporting(0);

$id = $_GET['id'];
$delete = $pdo->prepare("delete from tb_user where user_id =:id");
$delete->bindParam(':id', $id);

if($delete->execute()){
	echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Success!",
				  text:  "User Successfully Deleted",
				  icon: "success",
				  button: "Ok!",
				});
				});	
		
				</script>';
}

if(isset($_POST['btnsave'])){
	$username = $_POST['txtname'];
	$email = $_POST['txtemail'];
	$password = $_POST['txtpassword'];
	$role = $_POST['txtrole_option'];
	
	if(isset($_POST['txtemail'])){
		$select = $pdo->prepare("select email from tb_user where email='$email'");
		$select->execute();
		
		if($select->rowCount()>0){
			echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Warning!",
				  text: "Email Already In Use",
				  icon: "warning",
				  button: "Ok!",
				});
				});	
		
				</script>';
		}else{
			$insert = $pdo->prepare("insert into tb_user (username, email, password, role) values(:name, :email, :password, :role)");
			$insert->bindParam(':name', $username);
			$insert->bindParam(':email', $email);
			$insert->bindParam(':password', $password);
			$insert->bindParam(':role', $role);

			if($insert->execute()){
				echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Success!",
				  text: "New User Successfully Added",
				  icon: "success",
				  button: "Ok!",
				});
				});	
		
				</script>';
			}
			else{
				echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Error!",
				  text: "Registration Failed",
				  icon: "error",
				  button: "Ok!",
				});
				});	
		
				</script>';
			}
		}
		
	}
	
}


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Registration
        <small>   </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
		<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Registration Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
				  <div class="col-md-4">
				  
				 <div class="form-group">
                  <label >Name</label>
                  <input type="text" class="form-control" name="txtname" placeholder="Enter Username" required>
                </div>
					  
				 <div class="form-group">
                  <label>Email address</label>
                  <input type="email" class="form-control" name="txtemail" placeholder="Enter email" required>
                </div>
					  
					  
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="txtpassword" placeholder="Password" required>
                </div>
    			<div class="form-group">
                  <label>Role</label>
                  <select class="form-control" name="txtrole_option" required>
                    <option value="" disabled selected>Select Role</option>
					<option>User</option>
                    <option>Admin</option>
                    
                  </select>
                </div>
					  <button type="submit" class="btn btn-info" name="btnsave">Save</button>
				  
				  </div>
				  <div class="col-md-8">
					  <table class="table table-striped">
					  <thead>
						<tr>
							<th>#</th>
							<th>USERNAME</th>
							<th>EMAIL</th>
							<th>PASSWORD</th>
							<th>ROLE</th>
							<th>DELETE</th>
							
						  </tr>	  
					  </thead>
					  
					  <tbody>
						<?php
						  $select=$pdo->prepare("select * from tb_user order by user_id asc");
						  $select->execute();
						  //$row = $select->fetch(PDO::FETCH_OBJ);
						  while($row = $select->fetch(PDO::FETCH_OBJ)){
							  echo '
							  <tr>
							  <td>'.$row->user_id.'</td>
							  <td>'.$row->username.'</td>
							  <td>'.$row->email.'</td>
							  <td>'.$row->password.'</td>
							  <td>'.$row->role.'</td>
							  <td>
							  	<a href="registration.php?id='.$row->user_id.'" class="btn btn-danger" role="button">
								<span class="glyphicon glyphicon-trash" title="delete"></span></a>
							  </td>
							  </tr>
							  ';
						  }
						 ?>
						  
					  </tbody>
					  
					  
					  
					  </table>
					  
					  
					  
				  
				  </div>
            
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
               
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
	include_once 'footer.php';
?>