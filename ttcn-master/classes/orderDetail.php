<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/dbhelper.php');

class orderDetail
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function insert_order_detail($data, $orderId)
    {
        $productId = $data["productId"];
        $quantity = $data["quantity"];
        $price = $data["price"];
        $totalPrice = $data["totalPrice"];

        $query = "INSERT INTO tbl_orderdetail (productId, orderId, quantity, price, totalPrice) VALUES" .
            "('$productId','$orderId','$quantity','$price','$totalPrice')";
        $this->db->insert($query);
    }

    public function get_detail_by_orderId($orderId)
    {
        $query = "SELECT tbl_orderdetail.*, tbl_product.productName, tbl_product.image
            from tbl_orderdetail INNER JOIN tbl_product ON tbl_orderdetail.productId = tbl_product.productId where orderId = '$orderId'";
        return $this->db->select($query);
    }
}
