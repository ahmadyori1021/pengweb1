<?php

class product
{
    public function getProducts()
    {
        $query = "SELECT products.*, brands.brand_name, categories.cat_name 
                    FROM products 
                    INNER JOIN brands 
                    ON products.brand_id = brands.id 
                    INNER JOIN categories 
                    ON products.cat_id = categories.id 
                    ORDER BY products.pro_id DESC";
        $result = db::select($query);
        return $result;
    }

    public function getFeaturedProducts()
    {
        $query = "SELECT products.*, brands.brand_name, categories.cat_name 
                    FROM products 
                    INNER JOIN brands 
                    ON products.brand_id = brands.id 
                    INNER JOIN categories 
                    ON products.cat_id = categories.id 
                    WHERE type = 0 LIMIT 3";
        $result = db::select($query);
        return $result;
    }

    public function getNewProducts($start, $limit)
    {
        // $query = "SELECT products.*, brands.brand_name, categories.cat_name 
        //             FROM products 
        //             INNER JOIN brands 
        //             ON products.brand_id = brands.id 
        //             INNER JOIN categories 
        //             ON products.cat_id = categories.id 
        //             WHERE type = 1 LIMIT '$limit'";
        $query = "SELECT * FROM 
                    (SELECT products.*, brands.brand_name, categories.cat_name 
                    FROM products 
                    INNER JOIN brands 
                    ON products.brand_id = brands.id 
                    INNER JOIN categories 
                    ON products.cat_id = categories.id 
                    WHERE type = 1) AS mytbl limit $start, $limit";
        $result = db::select($query);
        return $result;
    }

    public function getNewProductsForPagination()
    {
        $query = "SELECT products.*, brands.brand_name, categories.cat_name 
                    FROM products 
                    INNER JOIN brands 
                    ON products.brand_id = brands.id 
                    INNER JOIN categories 
                    ON products.cat_id = categories.id 
                    WHERE type = 1";

        $result = db::select($query);
        $countRows = $result->num_rows;
        $total_pages = ceil($countRows / 6);
        return $total_pages;
    }

    public function getProductById($id)
    {
        $id = mysqli_real_escape_string(db::conn(), $id);
        $query = "SELECT products.*, brands.brand_name, categories.cat_name FROM products INNER JOIN brands ON products.brand_id = brands.id INNER JOIN categories ON products.cat_id = categories.id WHERE products.pro_id = '$id'";
        $result = db::select($query)->fetch_assoc();
        return $result;
    }

    public function deleteProduct($id)
    {
        $id = mysqli_real_escape_string(db::conn(), $id);
        $pro_get_q = "SELECT * FROM products WHERE pro_id = '$id'";
        $result = db::select($pro_get_q);
        $value = $result->fetch_assoc();
        $img_unlink = "../" . $value['image'];
        unlink($img_unlink);
        $query = "DELETE FROM products WHERE pro_id = '$id'";
        db::delete($query);
    }

    public function addNewProduct($data, $file)
    {
        $pro_name = mysqli_real_escape_string(db::conn(), $data['pro_name']);
        $cat_id = mysqli_real_escape_string(db::conn(), $data['cat_id']);
        $brand_id = mysqli_real_escape_string(db::conn(), $data['brand_id']);
        $price = mysqli_real_escape_string(db::conn(), $data['price']);
        $description = mysqli_real_escape_string(db::conn(), $data['description']);
        $type = mysqli_real_escape_string(db::conn(), $data['type']);

        $file_name = $file['image']['name'];
        $file_tmp = $file['image']['tmp_name'];

        $divide_extention = explode('.', $file_name);
        foreach ($divide_extention as $key => $item) {
            if ($key == 0) {
                $with_name = $item;
            }
        }
        $file_extention = strtolower(end($divide_extention));
        $unique_name = substr(md5(time()), 0, 3) . "." . $file_extention;
        $uploaded_image = "images/" . $with_name . "_" . $unique_name;

        if ($pro_name == '' || $cat_id == '' || $brand_id == '' || $price == '' || $description == '' || $type == '') {
            return "<div class='alert alert-danger'>Please fill out this field !</div>";
        } else {
            move_uploaded_file($file_tmp, "../" . $uploaded_image);
            $query = "INSERT INTO products(pro_name,cat_id,brand_id,price,description,image,type) VALUES ('$pro_name', '$cat_id', '$brand_id', '$price', '$description', '$uploaded_image', '$type')";
            $result = db::insert($query);
            if ($result) {
                return "<div class='alert alert-success'>Product added successfully.</div>";
            } else {
                return "<div class='alert alert-danger'>Product not added !</div>";
            }
        }
    }

