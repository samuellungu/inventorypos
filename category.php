<?php
include_once 'connectdb.php';

if(session_status()!==PHP_SESSION_ACTIVE){
	session_start();
}

if($_SESSION['email']=='' OR $_SESSION['role']=='User'){
	header('location:index.php');
	
}


include_once 'header.php';

//$error = '';

if(isset($_POST['btnsave'])){
	$category = $_POST['txtcategory'];
	
	if(empty($category)){
		
		$error =  '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Field Is Empty!",
				  text: "Please Fill The Field",
				  icon: "error",
				  button: "Ok!",
				});
				});	
		
				</script>';
		
		echo '$error';
		
	}
	if(!isset($error)){
		$insert = $pdo->prepare("insert into tbl_category(category) values(:category)");
		$insert->bindParam(':category', $category);
		
		if($insert->execute()){
			 echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Success!",
				  text: "Category Successfully Added",
				  icon: "success",
				  button: "Ok!",
				});
				});	
		
				</script>';
			
		}else{
			
			echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Error!",
				  text: "Adding Category Failed",
				  icon: "error",
				  button: "Ok!",
				});
				});	
		
				</script>';
		}		
	}
}

if(isset($_POST['btnupdate'])){
	$category = $_POST['txtcategory'];
	$id = $_POST['txtid'];
	
	if(empty($category)){
		
		$errorupdate = '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Error!",
				  text: "Field is Empty",
				  icon: "error",
				  button: "Ok!",
				});
				});	
		
				</script>';
		
		echo $errorupdate;
	}
	if(!isset($errorupdate)){
		
		$update = $pdo->prepare("update tbl_category set category=:category where catid=".$id);
		$update->bindParam(':category', $category);
		//$update->bindParam(':caid', $id);
		if($update->execute()){
			echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Success!",
				  text: "Category Successfully Updated!",
				  icon: "success",
				  button: "Ok!",
				});
				});	
		
				</script>';
		}else{
			echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Error!",
				  text: "Category Update Failed",
				  icon: "error",
				  button: "Ok!",
				});
				});	
		
				</script>';
		}
		
	}		
	
}//btnupdate ends here
if(isset($_POST['btndelete'])){
	//$id = $_POST[]
	$delete = $pdo->prepare("delete from tbl_category where catid=".$_POST['btndelete']);
	//$delete->execute()
	
	if($delete->execute()){
		echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Deleted!",
				  text: "Category Deleted!",
				  icon: "success",
				  button: "Ok!",
				});
				});	
		
				</script>';
		
	}else{
		echo '<script type="text/javascript">
				jQuery(function validation(){
				swal({
				  title: "Error!",
				  text: "Category Deletion Failed!",
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
        Category
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
		<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Category Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
				
				
              <div class="box-body">
				  <form role="form" action="" method="post">
					<?php
					  if(isset($_POST['btnedit'])){
						  
						  $select = $pdo->prepare("select * from tbl_category where catid =".$_POST['btnedit']);
						  $select->execute();
						  
						  if($select){
							  $row = $select->fetch(PDO::FETCH_OBJ);
							  
							  echo '<div class="col-md-4">
							  <div class="form-group">
							  <label >Category</label>
							  
							  <input type="hidden" class="form-control" name="txtid" value="'.$row->catid.'" >
							  
							  <input type="text" class="form-control" name="txtcategory" value="'.$row->category.'" ></div>

							<button type="submit" class="btn btn-info" name="btnupdate">Update</button>

							</div>';
							  
						  }
						  
					  }else{
						  echo '<div class="col-md-4">
						  <div class="form-group">
						  <label >Category</label>
						  <input type="text" class="form-control" name="txtcategory" placeholder="Enter Category" >
                			</div>
					           
					  	<button type="submit" class="btn btn-warning" name="btnsave">Save</button>
				  
				  		</div>';
					  }
					  
					  
					  
					 ?>  
				  
				  <div class="col-md-8">
					  <table id="tablecategory" class="table table-striped">
					  <thead>
						<tr>
							<th>#</th>
							<th>CATEGORY</th>
							<th>EDIT</th>
							<th>DELETE</th>
							
						  </tr>	  
					  </thead>
					  
						  <tbody>
							  <?php
							  $select = $pdo->prepare("select * from tbl_category order by catid desc");
							  
							  $row = $select->execute();
							  while($row = $select->fetch(PDO::FETCH_OBJ)){
								  echo '
								  	<tr>
									<td>'.$row->catid.'</td>
									<td>'.$row->category.'</td>
									<td><button type="submit" value='.$row->catid.' class="btn btn-success" name="btnedit">Edit</button></td>
									
									<td><button type="submit" value='.$row->catid.' class="btn btn-danger" name="btndelete">Delete</button></td>
									</tr>';
								  
							  }
							  	
							  ?>
						    
						  
						  
						  
						  </tbody>
						
					  
					  
					  
					  </table>
					  
					  
					  
				  
				  </div>
            
				  </form>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
               
              </div>
           
          </div>
		

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

//call this sin
<script>
	$(document).ready( function () {
    $('#tablecategory').DataTable();
	});

</script>

<?php
	include_once 'footer.php';
?>