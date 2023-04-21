<?php
 include_once 'connectdb.php';

if(session_status()!==PHP_SESSION_ACTIVE){
	session_start();
}

if($_SESSION['email']=='' OR $_SESSION['role']=='User'){
	header('location:index.php');
	
}

 include_once 'header.php';
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product List
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
              <h3 class="box-title">Product list</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
				
				
			<div class="box-body">
				
			<div style="overflow-x:auto">
			<table id = "producttable" class="table table-striped">
					  <thead>
						<tr>
							
							<th>ProductName</th>
							<th>Category</th>
							<th>PurchasePrice</th>
							<th>SellingPrice</th>
							<th>StockLevel</th>
							<th>Description</th>
							<th>View</th>
							<th>Edit</th>
							<th>Delete</th>
							
						  </tr>	  
					  </thead>
					  
					  <tbody>
						<?php
						  $select=$pdo->prepare("select * from tbl_product order by pid asc");
						  $select->execute();
						  //$row = $select->fetch(PDO::FETCH_OBJ);
						  while($row = $select->fetch(PDO::FETCH_OBJ)){
							  echo '
							  <tr>
							  <td>'.$row->pname.'</td>
							  <td>'.$row->pcategory.'</td>
							  <td>'.$row->purchaseprice.'</td>
							  <td>'.$row->saleprice.'</td>
							  <td>'.$row->pstock.'</td>
							  <td>'.$row->pdescription.'</td>
							  <td><a href="viewproduct.php?id='.$row->pid.'" class="btn btn-success" role="button">
								<span class="glyphicon glyphicon-eye-open" 
								style="color:#ffffff" data-toggle="tooltip"
								title="View Product"></span></a>
							  </td>
							  
							  <td><a href="editproduct.php?id='.$row->pid.'" class="btn btn-info" role="button">
								<span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip"
								title="Edit Product"></span></a></td>
							   
							  <td>
							  	<button id='.$row->pid.' class="btn btn-danger btndelete">
								<span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>
							  </td>
							  </tr>
							  ';
						  }
						 ?>
						  
					  </tbody>
					  
					  
					  
					  </table>
					  
			</div>
			
			
			
			</div></div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
	$(document).ready( function () {
    $('#producttable').DataTable();
	});

</script>

<script>
	$(document).ready( function () {
    	$('[data-toggle="tooltip"]').tooltip();
	});

</script>

<script>
	$(document).ready(function(){
		
		$('.btndelete').click(function(){
			var tdh = $(this);
			var id = $(this).attr("id");
			swal({
			  title: "Are You Sure?",
			  text: "Once Deleted, You Will Not Be Able To Recover This Product!",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
				  
				$.ajax({
				
					url:'productdelete.php', 
					type:'post',
					data:{
						pidd:id
					},
					success:function(data){
						tdh.parent('tr').hide();
					}
			})
				  
				  
				swal("Record Successfully Deleted!", {
				  icon: "success",
				});
			  } else {
				swal("Record Not Deleted");
			  }
			});

			
			
			
			
		});
		
	});
	
	
</script>

<?php
	include_once 'footer.php';
?>