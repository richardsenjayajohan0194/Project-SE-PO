<?php
include('config.php');
session_start();

if(isset($_POST['upload'])){
    $id_Bisnis = $_POST['id'];
    $username = $_POST['seller_business'];
    $address = $_POST['address'];
    $phone = $_POST['phone_num'];
    $city = $_POST['city'];
    $nama_bisnis =  mysqli_real_escape_string($conn,$_POST['bisnis_partner_name']);

    $imagefile = "Images/";
    // $name = basename($_FILES["new_image"]["name"]); //namafile image
    $old_image= $_POST['logo'];
    
    

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
            echo "Data yang anda berikan salah harus berupa format jpg, png, jpeg";
            header('location:AdminViewB.php');
        }
       
    }else{
        //Jika tidak ada gambar yang di uploaad maka gunakan gambar lamanya
        $filename = $old_image;
    }

    $sql = "UPDATE bisnis_partner SET seller_business='$username' , address='$address', phone_num='$phone', city='$city', bisnis_partner_name='$nama_bisnis' , logo='$filename'  WHERE id_bisnis_partner='$id_Bisnis' ";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Data berhasil diupdate";
        header('location:../AdminViewB.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        header('location:../AdminViewB.php');
    }
      
    mysqli_close($conn);
}

?> 