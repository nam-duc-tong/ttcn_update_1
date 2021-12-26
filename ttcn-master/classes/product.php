<?php

 $filepath = realpath(dirname(__FILE__));
    //dường dẫn thực
 include_once ($filepath.'/../lib/database.php');
 include_once ($filepath.'/../helpers/dbhelper.php');
?>
<?php
    class product{  
        private $fm;
        private $db;
        public function __construct(){
            $this->db = new Database();
            $this->fm = new format();
        }                                            
        public function search_product($tukhoa){
            $tukhoa = $this->fm->validation($tukhoa);
            $query = "SELECT * FROM tbl_product WHERE productName LIKE '%$tukhoa%'"; //tim tu giong tu khoa trong productName
            $result = $this->db->select($query);
            return $result;
        }                                                       
        public function insert_product($data,$files){
            $productName = mysqli_real_escape_string($this->db->link,$data['productName']);
            $brand = mysqli_real_escape_string($this->db->link,$data['brand']);
            $category = mysqli_real_escape_string($this->db->link,$data['category']);
            $product_desc = mysqli_real_escape_string($this->db->link,$data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link,$data['price']);
            $type = mysqli_real_escape_string($this->db->link,$data['type']);
            //kiem tra hinh anh va lay hinh anh cho vao folder uploads
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];
            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()),0,10).'.'.$file_ext;
            $uploaded_image = "uploads/".$unique_image;
            if($productName==""||$brand==""||$category==""||$product_desc==""||$price==""||$type==""||$file_name==""){
                $alert = "<span class='error'>Các Trường Không Được Để Trống</span>";
                return $alert;
            }
            else{
                //lấy hình ảnh cho vào file upload
                move_uploaded_file($file_temp,$uploaded_image); 
                $query = "INSERT INTO tbl_product(productName,brandId,catId,product_desc,price,type,image) VALUES('$productName','$brand','$category','$product_desc','$price','$type','$unique_image')";
                $result = $this->db->insert($query);    
                if($result){
                    $alert = "<span class= 'success'>Thêm Sản Phẩm Thành Công</span>";
                    return $alert;
                }   
                else{
                    $alert = "<span class= 'error'>Thêm Sản Phẩm Thất Bại</span>";
                    return $alert;
                }
            }  
        }
        public function insert_slider($data, $files)
        {
            $sliderName = mysqli_real_escape_string($this->db->link,$data['sliderName']);
            $type = mysqli_real_escape_string($this->db->link,$data['type']);
                        //kiem tra hinh anh va lay hinh anh cho vao folder uploads
            //chỉ cho phép file có đuôi chấm....
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];//tên ảnh
            $file_size = $_FILES['image']['size'];//kích thước hình ảnh
            $file_temp = $_FILES['image']['tmp_name']; //file tạm để lưu hình ảnh

            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));
            //chuyển tất cả chữ hoa thành chữ thường

            $unique_image = substr(md5(time()),0,10).'.'.$file_ext;
            $uploaded_image = "uploads/".$unique_image;
            //nếu trống
            if($sliderName==""||$type==""){
                $alert = "<span class='error'>Các Trường Không Được Để Trống</span>";
                return $alert;
            }
            else{
                if(!empty($file_name)){
                    //neu nguoi dung chon anh
                    if($file_size>2048000){//kiểm tra kích cơ file hịnh anh
                        $alert = "<span class='success'>Kích Thước Ảnh Phải Quá Lớn</span>";
                        return $alert;
                    }
                    elseif (in_array($file_ext,$permited)===false){
                        $alert = "<span class='error'>Bạn Chỉ Có Thể Tải Lên:-".implode(',',$permited)."</span>";
                        return $alert;
                    }
                    move_uploaded_file($file_temp,$uploaded_image);
                    $query = "INSERT INTO tbl_slider(sliderName,type,slider_image) VALUES('$sliderName','$type','$unique_image')";
                    $result = $this->db->insert($query);    
                        if($result){
                            $alert = "<span class= 'success'>Thêm slider Thành Công</span>";
                            return $alert;
                        }   
                        else{
                            $alert = "<span class= 'error'>Thêm slider Thất Bại</span>";
                            return $alert;
                        }
                    }
            // $query = "UPDATE tbl_brand SET brandName ='$brandName' WHERE brandId = '$id'";
          } 
        }

        public function show_slider()
        {
            $query = "SELECT * FROM tbl_slider where type ='1' order by  sliderId desc";
            $result = $this->db->select($query);
            return $result;
        }
        
        public function show_slider_list()
        {
            $query = "SELECT * FROM tbl_slider order by  sliderId desc";
            $result = $this->db->select($query);
            return $result;
        }
        public function show_product(){

            $query = "SELECT tbl_product.*,tbl_category.catName, tbl_brand.brandName
            -- chọn cột product lấy tất cả
            -- chọn cột category lấy catName
            -- chọn cột brand lấy brandname
            -- từ table product 
            -- inner join  
            from  tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId order by tbl_product.productId desc";
            // $query = "SELECT * from  tbl_product order by productId desc";
            $result = $this->db->select($query);
            return $result;
        }

        public function getproductbyId($id){
            $query = "SELECT * FROM tbl_product where productId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        public function update_product($data,$files,$id){        
            //lấy dữ liệu  
            $productName = mysqli_real_escape_string($this->db->link,$data['productName']);
            $brand = mysqli_real_escape_string($this->db->link,$data['brand']);
            $category = mysqli_real_escape_string($this->db->link,$data['category']);
            $product_desc = mysqli_real_escape_string($this->db->link,$data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link,$data['price']);
            $type = mysqli_real_escape_string($this->db->link,$data['type']);
            //kiem tra hinh anh va lay hinh anh cho vao folder uploads
            //chỉ cho phép file có đuôi chấm....
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];//tên ảnh
            $file_size = $_FILES['image']['size'];//kích thước hình ảnh
            $file_temp = $_FILES['image']['tmp_name']; //file tạm để lưu hình ảnh

            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));//chuyển tất cả chữ hoa thành chữ thường
            $unique_image = substr(md5(time()),0,10).'.'.$file_ext;
            $uploaded_image = "uploads/".$unique_image;
            //nếu trống
            if($productName==""||$brand==""||$category==""||$product_desc==""||$price==""||$type==""){
                $alert = "<span class='error'>Các Trường Không Được Để Trống</span>";
                return $alert;
            }
            else{
                if(!empty($file_name)){
                    //neu nguoi dung chon anh
                    if($file_size>20480000){//kiểm tra kích cơ file hịnh anh
                        $alert = "<span class='success'>Kích Thước Ảnh Phải Quá Lớn</span>";
                        return $alert;
                    }
                    elseif (in_array($file_ext,$permited)===false){
                        $alert = "<span class='error'>Bạn Chỉ Có Thể Tải Lên:-".implode(',',$permited)."</span>";
                        return $alert;
                    }
                    move_uploaded_file($file_temp,$uploaded_image);
                    $query = "UPDATE tbl_product SET
                     productName ='$productName',
                     brandId ='$brand',
                     catId ='$category',
                     type ='$type',
                     price ='$price',
                     image ='$unique_image', 
                     product_desc ='$product_desc' 
                     WHERE productId = '$id'";
                       $result = $this->db->update($query);
                       if($result){
                           $alert = "<span class='success'>Cập Nhật Sản Phẩm Thành Công</span>";
                           return $alert;
                       }
                       else{
                           $alert = "<span class='error'>Cập Nhật Sản Phẩm Thất Bại</span>";
                           return $alert;
                       }
                }
                else
                    {
                        //neu nguoi dung khong chon anh
                        $query = "UPDATE tbl_product SET
                        productName ='$productName' ,
                        brandId ='$brand' ,
                        catId ='$category' ,
                        type ='$type' ,
                        price ='$price' ,
                        -- image ='$unique_image',
                        product_desc ='$product_desc'  
   
                        WHERE productId = '$id'";
                         $result = $this->db->update($query);
                         if($result){
                             $alert = "<span class='success'>Cập Nhật Sản Phẩm Thành Công</span>";
                             return $alert;
                         }
                         else{
                             $alert = "<span class='error'>Cập Nhật Sản Phẩm Thất Bại</span>";
                             return $alert;
                         }
                    }
            // $query = "UPDATE tbl_brand SET brandName ='$brandName' WHERE brandId = '$id'";
          }
        }
        public function update_type_slider($id,$type){
            $type = mysqli_real_escape_string($this->db->link,$type);
            $query = "UPDATE tbl_slider SET type = '$type' WHERE sliderId = '$id'";
            $result = $this->db->update($query);
            return $result;
        }
        public function del_product($id){
            $query = "DELETE FROM tbl_product WHERE productId = '$id'";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Xóa Sản Phẩm Thành Công</span>";
                return $alert;
            }
            else{
                $alert = "<span class = 'error'>Xóa Sản Phẩm Thất Bại</span>";
                return $alert;
            }
        }

        public function del_slider($id){
            $query = "DELETE FROM tbl_slider WHERE sliderId = '$id'";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Xóa Slider Thành Công</span>";
                return $alert;
            }
            else{
                $alert = "<span class = 'error'>Xóa Slider Thất Bại</span>";
                return $alert;
            }
        }
        
        public function del_wishlist($proid,$customer_id)
        {
            $query = "DELETE FROM tbl_wishlist WHERE productId = '$proid' and customer_id = '$customer_id'";
            $result = $this->db->delete($query);
            return $result;
        }
    
        public function getproduct_feathered(){
            $query = "SELECT * FROM tbl_product where type = '1' order by productId limit 4";
            $result = $this->db->select($query);
            return $result;
        }
        
        public function getproduct_new(){
            $sp_tungtrang = 4;
            if(!isset($_GET['trang']))
            {
                $trang = 1;
            }
            else{
                $trang = $_GET['trang'];
            }
            $tung_trang = ($trang -1)*$sp_tungtrang;
            $query = "SELECT * FROM tbl_product order by productId  desc LIMIT $tung_trang,$sp_tungtrang";
            $result = $this->db->select($query);
            return $result;
        }
        public function get_all_product(){
            $query = "SELECT * FROM tbl_product";
            $result = $this->db->select($query);
            return $result;
        }
        
        public function get_details($id){
            $query = "SELECT tbl_product.*,tbl_category.catName, tbl_brand.brandName
            -- 
            from  tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId where tbl_product.productId = '$id'";
            // $query = "SELECT * from  tbl_product order by productId desc";
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestXiaomi(){
            $query = "SELECT * FROM tbl_product WHERE brandId = '18' order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestOppo(){
            $query = "SELECT * FROM tbl_product WHERE brandId = '17' order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestSamSung(){
            $query = "SELECT * FROM tbl_product WHERE brandId = '8' order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestIPhone(){
            $query = "SELECT * FROM tbl_product WHERE brandId = '9' order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
        public function get_wishlist($customer_id){
			$query = "SELECT * FROM tbl_wishlist WHERE customer_id = '$customer_id' order by id desc";
			$result = $this->db->select($query);
			return $result;
		}
        public function insertWishlist($productId,$customer_id)
        {
            $quantity = mysqli_real_escape_string($this->db->link,$productId);
            $customer_id = mysqli_real_escape_string($this->db->link,$customer_id);
            $check_wlist = "SELECT * FROM tbl_wishlist WHERE productId = '$productId' AND customer_id = '$customer_id'";
            $result_check_wlist = $this->db->select($check_wlist);//thực thi câu lệnh
            if(!$result_check_wlist){
                $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";//câu lệnh
                $result = $this->db->select($query)->fetch_assoc();//truy vấn , trả về mảng được lập chỉ mục chuỗi
                
                $image = $result["image"];
                $price= $result["price"];
                $productName = $result["productName"];
                $query_insert = "INSERT INTO tbl_wishlist(productId,price,image,customer_id,productName) VALUES('$productId','$price','$image','$customer_id','$productName')";
                $insert_wlist = $this->db->insert($query_insert);
                if($insert_wlist){
                    $alert = "<span class='success'>Thêm Vào Danh Sách Yêu Thích Thành Công</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Thêm Vào Danh Sách Yêu Thích Thất Bại</span>";
                    return $alert;
                }
            }
            else{
            $msg = "<span class='error'>Đã Thêm Vào Danh Sách Yêu Thích Rồi</span>";
            return $msg;
        }
        }
    }

?>    