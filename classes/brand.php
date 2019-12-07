<?php

class brand
{
    public function getBrands(){
        $query = "SELECT * FROM brands ORDER BY id DESC";
        $result = db::select($query);
        return $result;
    }

    public function getBrandById($id){
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "SELECT * FROM brands where id = '$id'";
        $result = db::select($query)->fetch_assoc();
        return $result;
    }

    public function addNewBrand($brand_name){
        if (empty($brand_name)){
            return "<div class='alert alert-danger'>Please fill out this field !</div>";
        }
        $brand_name = mysqli_real_escape_string(db::conn(), $brand_name);
        $query = "INSERT INTO brands(brand_name) VALUES ('$brand_name')";
        $result = db::insert($query);
        if ($result){
            return "<div class='alert alert-success'>Brand added successfully.</div>";
        }else{
            return "<div class='alert alert-danger'>Brand not added ! Try again.</div>";
        }
    }

    public function updateBrand($id, $brand_name){
        $id = mysqli_real_escape_string(db::conn(), $id);
        $brand_name = mysqli_real_escape_string(db::conn(), $brand_name);
        $query = "UPDATE brands SET brand_name = '$brand_name' where id = '$id'";
        $result = db::update($query);
        if ($result){
            return "<div class='alert alert-success'>Brand updated successfully.</div>";
        }else{
            return "<div class='alert alert-danger'>Brand not updated ! Try again.</div>";
        }
    }

    public function deleteBrand($id){
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "DELETE FROM brands WHERE id = '$id'";
        db::delete($query);
    }
}