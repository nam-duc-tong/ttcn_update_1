<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/dbhelper.php');
require_once('orderDetail.php');

class order
{
    private $db;
    private $fm;
    private $od;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new format();
        $this->od = new orderDetail();
    }

    public function insert_order($customerId)
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $cart = $this->db->select($query);

        $total = 0;
        $orderDetailArray = array();
        if ($cart) {
            while ($result = $cart->fetch_assoc()) {
                $productId = $result['productId'];
                $quantity = $result['quantity'];
                $price = $result['price'];
                $totalPrice = $price * $quantity;

                $total += $totalPrice;
                $orderDetail = array(
                    "productId" => $productId,
                    "quantity" => $quantity,
                    "totalPrice" => $totalPrice,
                    "price" => $price,
                );
                array_push($orderDetailArray, $orderDetail);
            }
            $Id = $this->db->insert_getLastId("INSERT INTO tbl_order " .
                "(customer_Id, total) VALUES " .
                "('$customerId', '$total')");

            foreach ($orderDetailArray as $i) {
                $this->od->insert_order_detail($i, $Id);
            }
        }
    }

    public function get_order()
    {
        $query = "SELECT * FROM tbl_order";
        return $this->db->select($query);
    }

    public function status_toString($status)
    {
        switch ($status) {
            case 0:
                return "Chờ xác nhận";
            case 1:
                return "Đã xác nhận";
            case 2:
                return "Đang giao hàng";
            case 3:
                return "Giao thành công";
            case 4:
                return "Đã hủy đơn";
        }
    }

    public function get_order_by_date($from, $to)
    {
        $query = "SELECT * FROM tbl_order WHERE date_order BETWEEN '" .
            $from . " 00:00:00' AND '" .
            $to . " 23:59:59' ORDER BY date_order";
        $get_order = $this->db->select($query);
        return $get_order;
    }
    public function get_order_by_customer($customer_Id)
    {
        $query = "SELECT * FROM tbl_order WHERE customer_Id ='$customer_Id'";
        $get_cart_ordered = $this->db->select($query);
        return $get_cart_ordered;
    }
}
