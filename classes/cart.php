<?php

class cart
{
    public function add_to_cart($id, $quantity){
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "SELECT * FROM products WHERE pro_id = '$id'";
        $result = db::select($query)->fetch_assoc();

        if (isset($_SESSION['cart'])){
            $count = count($_SESSION['cart']);
            $pro_ids = array_column($_SESSION['cart'], 'pro_id');
            if (!in_array($id, $pro_ids)){
                $_SESSION['cart'][$count] = array(
                    "pro_id" => $id,
                    "pro_name" => $result['pro_name'],
                    "pro_image" => $result['image'],
                    "pro_price" => $result['price'],
                    "pro_quantity" => $quantity
                );
            }else{
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['pro_id'] == $id){
                        $_SESSION['cart'][$key]['pro_quantity'] += $quantity;
                    }
                }
            }
        }else{
            $_SESSION['cart'][0] = array(
                "pro_id" => $id,
                "pro_name" => $result['pro_name'],
                "pro_image" => $result['image'],
                "pro_price" => $result['price'],
                "pro_quantity" => $quantity
            );
        }
    }
}