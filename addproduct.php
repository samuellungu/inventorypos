<?php
 include_once 'connectdb.php';

if(session_status()!==PHP_SESSION_ACTIVE){
	session_start();
}

if($_SESSION['email']=='' OR $_SESSION['role']=='User'){
	header('location:index.php');
	
}

include_once 'header.php';

if(isset($_POST['btnaddproduct'])){
	
	$productName = $_POST['txtpname'];
	
	$category = $_POST['txtcategory'];
	
	$purchaseprice = $_POST['txtpprice'];
	
	$saleprice = $_POST['txtsaleprice'];
	
	$stock = $_POST['txtstock'];
	
	$description = $_POST['txtdescription'];
	
	//$image = $_POST['txtdescription'];
	
	
	
	$insert=$pdo->prepare("insert into tbl_product(pname, pcategory, purchaseprice, saleprice, pstock, pdescription) values(:pname, :pcategory, :purchaseprice, :saleprice, :pstock, :pdescription)");
	$insert->bindParam(':pname', $productName);
	$insert->bindParam(':pcategory', $category);
	$insert->bindParam(':purchaseprice', $purchaseprice);
	$insert->bindParam(':saleprice', $saleprice);
	$insert->bindParam(':pstock', $stock);
	$insert->bindParam(':pdescription', $description);
	
	
	if($insert->execute()){
		
		echo '<script type="text/javascript">
		jQuery(function validation(){
		swal({
		  title: "Success!",
		  text: "Product Added Successfully!",
		  icon: "success",
		  button: "Ok!",
		});
		});	
		
		</script>';
		
	}else{
		
		echo '<script type="text/javascript">
		jQuery(function validation(){
		swal({
		  title: "error!",
		  text: "Adding Product Failed!",
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
        Add Product
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
              <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back To Product List</a>
				</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
			<form action = "" method="post" name = "formproduct" enctype="multipart/form-data">
	
				
              <div class="box-body">
				
				  <div class="col-md-6">
				<div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control" name="txtpname" placeholder="Enter Product Name" required>
                </div>
					  
				<div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="txtcategory" required>
                    <option value="" disabled selected>Select Category</option>
					  <?php
					  	$select = $pdo->prepare("select * from tbl_category order by catid desc");
					  
					  	$select->execute();
					  
					  while($row=$select->fetch(PDO::FETCH_ASSOC)){
						  extract($row);
						  ?>
					  <option><?php 
							 echo $row['category']; 
							  
							  ?></option>
					  
					  <?php
					  
					  }
					  ?>
					
                   
                    
                  </select>
                </div>
					  
				 <div class="form-group">
                  <label>Purchase Price</label>
                  <input type="number" min="1" step="1" class="form-control" name="txtpprice" placeholder="Enter Purchase Price" required>
                </div>
					  
				<div class="form-group">
                  <label>Selling Price</label>
                  <input type="number" min="1" step="1" class="form-control" name="txtsaleprice" placeholder="Enter Selling Price" required>
                </div>
				
				
					
					</div>
				  <div class="col-md-6">
					  
					<div class="form-group">
                  <label>Stock</label>
                  <input type="number" min="1" step="1" class="form-control" name="txtstock" placeholder="Enter Stock" required>
                </div>
					  
				<div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="txtdescription" placeholder="Write Product Description" rows="4"></textarea>
                </div>
					  
				<!--div class="form-group">
                  <label>Product Image</label>
                  <input type="file" class="input-group" name="productimage"  required>
					<p>Upload Image</p>
                </div-->
					
					
					</div>
				  
				 
				  
		
			  </div>
			<div class="box-footer">
               
				<button type="submit" class="btn btn-info" name="btnaddproduct">Add Product</button>
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