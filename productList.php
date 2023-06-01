<?php

include 'PHP/config.php';

session_start();

if(!isset($_GET['id'])){
    header('location:user_page.php');

}else{
    $id_bisnis_partner = $_GET['id'];
    
    $sql = "SELECT * FROM bisnis_partner WHERE id_bisnis_partner=$id_bisnis_partner";
    $data = mysqli_query($conn,$sql);
    
    $row = mysqli_fetch_array($data);
    if($row['id_bisnis_partner'] == $id_bisnis_partner){
        $_SESSION['id_bisnis_partner'] = $row['id_bisnis_partner'];
        $_SESSION['seller_business'] = $row['seller_business'];
        $_SESSION['address'] = $row['address'];
        $_SESSION['phone_num'] = $row['phone_num'];
        $_SESSION['city'] = $row['city'];
        $_SESSION['bisnis_partner_name'] = $row['bisnis_partner_name'];
        $_SESSION['category'] = $row['category'];
        $_SESSION['description'] = $row['description'];
        $_SESSION['logo'] = $row['logo'];

        $sqlP = "SELECT * FROM product WHERE id_bisnis_partner=$id_bisnis_partner";
        $dataP = mysqli_query($conn,$sqlP);
        $checkP = mysqli_num_rows($dataP);
        
        $id_user = $_SESSION['id_user'];
        $sqlJoin = "SELECT ord.*,pro.product_name, pro.image_product,det.id_product, det.quantity, det.temporary_price FROM orderitem ord,product pro,detail det WHERE ord.id_order=det.id_order AND pro.id_product=det.id_product AND ord.status='No Payment Validation' AND ord.id_user=$id_user";
        $dataJoin = mysqli_query($conn,$sqlJoin);
        $checkJoin =  mysqli_num_rows($dataJoin);

        $price = 0;
        $sqlHistory = "SELECT ord.*,pro.product_name, pro.image_product,det.id_product, det.quantity, det.temporary_price FROM orderitem ord,product pro,detail det WHERE ord.id_order=det.id_order AND pro.id_product=det.id_product AND ord.status='Delivery' AND ord.id_user=$id_user OR ord.id_order=det.id_order AND pro.id_product=det.id_product AND ord.status='Payment Validation' AND ord.id_user=$id_user";
        $dataHistory = mysqli_query($conn,$sqlHistory);
        $checkHistory =  mysqli_num_rows($dataHistory);
                
    }

    
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business</title>
    <link rel="stylesheet" href="css/styleProductList.css">
</head>

<body>
    <header>
        <img class="logo" src="Images/Logo.png" alt="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="user_page.php">HOME</a></li>
                <li><a href="productList.php?id=<?php echo $_SESSION['id_bisnis_partner']?>">PRODUCT</a></li>
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
                <li>
                    <p class="welcome_text">Welcome,</p>
                </li>
                <li>
                    <p class="user_text"><?php echo $_SESSION['user_name']?></p>
                </li>
            </ul>
        </nav>
        <button class="signout" onclick="location.href='PHP/logout.php'">SIGN OUT</button>
    </header>
    <section>
        <div class="business_description">
            <div class="business_explanation">
                <img class="business_img" src="Images/<?=$_SESSION['logo']?>" alt="IMG">
                <div class="description">
                    <div class="d_part1">
                        <p class="d1_text1"><?php echo $_SESSION['bisnis_partner_name']?></p>
                        <p class="d1_text2">@<?php echo $_SESSION['seller_business']?></p>
                    </div>
                    <div class="d_part2">
                        <p class="d2_text1">Location&emsp;&emsp;:</p>
                        <p class="d2_text2"><?php echo $_SESSION['address']?>, <?php echo $_SESSION['city']?></p>
                    </div>
                    <div class="d_part3">
                        <p class="d3_text1">Category&ensp;&emsp; :</p>
                        <p class="d3_text2"><?php echo $_SESSION['category']?></p>
                    </div>
                    <div class="d_part4">
                        <p class="d4_text1">Description&ensp;:</p>
                        <p class="d4_text2">
                            <?php if(!empty($_SESSION['description'])){ echo $_SESSION['description']; } else { echo "-";}?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="product">
            <div>
                <p class="product_text">Products</p>
                <div style="clear: both;"></div>
            </div>
            <?php if($checkP != 0){?>
            <div class="list_product">
                <?php 
                while($rowP = mysqli_fetch_assoc($dataP)){
                ?>
                <div class="product_details">
                    <img class="images" src="Images/<?=$rowP['image_product']?>" alt="">
                    <p class="product_name" onclick="location.href='order.php?id=<?php echo $rowP['id_product']?>'"><?php echo $rowP['product_name'];?></p>
                </div>
                <?php }?>

            </div>
            <?php } else {?><p class="no_product">No Product Found</p><?php   }?>
        </div>
        
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
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Modals -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>