    public function updateProduct($data, $file, $pro_id)
    {
        $pro_id = mysqli_real_escape_string(db::conn(), $pro_id);
        $pro_name = mysqli_real_escape_string(db::conn(), $data['pro_name']);
        $cat_id = mysqli_real_escape_string(db::conn(), $data['cat_id']);
        $brand_id = mysqli_real_escape_string(db::conn(), $data['brand_id']);
        $price = mysqli_real_escape_string(db::conn(), $data['price']);
        $description = mysqli_real_escape_string(db::conn(), $data['description']);
        $type = mysqli_real_escape_string(db::conn(), $data['type']);

        $file_name = $file['image']['name'];
        $file_tmp = $file['image']['tmp_name'];

        $divide_extention = explode('.', $file_name);
        foreach ($divide_extention as $key => $item) {
            if ($key == 0) {
                $with_name = $item;
            }
        }
        $file_extention = strtolower(end($divide_extention));
        $unique_name = substr(md5(time()), 0, 3) . "." . $file_extention;
        $uploaded_image = "images/" . $with_name . "_" . $unique_name;

        if (!empty($file_name)) {
            $pro_get_q = "SELECT * FROM products WHERE pro_id = '$pro_id'";
            $result = db::select($pro_get_q);
            $value = $result->fetch_assoc();
            $img_unlink = "../" . $value['image'];
            unlink($img_unlink);

            move_uploaded_file($file_tmp, "../" . $uploaded_image);
            $query = "UPDATE products 
                        SET 
                        pro_name = '$pro_name', 
                        cat_id = '$cat_id',
                        brand_id = '$brand_id',
                        price = '$price',
                        description = '$description',
                        image = '$uploaded_image',
                        type = '$type' WHERE pro_id = '$pro_id'";
            $result = db::update($query);
            if ($result) {
                return "<div class='alert alert-success'>Product updated successfully.</div>";
            } else {
                return "<div class='alert alert-danger'>Product not updated !</div>";
            }
        } else {

            $query = "UPDATE products 
                        SET 
                        pro_name = '$pro_name', 
                        cat_id = '$cat_id',
                        brand_id = '$brand_id',
                        price = '$price',
                        description = '$description',
                        type = '$type' WHERE pro_id = '$pro_id'";
            $result = db::update($query);
            if ($result) {
                return "<div class='alert alert-success'>Product updated successfully.</div>";
            } else {
                return "<div class='alert alert-danger'>Product not updated !</div>";
            }
        }
    }

    public function getProductsByCategory($cat_id)
    {
        $cat_id = mysqli_real_escape_string(db::conn(), $cat_id);
        $query = "SELECT products.*, brands.brand_name, categories.cat_name FROM products INNER JOIN brands ON products.brand_id = brands.id INNER JOIN categories ON products.cat_id = categories.id WHERE cat_id = '$cat_id'";
        $result = db::select($query);
        return $result;
    }

    public function getProductsByBrand($brand_id)
    {
        $brand_id = mysqli_real_escape_string(db::conn(), $brand_id);
        $query = "SELECT products.*, brands.brand_name, categories.cat_name FROM products INNER JOIN brands ON products.brand_id = brands.id INNER JOIN categories ON products.cat_id = categories.id WHERE brand_id = '$brand_id'";
        $result = db::select($query);
        return $result;
    }

    public function searchProduct($keyword)
    {
        $keyword = mysqli_real_escape_string(db::conn(), $keyword);
        $query = "SELECT products.*, brands.brand_name, categories.cat_name FROM products 
              INNER JOIN brands 
              ON products.brand_id = brands.id 
              INNER JOIN categories 
              ON products.cat_id = categories.id 
              WHERE products.pro_name LIKE '%$keyword%' 
              OR products.price LIKE '%$keyword%'
              OR products.description LIKE '%$keyword%'";
        $result = db::select($query);
        return $result;
    }

    public function detectSearchWord($keyword, $subject)
    {
        $replace = "<span style='background-color: yellow;'>".$keyword."</span>";
        $result = str_ireplace($keyword, $replace, $subject);
        return $result;
    }


}