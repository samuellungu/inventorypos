

<?php
include_once 'connectdb.php';

if(session_status()!==PHP_SESSION_ACTIVE){
	session_start();
}

if($_SESSION['email']=""){
	header('location:index.php');
}

if($_SESSION['role']=='admin'){
	include_once 'header.php';
}
else{
	include_once 'userheader.php';
}

 

if(isset($_POST['btnupdate'])){
	$old_password = $_POST['txtoldpass'];
	$new_password = $_POST['txtnewpass'];
	$confirm_password = $_POST['txtconfpass'];
	
	$email = $_SESSION['email'];
	
	$select = $pdo->prepare("select * from tb_user where email='$email'");
	$select->execute();
	$row = $select->fetch(PDO::FETCH_ASSOC);
		
	if($row['password']==$old_password){
		if($new_password==$confirm_password){
			$update = $pdo->prepare("update tb_user set password=:pass where email=:email");
			$update->bindParam(':pass', $new_password);
			$update->bindParam(':email', $email);
			
			if($update->execute()){
				echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Successful!!",
				  text: "Password Updated",
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
				  text: "Password Update Failed",
				  icon: "error",
				  button: "Ok!",
				});
				});	
		
				</script>';
			}
		}
		
	}else{
		echo '<script type="text/javascript">
		jQuery(function validation(){
		swal({
		  title: "Oops!",
		  text: "Password Mismatch!",
		  icon: "error",
		  button: "Ok!",
		});
		});	
		
		</script>';
	}
	
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
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
		<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtoldpass" required>
                </div>
				  
				 <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtnewpass" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtconfpass" required>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnupdate">Update</button>
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