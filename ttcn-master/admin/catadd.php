<?php
    include 'inc/header.php';
?>
<?php
    include 'inc/sidebar.php';
?>
<?php 
    include '../classes/category.php';
?>
<?php
    $cat = new category();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $catName = $_POST['cat_name'];
        $insertCat = $cat->insert_category($catName);
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm Danh Mục</h2>
        
        <div class="block copyblock">
        <?php
        //nếu tồn tại insertcart thì sẽ echo nó 
        if(isset($insertCat)){
            echo $insertCat;
        }
        ?>
            <form action="catadd.php" method="post">
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" name="cat_name" class="medium" placeholder="Thêm Danh Mục Sản Phẩm"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit" value="Lưu"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php
    include 'inc/footer.php';
?>