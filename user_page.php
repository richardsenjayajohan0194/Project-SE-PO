<?php

include 'PHP/config.php';

session_start();

if(!isset($_SESSION['user_name'])){
    header('location:login.php');

}else{
    $sqlFNB = "SELECT * FROM bisnis_partner WHERE category='Food and Beverage'";
    $dataFNB = mysqli_query($conn,$sqlFNB);
    $checkFNB = mysqli_num_rows($dataFNB);
    
    $sqlFashion = "SELECT * FROM bisnis_partner WHERE category='Fashion'";
    $dataFashion = mysqli_query($conn,$sqlFashion);
    $checkFashion = mysqli_num_rows($dataFashion);
    
    $id_user = $_SESSION['id_user'];
    $sqlJoin = "SELECT ord.*,pro.product_name, pro.image_product,det.id_product, det.quantity, det.temporary_price FROM orderitem ord,product pro,detail det WHERE ord.id_order=det.id_order AND pro.id_product=det.id_product AND ord.status='No Payment Validation' AND ord.id_user=$id_user";
    $dataJoin = mysqli_query($conn,$sqlJoin);
    $checkJoin =  mysqli_num_rows($dataJoin);

    $price = 0;
    $sqlHistory = "SELECT ord.*,pro.product_name, pro.image_product,det.id_product, det.quantity, det.temporary_price FROM orderitem ord,product pro,detail det WHERE ord.id_order=det.id_order AND pro.id_product=det.id_product AND ord.status='Delivery' AND ord.id_user=$id_user OR ord.id_order=det.id_order AND pro.id_product=det.id_product AND ord.status='Payment Validation' AND ord.id_user=$id_user";
    $dataHistory = mysqli_query($conn,$sqlHistory);
    $checkHistory =  mysqli_num_rows($dataHistory);
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/styleUser_Page.css">
</head>
<body>
    <header>
        <img class="logo" src="Images/Logo.png" alt="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="user_page.php">HOME</a></li>
                <li><a href="user_page.php">PRODUCT</a></li>
                <li><a href="">ABOUT</a></li>
            </ul>
        </nav>
        <div class="dropdown">
            <ion-icon name="cart-outline" class="cart"></ion-icon>
            <div class="dropdown-content">
            <p class="shopping_cart">Shopping Cart</p>
                <?php if($checkJoin != 0){?>
                    <?php 
                        while($rowJoin = mysqli_fetch_assoc($dataJoin)){
                    ?>  
                        <div class="order_details">
                        <form action="PHP/cancel.php?id=<?php echo $rowJoin['id_order']?>" method="POST">
                            <div style="display: flex;">
                                <div class="o_part1">
                                    <img class="order_image" src="Images/<?=$rowJoin['image_product']?>" alt="">
                                </div>
                                <div class="o_part2">
                                    <p class="order_name"><?php echo $rowJoin['product_name']?></p>
                                    <p class="order_date">Delivery Date : <?php echo $rowJoin['order_date']?></p>
                                    <p class="order_quantity">Quantity : <?php echo $rowJoin['quantity']?></p>
                                    <p class="order_price">Price : Rp <?php echo number_format($rowJoin['temporary_price'],0,',','.');?>,00</p>
                                </div>
                            </div>
                            <div>
                                <button class="cancel_btn" name="submit">Cancel</button>
                            </div>
                        </div>
                        </form>
                        <?php $price = $price + $rowJoin['total_price']?> 
                    <?php }?>
                    <form action="PHP/payment.php?id_user=<?php echo $_SESSION['id_user']?>" method="POST">
                    <div>
                        <p class="order_total_price">Total Price : RP <?php echo number_format($price,0,',','.');?>,00</p>
                        <button class="payment_btn" name="submit">Confirm Payment</button>
                    </div>
                    </form>
                <?php } else {?><p class="no_product">No Data</p><?php }?>
            </div>
        </div>

        <div class="dropdown">
        <ion-icon name="list-circle-outline" class="history"></ion-icon>
            <div class="dropdown-content">
            <p class="history_list">History</p>
                <?php if($checkHistory != 0){?>
                    <form action="" method="POST">
                    <?php 
                        while($rowHistory = mysqli_fetch_assoc($dataHistory)){
                    ?>
                        <div class="order_details">
                            <div style="display: flex;">
                                <div class="o_part1">
                                    <img class="order_image" src="Images/<?=$rowHistory['image_product']?>" alt="">
                                </div>
                                <div class="o_part2">
                                    <p class="order_name"><?php echo $rowHistory['product_name']?></p>
                                    <p class="order_date">Delivery Date : <?php echo $rowHistory['order_date']?></p>
                                    <p class="order_status">Status : <?php echo $rowHistory['status']?></p>
                                    <p class="order_quantity">Quantity : <?php echo $rowHistory['quantity']?></p>
                                    <p class="order_price">Price : Rp <?php echo number_format($rowHistory['temporary_price'],0,',','.');?>,00</p>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </form>
                <?php } else {?><p class="no_product">No Data</p><?php }?>
            </div>
        </div>
        <nav>
            <ul class="welcome">
                <li><p class="welcome_text">Welcome,</p></li>
                <li><p class="user_text"><?php echo $_SESSION['user_name']?></p></li>
            </ul>
        </nav>
        <a class="signout" href="PHP/logout.php">SIGN OUT</a>
    </header>
    <section>
        <div class="description">
            <div class="d_text">
                <p class="d_text1">Pre-Ordering System For Shop</p>
                <p class="d_text2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nulla lorem, efficitur eget convallis pellentesque, aliquam sed libero. Mauris eu dignissim nunc. Sed vel enim ultricies, ultrices sapien nec, imperdiet mauris.</p>
            </div>
            <img class="img" src="Images/IMG1.png" alt="IMG">
        </div>
        <?php if($checkFNB >= 1){?>
        <div class="fnb_business">
            <p class="fnb_text">FNB Business</p>
            <div class="list_fnb">
                <?php 
                while($row1 = mysqli_fetch_assoc($dataFNB)){
                ?>
                <div class="product_details">
                    <img class="images" src="Images/<?=$row1['logo']?>" alt="">
                    <p  class="fnb_name" onclick="location.href='productList.php?id=<?php echo $row1['id_bisnis_partner']?>'"><?php echo $row1['bisnis_partner_name']?></p>
                </div>
                <?php }?>
            </div>
        </div>
        <?php }?>
        <?php if($checkFashion >= 1){?>
        <div class="fashion_business">
            <p class="fashion_text">Fashion Business</p>
            <div class="list_fashion">
                <?php 
                while($row2 = mysqli_fetch_assoc($dataFashion)){
                ?>
                <div class="product_details">
                    <img class="images" src="Images/<?=$row2['logo']?>" alt="">
                    <p class="fashion_name" onclick="location.href='productList.php?id=<?php echo $row2['id_bisnis_partner']?>'"><?php echo $row2['bisnis_partner_name']?></p>
                </div>
                <?php }?>
            </div>
        </div>
        <?php }?>
    </section>
    <footer>
        <div class="service">
            <h1>Customer Service</h1>
            <div class="isi">   
                <label for="">Help Center</label>
            </div>
            <div class="isi">
                <label for="">Return & Refund</label>
            </div>
            <div class="isi">
                <label for="">Contact Us</label>
            </div>
         </div>
         <div class="about">
            <h1>About PONow</h1>
            <div class="isi">
                <label for="">About Us</label>
            </div>
            <div class="isi">
                <label for="">Terms and Condition</label>
            </div>
            <div class="isi">
                <label for="">Privacy</label>
            </div>
         </div>
         <div class="follow">
            <h1>Follow Us</h1>
            <div class="us">
                <img src="Images/Facebook Logo.png">
            </div>
            <div class="us">
                <img src="Images/Instagram Logo.png">
            </div>
            <div class="us">
                <img src="Images/Pinterest Logo.png">
            </div>
            <div class="us">
                 <img src="Images/Twitter Logo.png">
            </div>
         </div>
    </footer>
</body>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>