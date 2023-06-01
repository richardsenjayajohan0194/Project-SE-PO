<?php

include 'config.php';

session_start();

if(!isset($_POST['submit'])){
    header( "Location: ../bussines_page.php" );

}else{
    $id_user = $_GET['id'];
    $id_order = $_GET['id_order'];
    
    $sqlO = "SELECT * FROM orderitem WHERE id_user=$id_user AND id_order='$id_order'";
    $dataO = mysqli_query($conn,$sqlO);
    $checkO =  mysqli_num_rows($dataO);
    
    if($checkO == 1){
        while($rowO = mysqli_fetch_assoc($dataO)){
            if($rowO['status'] == 'Payment Validation'){
                  $sqlUpdate = "UPDATE orderitem SET status = 'Delivery' WHERE id_user = $id_user AND id_order='$id_order'";
                  $resultUpdate = mysqli_query($conn,$sqlUpdate);
            }
        }
        header( "Location: ../business_page.php" );
    }
    
}

?>