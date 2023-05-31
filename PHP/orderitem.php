<?php

include 'config.php';

session_start();

if(!isset($_POST['submit'])){
    header( "Location: ../productList.php?id={$_SESSION['id_bisnis_partner']}" );

}else{
    
    //Global buat id_order
    $id_order = $_POST['id_order'];
    
    //Orderitem
    $id_user = $_SESSION['id_user'];
    $order_date = $_POST['order_date'];
    $status = $_POST['status'];

    //Detail
    $id_product = $_SESSION['id_product'];
    $quantity = $_POST['quantity'];
    $temporary_price = str_replace(".", "", $_SESSION['price']);

    $total_price = $quantity * $temporary_price;
    
    //Database Order
    $sqlO= "INSERT INTO orderitem(id_order,id_user,total_price,order_date,status)VALUES('$id_order','$id_user',$total_price,'$order_date','$status')";
    $resultO = mysqli_query($conn,$sqlO);
    
    //Databse Detail
    $sqlD= "INSERT INTO detail(id_order,id_product,quantity,temporary_price)VALUES('$id_order','$id_product','$quantity','$temporary_price')";
    $resultD = mysqli_query($conn,$sqlD);
    header( "Location:../productList.php?id={$_SESSION['id_bisnis_partner']}" );
    
    
}

?>