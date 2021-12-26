<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php'?>
<?php
    $cat = new category();
    if(isset($_GET['delid'])){
        //neu ton tai delid thi se gan vaof $id
        $id = $_GET['delid'];
        $delcat = $cat->del_category($id);
    }
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Danh Sách Danh Mục Sản Phẩm</h2>
                <div class="block">   
                    <?php
                        if(isset($delcat)){
                            echo $delcat;
                        }
                    ?>     
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên Danh Mục</th>
							<th>Hoạt Động</th>
						</tr>
					</thead>
					<tbody>
                        <?php
                            $show_cate = $cat->show_category();
                            if($show_cate){ 
                                $i=0;
                                while($result = $show_cate->fetch_assoc()){
                                    $i++;
                        ?>
						<tr class="odd gradeX">
                            <!-- số thứ tự -->
                            <td><?php echo $i;?></td>
                            <!-- Tên danh muc -->
							<td><?php echo $result['catName']?></td>
							<td><a href="catedit.php?catId=<?php echo $result['catId']?>">Sửa</a>||<a onclick="return confirm('Bạn có muốn xóa không?')" href="?delid=<?php echo $result['catId']?>">Xóa</a></td>
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

