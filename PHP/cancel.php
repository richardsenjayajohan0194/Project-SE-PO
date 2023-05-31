<?php

include 'config.php';

session_start();

if(!isset($_POST['submit'])){
    header( "Location: user_page.php" );

}else{
    
    $id_order = $_GET['id'];
    echo 'Id_order : ' . $id_order;
    $sqlD = "SELECT * FROM detail WHERE id_order='$id_order'";
    $dataD = mysqli_query($conn,$sqlD);
    $checkD =  mysqli_num_rows($dataD);

    $sqlO = "SELECT * FROM orderitem WHERE id_order='$id_order'";
    $dataO = mysqli_query($conn,$sqlO);
    $checkO =  mysqli_num_rows($dataO);
    
    if($checkD == $checkO){
        while($rowD = mysqli_fetch_assoc($dataD)){
            $sqlCancelD = "DELETE FROM detail WHERE id_order='$id_order'";
            $resultCancelD = mysqli_query($conn,$sqlCancelD);
            
        }
        while($rowO = mysqli_fetch_assoc($dataO)){
            if($rowO['status'] == 'No Payment Validation'){
                $sqlCancelO = "DELETE FROM orderitem WHERE id_order='$id_order'";
                $resultCancelO = mysqli_query($conn,$sqlCancelO);
            }    
        }
        header( "Location: ../user_page.php" );
    }
    header( "Location: ../user_page.php" );
                
    
    
}

?>