<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/product.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/brand.php';?>
<?php include_once '../helpers/dbhelper.php';?>
<?php
    $pd = new product();
    $fm = new format();
    if(isset($_GET['productId'])){//nếu có product id thì sẽ gán biến id vào $get productid
        $id = $_GET['productId'];
        $delpro = $pd->del_product($id);
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh Sách Sản Phẩm</h2>
        <div class="block">  
            <?php
                if(isset($delpro)){
                    echo $delpro;
                }
            ?>
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>STT</th>
					<th>Tên Sản Phẩm</th>
					<th>Giá</th>
					<th>Ảnh Sản Phẩm</th>
                    <th>Danh Mục</th>
					<th>Thương Hiệu</th>
					<th>Mô Tả</th>
					<th>Loại</th>
					<th>Hành Động</th>
				</tr>
			</thead>
			<tbody>
                <?php
                    $pd = new product();
                    $fm = new format();
                    $pdlist = $pd->show_product();
                    if($pdlist){
                        $i=0;
                        while($result = $pdlist->fetch_assoc()){
                            $i++;
                ?>
				<tr class="odd gradeX">
					<td><?php echo $i?></td>
                    <td><?php echo $result['productName']?></td>
                    <td><?php echo $result['price']?></td>
                    <td><img src="uploads/<?php echo $result['image']?>" width="50px" style="padding-top:10px;"></td>
                    <td><?php echo $result['catName']?></td>
					<td><?php echo $result['brandName']?></td>
                    <td><?php echo $fm->textShorten($result['product_desc'],30)?></td>
                    
                    <td><?php
                        if($result['type']==0){
                            echo 'Không Hiển Thị';
                        }
                        else{
                            echo 'Hiển Thị'; 
                        }
                    ?></td>
					
					<td><a href="productedit.php?productId=<?php echo $result['productId']?>">Sửa</a> || <a href="?productId=<?php echo $result['productId']?>">Xóa</a></td>
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
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
