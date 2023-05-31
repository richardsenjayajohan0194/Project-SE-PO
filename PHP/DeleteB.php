<?php 

$id_Bisnis = $_GET['id'];

//include(dbconnect.php);
include('config.php');

//cari data foto
$sql1 = "SELECT * FROM bisnis_partner WHERE id_bisnis_partner = '$id_Bisnis' ";

$result = mysqli_query($conn, $sql1);

$row =  mysqli_fetch_assoc($result);

$image = $row['files'];
$file_foto = "Images/$image";

//Buat nyari apahkah ada foto ga di databasenya
if(file_exists($file_foto)){
    unlink($file_foto);

    //query hapus
    $sql = "DELETE FROM bisnis_partner WHERE id_bisnis_partner = '$id_Bisnis' ";

    if (mysqli_query($conn , $sql)) {
        # redirect ke index.php
        header("location:../AdminViewB.php");
    }
    else{
        echo "ERROR, data gagal dihapus". mysqli_error($conn);
    }

mysqli_close($conn);
}


?>