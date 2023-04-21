<?php
 include_once 'connectdb.php';

if(session_status()!==PHP_SESSION_ACTIVE){
	session_start();
}

if($_SESSION['email']=='' OR $_SESSION['role']=='User'){
	header('location:index.php');
	
}

 include_once 'header.php';

$pid = $_GET['id'];
$select = $pdo->prepare("select * from tbl_product where pid=:id");
$select->bindParam(':id', $pid);
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);
$pname_db = $row['pname'];

$category_db = $row['pcategory'];

$product_pprice_db = $row['purchaseprice'];

$product_sprice_db = $row['saleprice'];

$stock_db = $row['pstock'];

$pdescription_db = $row['pdescription'];


//btn update form
if(isset($_POST['btnupdateproduct'])){
	
	$productName = $_POST['txtpname'];
	
	$category = $_POST['txtcategory'];
	
	$purchaseprice = $_POST['txtpprice'];
	
	$saleprice = $_POST['txtsaleprice'];
	
	$stock = $_POST['txtstock'];
	
	$description = $_POST['txtdescription'];
	
		
	$update=$pdo->prepare("update tbl_product set pname=:pname, pcategory=:pcategory, purchaseprice=:purchaseprice, saleprice=:saleprice, pstock=:pstock, pdescription=:pdescription  where pid=:pid");
	$update->bindParam(':pname', $productName);
	$update->bindParam(':pcategory', $category);
	$update->bindParam(':purchaseprice', $purchaseprice);
	$update->bindParam(':saleprice', $saleprice);
	$update->bindParam(':pstock', $stock);
	$update->bindParam(':pdescription', $description);
	$update->bindParam(':pid', $pid);
	
	
	if($update->execute()){
		
		echo '<script type="text/javascript">
		jQuery(function validation(){
		swal({
		  title: "Success!",
		  text: "Product Updated Successfully!",
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
		  text: "Updating Product Failed!",
		  icon: "error",
		  button: "Ok!",
		});
		});	
		
		</script>';
	}
	
}

	$select = $pdo->prepare("select * from tbl_product where pid=:id");
	$select->bindParam(':id', $pid);
	$select->execute();

	$row=$select->fetch(PDO::FETCH_ASSOC);
	$pname_db = $row['pname'];

	$category_db = $row['pcategory'];

	$product_pprice_db = $row['purchaseprice'];

	$product_sprice_db = $row['saleprice'];

	$stock_db = $row['pstock'];

	$pdescription_db = $row['pdescription'];

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product
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
              <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back To Product List</a>
				</h3>
            </div>
            <div class="box-header with-border">
              <h3 class="box-title">Product Update Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
			
			<form action = "" method="post" name = "formproduct" enctype="multipart/form-data">
            <div class="box-body">
				
				  <div class="col-md-6">
				<div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control" name="txtpname" value="<?php echo $pname_db; ?>" >
                </div>
					  
				<div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="txtcategory" required>
                    <option value="" disabled selected>Select Category</option>
					  <?php
					  	$select = $pdo->prepare("select * from tbl_category order by catid desc");
					  
					  	$select->execute();
					  
					  while($category_row=$select->fetch(PDO::FETCH_ASSOC)){
						  extract($category_row);
						  ?>
					  <option <?php if($category_db==$category_row['category']){ ?>
							  selected="selected"
							  
							  <?php }?>> <?php 
							 echo $category_row['category']; 
							  
							  ?></option>
					  
					  <?php
					  
					  }
					  ?>
					
                   
                    
                  </select>
                </div>
					  
				 <div class="form-group">
                  <label>Purchase Price</label>
                  <input type="number" min="1" step="1" class="form-control" name="txtpprice" value="<?php echo $product_pprice_db; ?>"  required>
                </div>
					  
				<div class="form-group">
                  <label>Selling Price</label>
                  <input type="number" min="1" step="1" class="form-control" name="txtsaleprice" value="<?php echo $product_sprice_db; ?>" required>
                </div>
				
				
					
					</div>
				  <div class="col-md-6">
					  
					<div class="form-group">
                  <label>Stock</label>
                  <input type="number" min="1" step="1" class="form-control" name="txtstock" value="<?php echo $stock_db; ?>" required>
                </div>
					  
				<div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="txtdescription"  rows="4"><?php echo $pdescription_db; ?></textarea>
                </div>
					  
				<!--div class="form-group">
                  <label>Product Image</label>
                  <input type="file" class="input-group" name="productimage"  required>
					<p>Upload Image</p>
                </div-->
					
					
					</div>
				  
				 
				  
		
			  </div>
				<div class="box-footer">
               
				<button type="submit" class="btn btn-warning" name="btnupdateproduct">Update Product</button>
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