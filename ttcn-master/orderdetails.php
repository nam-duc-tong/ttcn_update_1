<?php
	require_once 'inc/header.php';
	// require_once 'inc/slider.php';	
?>
<?php 
// echo "<script>window.location = 'productlist.php'</script>";
	$login_check = Session::get('customer_login');
	if($login_check==false){
		header('Location:login.php');
	}
	$ct = new cart();
 if(isset($_GET['confirmid'])){
    $Id = $_GET['confirmid'];
    $time = $_GET['time'];
    $price = $_GET['price'];
    $shifted_confirm = $ct->shifted_confirm($Id,$time,$price);//da nhan duoc hang

 }

?>
<?php
	if(isset($_GET['cartId'])){
		$cartid = $_GET['cartId'];
		$delcart = $ct->del_product_cart($cartid);
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
		$cartid = $_POST['cartid'];
        $quantity = $_POST['quantity'];
		$update_quantity_cart = $ct->update_quantity_cart($quantity,$cartid);
		if($quantity<=0){
			$delcart = $ct->del_product_cart($cartid);
		}
    }
?>
<?php 
	if(!isset($_GET['id'])){
		echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
	}
?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2 style="width: 500px;">Chi Tiết Đơn Hàng</h2>
					<?php		
						if(isset($delcart)){
							echo $delcart;
						}
					?>
						<table class="tblone">
							<tr>
								<th width="10%">STT</th>	
								<th width="20%">Tên Sản Phẩm</th>
								<th width="10%">Ảnh</th>
								<th width="10%">Giá</th>
								<th width="10%">Số Lượng</th>
								<th width="15%">Ngày Đặt</th>
								<th width="15%">Trạng Thái</th>
								
							</tr>
							<?php
							 $customer_Id = Session::get('customer_Id');
								$get_cart_ordered = $ct ->get_cart_ordered($customer_Id);
								if($get_cart_ordered){
									$i=0;
									while($result = $get_cart_ordered->fetch_assoc()){		
										$i++;	
										
							?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $result['productName']?></td>
								<td><img src="admin/uploads/<?php echo $result['image']?>" alt="" style="width:40px; height: 40px;"/></td>
								<td><?php echo $fm->format_currency($result['price'])." VND"?></td>
								
								<td><?php echo $result['quantity']?></td>
								<td><?php echo $fm->formatDate($result['date_order'])?></td>
								<td><?php 
									if($result['status']==0){
										echo 'Đang xử lý';
									}
									?>
								</td>
								
							</tr>
							<?php
							
								}
							}
							?>
						</table>
					</div>
					<div class="shopping">
					<div class="shopleft">
					<!-- <a href="index.php"><img src="images/shop.png" alt="" /></a> -->
					<!-- <button id="checkout" style="padding: 5px 20px;">Thanh Toán</button> -->
					<a href="index.php"><button id="shopping" style="padding: 10px 25px;font-size: 20px;"><i class="fas fa-hand-point-left" style="padding-right: 10px;"></i>Quay Lại</button></a>
				</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php
	require_once 'inc/footer.php';
?>