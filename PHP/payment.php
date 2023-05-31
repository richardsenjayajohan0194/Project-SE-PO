<?php

include 'config.php';

session_start();

if(!isset($_POST['submit'])){
    header( "Location: ../user_page.php" );

}else{
    
    $id_user = $_SESSION['id_user'];
    $sqlO = "SELECT * FROM orderitem WHERE id_user=$id_user";
    $dataO = mysqli_query($conn,$sqlO);
    $checkO =  mysqli_num_rows($dataO);
    
    if($checkO != 0){
        while($rowO = mysqli_fetch_assoc($dataO)){
            if($rowO['status'] == 'No Payment Validation'){
                  $sqlUpdate = "UPDATE orderitem SET status = 'Payment Validation' WHERE id_user = $id_user";
                  $resultUpdate = mysqli_query($conn,$sqlUpdate);
            }
        }
        header( "Location: ../user_page.php" );
    }
    
                
    
    
}

?>