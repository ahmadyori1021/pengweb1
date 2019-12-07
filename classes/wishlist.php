<?php

class wishlist
{
    public function addToWishlist($id, $quantity)
    {
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "SELECT * FROM products WHERE pro_id = '$id'";
        $result = db::select($query)->fetch_assoc();

        $cust_id = session::get('cust_id');
        $pro_id = $id;
        $pro_name = $result['pro_name'];
        $pro_image = $result['image'];
        $pro_price = $result['price'];
        $pro_quantity = mysqli_real_escape_string(db::conn(), $quantity);

        $idChkQuery = "SELECT * FROM wishlist WHERE cmr_id='$cust_id'";
        $chkResult = db::select($idChkQuery);
        $pro_ids = [];
        while ($id_val = $chkResult->fetch_assoc()) {
            $pro_ids[] = $id_val['pro_id'];
        }

        if (in_array($pro_id, $pro_ids)) {
            $q = "SELECT * FROM wishlist WHERE pro_id='$pro_id' AND cmr_id='$cust_id'";
            $r = db::select($q)->fetch_assoc();
            $new_quantity = $r['pro_quantity'] + $pro_quantity;
            $n_q = "UPDATE wishlist SET pro_quantity='$new_quantity' WHERE pro_id='$pro_id' AND cmr_id='$cust_id'";
            db::update($n_q);
        } else {
            $wl_query = "INSERT INTO wishlist(pro_id, cmr_id, pro_name, pro_image, pro_price, pro_quantity)
                      VALUES ('$pro_id', '$cust_id', '$pro_name', '$pro_image', '$pro_price', '$pro_quantity')";
            db::insert($wl_query);
        }

    }

    public function getWishlistProducts()
    {
        $cust_id = session::get('cust_id');
        $query = "SELECT * FROM wishlist WHERE cmr_id = '$cust_id'";
        $result = db::select($query);
        return $result;
    }

    public function countWishlistProducts(){
        $count = $this->getWishlistProducts();
        $count = $count->num_rows;
        return $count;
    }

    public function wlProDelete($id)
    {
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "DELETE FROM wishlist WHERE id = '$id'";
        db::delete($query);
    }

    public function productTransferToCart($pro_id)
    {
        $pro_id = mysqli_real_escape_string(db::conn(), $pro_id);
        $query = "SELECT * FROM wishlist WHERE id='$pro_id'";
        $result = db::select($query)->fetch_assoc();
        $quantity = $result['pro_quantity'];
        return $quantity;
    }
}