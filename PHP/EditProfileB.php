<?php
include('config.php');
session_start();

if(isset($_POST['upload'])){

    //Update sessionnya di bisnis partner
    $_SESSION['id_bisnis_partner'] = $_POST['id'];
    $_SESSION['seller_business'] = $_POST['seller_business'];
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['phone_num'] = $_POST['phone_num'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['bisnis_partner_name'] = $_POST['bisnis_partner_name'];
    $_SESSION['category'] = $_POST['category'];
    $_SESSION['description'] = $_POST['description'];
    
    //Update data
    $id_Bisnis = $_POST['id'];
    $username = mysqli_real_escape_string($conn, $_POST['seller_business']);
    $address = $_POST['address'];
    $phone = $_POST['phone_num'];
    $city = $_POST['city'];
    $nama_bisnis = mysqli_real_escape_string($conn, $_POST['bisnis_partner_name']);
    $category = $_POST['category'];
    $description = $_POST['description'];

    $imagefile = "Images/";
    //dipake saat ga di update imagenya
    $old_image= $_POST['logo'];

    //Gambar baru
    $new_image=$_FILES["new_image"]["name"];
    $temp_file=$_FILES["new_image"]["tmp_name"];
    $extention = array('jpg','png','jpeg','JPG','PNG','JPEG'); //tipe image yang dadpat di ambil


    //Jika gambar baru diupload
    if($new_image != ""){
        $filename = $new_image;
        //Update di Bisnis Partner
        $image = $imagefile . $filename; //letak image yang sudah dimasukkan
        $validation = pathinfo($image,PATHINFO_EXTENSION);
        if(in_array($validation,$extention)){
            //hapus gambar lama
            unlink($imagefile.$old_image);

            //Upload gambar baru
            move_uploaded_file($temp_file,$image);
            //Update sesion logo (image) di bisnis partner
            $_SESSION['logo'] = $new_image;
        }else{
            //pake file lama kalo formatnya diluar yang seharusnya
            $filename = $old_image;
            $_SESSION['logo'] = $old_image;
            $_SESSION['msg'] = 'Wrong extension image just jpg, png, and jperg';
            header('location:../business_page.php');
        }
       
    }else{
        //Jika tidak ada gambar yang di uploaad maka gunakan gambar lamanya
        $filename = $old_image;
    }

    $sql = "UPDATE bisnis_partner SET seller_business='$username' , address='$address', phone_num='$phone', city='$city', bisnis_partner_name='$nama_bisnis', category='$category', description='$description', logo='$filename'  WHERE id_bisnis_partner='$id_Bisnis' ";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['msgsucces'] = 'The profile was successfully updated';
        header('location:../business_page.php');
    } else {
        $_SESSION['msg'] = 'The profile was not successfully updated';
        header('location:../business_page.php');
    }
      
    mysqli_close($conn);
}

?> 