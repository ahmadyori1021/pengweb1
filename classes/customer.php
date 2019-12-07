<?php

class customer
{
    public function customerRegistration($data)
    {
        $name = mysqli_real_escape_string(db::conn(), $data['name']);
        $email = mysqli_real_escape_string(db::conn(), $data['email']);
        $password = mysqli_real_escape_string(db::conn(), $data['password']);
        $Cpassword = mysqli_real_escape_string(db::conn(), $data['Cpassword']);
        $phone = mysqli_real_escape_string(db::conn(), $data['phone']);
        $address = mysqli_real_escape_string(db::conn(), $data['address']);

        $exist_q = "SELECT customer_email FROM customer WHERE customer_email = '$email'";
        $exist_r = db::select($exist_q);
        $exist_email = mysqli_num_rows($exist_r);

        if ($name == "" || $email == "" || $password == "" || $Cpassword == "" || $phone == "" || $address == "") {
            return "<div class='alert alert-danger'>Please fill out this field !</div>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "<div class='alert alert-danger'>Invalid email format !</div>";
        } elseif ($exist_email == true) {
            return "<div class='alert alert-danger'>Email already exist ! Please try another email.</div>";
        } else {
            if ($password == $Cpassword) {
                $pass = md5($Cpassword);
                $query = "INSERT INTO customer(customer_name, customer_email, customer_password, customer_phone, customer_address, activation_status) 
                          VALUES ('$name', '$email', '$pass', '$phone', '$address', 'No')";
                $result = db::insert($query);
                if ($result) {
                    return "<div class='alert alert-success'>Registration successful.</div>";
                } else {
                    return "<div class='alert alert-success'>Registration failed ! Try again.</div>";
                }
            } else {
                return "<div class='alert alert-danger'>Password not matched !</div>";
            }
        }
    }

    public function activation_yes()
    {
        $cust_id = session::get('cust_id');
        $query = "UPDATE customer SET activation_status = 'Yes' WHERE customer_id = '$cust_id'";
        db::update($query);
    }

    public function activation_no()
    {
        $cust_id = session::get('cust_id');
        $query = "UPDATE customer SET activation_status = 'No' WHERE customer_id = '$cust_id'";
        db::update($query);
    }

    public function enable($id)
    {
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "UPDATE customer SET enable_disable = 'Enable' WHERE customer_id = '$id'";
        db::update($query);
    }

    public function disable($id)
    {
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "UPDATE customer SET enable_disable = 'Disable' WHERE customer_id = '$id'";
        db::update($query);
    }

    public function login($data)
    {
        $email = mysqli_real_escape_string(db::conn(), $data['email']);
        $password = mysqli_real_escape_string(db::conn(), $data['password']);
        $pass = md5($password);

        $q = "SELECT * FROM customer WHERE customer_email = '$email' AND customer_password = '$pass'";
        $r = db::select($q);
        $row = mysqli_num_rows($r);
        $v = $r->fetch_assoc();

        if ($row > 0) {
            if ($v['enable_disable'] == 'Enable') {
                session::set('cust_login', true);
                session::set('cust_id', $v['customer_id']);
                session::set('cust_name', $v['customer_name']);
                session::set('cust_email', $v['customer_email']);
                if (!empty($data['remember'])) {
                    setcookie('cust_email', $email, time() + (60 * 60 * 24 * 15));
                    setcookie('cust_pass', $password, time() + (60 * 60 * 24 * 15));
                } else {
                    if (isset($_COOKIE['cust_email'])) {
                        setcookie('cust_email', '');
                    }
                    if (isset($_COOKIE['cust_pass'])) {
                        setcookie('cust_pass', '');
                    }
                }

                $this->activation_yes($v['customer_id']);
                echo "<script>window.location = 'home.php'</script>";
            }else{
                return "<div class='alert alert-danger'>Sorry, your account already disabled ! Please contact with admin.</div>";
            }
        } else {
            return "<div class='alert alert-danger'>Email or Password was invalid !</div>";
        }
    }

    public function logout()
    {
        $this->activation_no($_SESSION['cust_id']);
        unset($_SESSION['cust_login']);
        unset($_SESSION['cust_id']);
        unset($_SESSION['cust_name']);
        echo '<script>window.location = "index.php"</script>';
    }

    public function customersData()
    {
        $query = "SELECT * FROM customer";
        $result = db::select($query);
        return $result;
    }

