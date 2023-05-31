<?php
include('config.php');
session_start();

if(isset($_POST['upload'])){
    $id_product = $_POST['id'];
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = $_POST['price'];
    $category_product = $_POST['category_product'];
    $status_product = $_POST['status_product'];
    $ingredients_product = $_POST['ingredients_product'];
    $description_product = $_POST['description_product'];

    $imagefile = "Images/";
    // $name = basename($_FILES["new_image"]["name"]); //namafile image
    $old_image= $_POST['image_product'];
    
    

    //Gambar baru
    $new_image=$_FILES["new_image"]["name"];
    $temp_file=$_FILES["new_image"]["tmp_name"];
    $extention = array('jpg','png','jpeg','JPG','PNG','JPEG'); //tipe image yang dadpat di ambil

    //Jika gambar baru diupload
    if($new_image != ""){
        $filename = $new_image;
        $image = $imagefile . $filename; //letak image yang sudah dimasukkan
        $validation = pathinfo($image,PATHINFO_EXTENSION);
        if(in_array($validation,$extention)){
            //hapus gambar lama
            unlink($imagefile.$old_image);

            //Upload gambar baru
            move_uploaded_file($temp_file,$image);
        }else{
            //pake file lama kalo formatnya diluar yang seharusnya
            $filename = $old_image;
            $_SESSION['msg'] = 'Wrong extension image just jpg, png, and jperg';
            header('location:../business_page.php');
        }
       
    }else{
        //Jika tidak ada gambar yang di uploaad maka gunakan gambar lamanya
        $filename = $old_image;
    }
    if($status_product == "Halal" || $status_product == NULL){
        $sql = "UPDATE product SET product_name='$product_name' , image_product='$filename', status_product='$status_product', ingredients_product='$ingredients_product',price='$price', category_product='$category_product', description_product='$description_product' WHERE id_product='$id_product'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['msgsucces'] = 'The product was successfully updated';
            header('location:../business_page.php');
        } else {
            $_SESSION['msg'] = 'The product was not successfully updated';
            header('location:../business_page.php');
        }
    }
    
      
    mysqli_close($conn);
}

?> 