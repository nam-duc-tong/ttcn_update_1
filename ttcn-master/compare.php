<?php
	//require_once 'inc/header.php';
	// require_once 'inc/slider.php';	
?>
<?php
	// if(isset($_GET['cartid'])){
	// 	$cartid = $_GET['cartid'];
	// 	$delcart = $ct->del_product_cart($cartid);
	// }
	// if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
	// 	// request_method :Phương thức  yêu cầu được truy cập trang
	// 	$cartId = $_POST['cartId'];
    //     $quantity = $_POST['quantity'];
	// 	$update_quantity_cart = $ct->update_quantity_cart($quantity,$cartId);
	// 	if($quantity<=0){
	// 		$delcart = $ct->del_product_cart($cartId);
	// 	}
    // }
?>
<?php 
	// if(!isset($_GET['id'])){
	// 	echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
	// }
?>
 <!-- <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2 style="width:40%;">So Sánh Sản Phẩm</h2>
					<?php
						if(isset($update_quantity_cart)){
							echo $update_quantity_cart;
						}
					?>
					<?php		
						if(isset($delcart)){
							echo $delcart;
						}
					?>
						<table class="tblone">
							<tr>
								<th width="10%">ID So Sánh</th>
								<th width="20%">Tên Sản Phẩm</th>
								<th width="20%">Hình Ảnh</th>
								<th width="15%">Giá</th>
								<th width="15%">Hành Động</th>
							</tr>
							<?php
								$customer_id = Session::get('customer_id');
								$get_compare = $product->get_compare($customer_id);
								if($get_compare){
									$i = 0;
									while($result = $get_compare->fetch_assoc()){
										$i++;
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $result['productName']?></td>
								<td><img src="admin/uploads/<?php echo $result['image']?>" alt="" style="width:40px; height: 40px;"/></td>
								<td><?php echo $result['price']." VND"?></td>
								<td><a href="details.php?proId=<?php echo $result['productId']?>">View</a></td>
							</tr>
							<?php
								}
							}
							?>
						</table>
					</div>
					<div class="shopping">
						<div class="shopleft" style="margin-left: 25%;">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div> -->

 <?php
	//require_once 'inc/footer.php';
?>