    public function profile()
    {
        $cust_id = session::get('cust_id');
        $query = "SELECT * FROM customer WHERE customer_id = '$cust_id'";
        $result = db::select($query)->fetch_assoc();
        return $result;
    }

    public function updateProfile($data)
    {
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $address = $data['address'];
        $cust_id = session::get('cust_id');
        $query = "UPDATE customer SET customer_name = '$name', customer_email = '$email', customer_phone = '$phone', customer_address = '$address' WHERE customer_id = '$cust_id'";
        db::update($query);
    }

    public function order()
    {
        $cust_id = session::get('cust_id');
        foreach ($_SESSION['cart'] as $key => $item) {
            $pro_id = $item['pro_id'];
            $name = $item['pro_name'];
            $quantity = $item['pro_quantity'];
            $price = $item['pro_price'];
            $image = $item['pro_image'];

            $query = "INSERT INTO orders(cmr_id, pro_id, pro_name, quantity, price, image, order_date, status) VALUES 
                      ('$cust_id', '$pro_id', '$name', '$quantity', '$price', '$image', now(), 0)";
            db::insert($query);
        }
        unset($_SESSION['cart']);
    }

    public function getOrders(){
        $cust_id = session::get('cust_id');
        $query = "SELECT * FROM orders WHERE cmr_id = '$cust_id'";
        $result = db::select($query);
        return $result;
    }

    public function customerOrders($cmr_id){
        $query = "SELECT orders.*, customer.customer_name, customer.customer_phone, customer.customer_address, products.pro_name 
                  FROM orders 
                  INNER JOIN customer 
                  ON orders.cmr_id = customer.customer_id 
                  INNER JOIN products 
                  ON orders.pro_id = products.pro_id 
                  WHERE orders.cmr_id = '$cmr_id'";
        $result = db::select($query);
        return $result;
    }

    public function customerDistinctOrders(){
        $query = "SELECT c.* FROM customer AS c 
                  INNER JOIN
                  (SELECT DISTINCT cmr_id FROM orders) AS o 
                  ON c.customer_id = o.cmr_id ";
        $result = db::select($query);
        return $result;
    }

    public function shift_info($cmr_id){
        $query = "UPDATE orders SET status = 1 WHERE cmr_id = '$cmr_id'";
        db::update($query);
    }

    public function cust_order_confirm($id){
        $query = "UPDATE orders SET status = 2 WHERE cmr_id = '$id'";
        db::update($query);
    }

    public function deleteShiftedPro(){
        $query = "DELETE FROM orders WHERE status = 2";
        db::delete($query);
    }

    public function newOrderRows(){
        $cust_id = session::get('cust_id');
        $query = "SELECT * FROM orders WHERE status=1 AND cmr_id='$cust_id'";
        $result = db::select($query);
        $rows = mysqli_num_rows($result);
        return $rows;
    }

    public function cmrOrderRows(){
        $query = "SELECT * FROM orders WHERE status = '0'";
        $result = db::select($query);
        $result = $result->num_rows;
        return $result;
    }

    public function cmrOrderConfirmation(){
        $query = "SELECT * FROM orders WHERE status = '2'";
        $result = db::select($query);
        $result = $result->num_rows;
        return $result;
    }

    public function changePassword($data){
        $old_password = $data['oldPassword'];
        $new_pass = $data['newPassword'];
        $confirm_new_pass = $data['confirmNewPassword'];
        $cust_id = session::get('cust_id');
        $cust_email = session::get('cust_email');
        if ($old_password == '' || $new_pass == '' || $confirm_new_pass == ''){
            return "<div class='alert alert-danger'>Please fill out this field !</div>";
        }else{
            $old_pass = md5($old_password);
            $query = "SELECT customer_password FROM customer WHERE customer_email = '$cust_email' AND customer_password = '$old_pass'";
            $result = db::select($query);
            $result = $result->num_rows;

            if ($result > 0){
                if ($new_pass == $confirm_new_pass){

                    $confirm_pass = md5($new_pass);

                    $update_q = "UPDATE customer SET customer_password = '$confirm_pass' WHERE customer_id = '$cust_id'";
                    $change = db::update($update_q);
                    if ($change){
                        return "<div class='alert alert-success'>Password changed successfully.</div>";
                    }else{
                        return "<div class='alert alert-danger'>Password change failed!</div>";
                    }
                }
            }else{
                return "<div class='alert alert-danger'>Password not matched !</div>";
            }
        }
    }

}