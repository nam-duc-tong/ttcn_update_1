<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/product.php';?>
<?php
    $pd = new product();
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $insertProduct = $pd-> insert_product($_POST,$_FILES);
        //lấy tất cá dữ liệu $_POST, $_FILES là chứa hình ảnh
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm sản phẩm</h2>
        <div class="block">     
            <?php
                if(isset($insertProduct)){
                    echo $insertProduct;
                }
            ?>          
         <form action="productadd.php" method="post" enctype="multipart/form-data">
             <!-- enctype: thêm hình ảnh -->
            <table class="form">
                <tr>
                    <td>
                        <label>Tên Sản Phẩm</label>
                    </td>
                    <td>
                        <input type="text" name="productName" placeholder="Nhập Tên Sản Phẩm..." class="medium" />
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Danh Mục Sản Phẩm</label>
                    </td>
                    <td>
                        
                        <select id="select" name="category">
                            <option>---Chọn Danh Mục---</option>
                            <?php
                                $cat = new category();
                                $catlist = $cat->show_category();
                                if($catlist){
                                    while($result = $catlist->fetch_assoc()){
                            ?>
                            <option value="<?php echo $result['catId']?>"><?php echo $result['catName']?></option>
                            <?php    
                               }
                            }
                            ?> 
                        </select>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Thương Hiệu Sản Phẩm</label>
                    </td>
                    <td>
                        <select id="select" name="brand">
                            <option>---Chọn Thương Hiệu---</option>
                            <?php
                                $brand = new brand();
                                $brandlist = $brand->show_brand();
                                if($brandlist){
                                    while($result = $brandlist->fetch_assoc()){
                            ?>
                            <option value="<?php echo $result['brandId']?>"><?php echo $result['brandName']?></option>
                            <?php    
                               }
                            }
                            ?> 
                           
                        </select>
                    </td>
                </tr>
				
				 <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Miêu Tả</label>
                    </td>
                    <td>
                        <textarea name="product_desc" class="tinymce"></textarea>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Giá</label>
                    </td>
                    <td>
                        <input type="text" name="price" placeholder="Nhập Giá..." class="medium" />
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <label>Tải Ảnh Lên</label>
                    </td>
                    <td>
                        <input type="file" name="image"/>
                    </td>
                </tr>
				
				<tr>
                    <td>
                        <label>Loại Sản Phẩm</label>
                    </td>
                    <td>
                        <select id="select" name="type">
                            <option>Chọn Loại Sản Phẩm</option>
                            <option value="1">Hiển Thị</option>
                            <option value="0">Không Hiển Thị</option>
                        </select>
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Lưu" />
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>


