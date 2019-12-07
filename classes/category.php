<?php

class category
{
    public function getCategories(){
        $query = "SELECT * FROM categories ORDER BY id DESC";
        $result = db::select($query);
        return $result;
    }

    public function getCategoryById($id){
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "SELECT * FROM categories where id = '$id'";
        $result = db::select($query)->fetch_assoc();
        return $result;
    }

    public function addNewCategory($category_name){
        if (empty($category_name)){
            return "<div class='alert alert-danger'>Please fill out this field !</div>";
        }
        $category_name = mysqli_real_escape_string(db::conn(), $category_name);
        $query = "INSERT INTO categories(cat_name) VALUES ('$category_name')";
        $result = db::insert($query);
        if ($result){
            return "<div class='alert alert-success'>Category added successfully.</div>";
        }else{
            return "<div class='alert alert-danger'>Category not added ! Try again.</div>";
        }
    }

    public function updateCategory($id, $category_name){
        $id = mysqli_real_escape_string(db::conn(), $id);
        $category_name = mysqli_real_escape_string(db::conn(), $category_name);
        $query = "UPDATE categories SET cat_name = '$category_name' where id = '$id'";
        $result = db::update($query);
        if ($result){
            return "<div class='alert alert-success'>Category updated successfully.</div>";
        }else{
            return "<div class='alert alert-danger'>Category not updated ! Try again.</div>";
        }
    }

    public function deleteCategory($id){
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "DELETE FROM categories WHERE id = '$id'";
        db::delete($query);
    }
}