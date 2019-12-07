<?php

class admin
{
    public function login($data){
        $username = mysqli_real_escape_string(db::conn(), $data['username']);
        $password = mysqli_real_escape_string(db::conn(), $data['password']);
        $hash_pass = md5($password);

        $query = "SELECT * FROM admin WHERE admin_username = '$username'AND admin_password = '$hash_pass'";
        $result = db::select($query);
        $num_rows = $result->num_rows;
        $result = $result->fetch_assoc();

        if ($num_rows > 0){
            session::set('adminLogin', true);
            session::set('adminName', $result['admin_name']);
            session::set('adminId', $result['admin_id']);

            echo "<script>window.location = 'dashboard.php'</script>";
        }else{
            return "<div class='alert alert-danger'>Email or Password was incorrect !</div>";
        }
    }

    public function adminProfile()
    {
        $adminId = session::get('adminId');
        $query = "SELECT * FROM admin WHERE admin_id = '$adminId'";
        $result = db::select($query)->fetch_assoc();
        return $result;
    }

    public function updateAdminProfile($data){
        $name = $data['name'];
        $email = $data['email'];
        $username = $data['username'];
        $adminId = session::get('adminId');
        $query = "UPDATE admin SET admin_name = '$name', admin_email = '$email', admin_username = '$username' WHERE admin_id = '$adminId'";
        db::update($query);
    }

    public function adminChangePassword($data){
        $old_password = $data['oldPassword'];
        $new_pass = $data['newPassword'];
        $confirm_new_pass = $data['confirmNewPassword'];
        $admin_id = session::get('adminId');
        $admin_name = session::get('adminName');

        if ($old_password == '' || $new_pass == '' || $confirm_new_pass == ''){
            return "<div class='alert alert-danger'>Please fill out this field !</div>";
        }else{
            $old_pass = md5($old_password);
            $query = "SELECT admin_password FROM admin WHERE admin_name = '$admin_name' AND admin_password = '$old_pass'";
            $result = db::select($query);
            $result = $result->num_rows;

            if ($result > 0){
                if ($new_pass == $confirm_new_pass){

                    $confirm_pass = md5($new_pass);

                    $update_q = "UPDATE admin SET admin_password = '$confirm_pass' WHERE admin_id = '$admin_id'";
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