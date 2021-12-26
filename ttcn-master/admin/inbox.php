<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
 $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/cart.php');
    // echo "<script>window.location = 'productlist.php'</script>";
    include_once ($filepath.'/../helpers/dbhelper.php');
?>
<?php
$ct = new cart();
 if(isset($_GET['shiftid'])){
    $Id = $_GET['shiftid'];
    $time = $_GET['time'];
    $price = $_GET['price'];
    $shifted = $ct->shifted($Id,$time,$price);
 } 

 if(isset($_GET['delid'])){
    $Id = $_GET['delid'];
    $time = $_GET['time'];
    $price = $_GET['price'];
    $del_shifted = $ct->del_shifted($Id,$time,$price);
 }  
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thư</h2>
        <div class="block">
            <?php
                if(isset($shifted)){
                    echo $shifted;
                }
            ?>
             <?php
                if(isset($del_shifted)){
                    echo $del_shifted;
                }
            ?>
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ngày Đặt</th>
                        <th>Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>ID Khách Hàng</th>
                        <th>Địa chỉ</th>
                        <th>Hoạt Động</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $ct = new cart();
                        $fm = new format();
                        $get_inbox_cart = $ct->get_inbox_cart();
                        if($get_inbox_cart){
                            $i = 0;
                            while($result = $get_inbox_cart->fetch_assoc()){
                            ++$i;
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $i?></td>
                        <td><?php echo $fm->formatDate($result['date_order'])?></td>
                        <td><?php echo $result['productName']?></td>
                        <td><?php echo $result['quantity']?></td>
                        <td><?php echo $result['price'].' '.' VND'?></td>
                        <td><?php echo $result['customer_Id']?></td>
                        <td><a href="customer.php?customerId=<?php echo $result['customer_Id']?>">Thông Tin Khách hàng</a></td>
                        <td><a href="productedit.php?productId=<?php echo $result['productId']?>">Sửa</a> || <a href="?delid=<?php echo $result['Id']?>&price=<?php echo $result['price']?>&time=<?php echo $result['date_order']?>">Xóa</a></td>
                        <td>
                            <a onclick="return confirm('Hủy Đơn Hàng');" href="?delid=<?php echo $result['Id']?>&price=<?php echo $result['price']?>&time=<?php echo $result['date_order']?>">Hủy</a>||<a onclick="return confirm('Xác Nhận Đơn Hàng');" href="?delid=<?php echo $result['Id']?>&price=<?php echo $result['price']?>&time=<?php echo $result['date_order']?>">Nhận Đơn Hàng</a>  
                        </td>
                    </tr>
                    <?php                            
                           }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function(){
            setupLeftMenu();
            $('.datatable').dataTable();
            setSidebarHeight();
        });
</script>
<?php include 'inc/footer.php'?>