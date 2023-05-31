<?php

include 'PHP/config.php';

session_start();

if(!isset($_GET['id'])){
    header('location:productList.php');

}else{
    $id_product = $_GET['id'];
    
    $sqlO = "SELECT * FROM product WHERE id_product='$id_product'";
    $dataO = mysqli_query($conn,$sqlO);
    $rowO = mysqli_fetch_array($dataO);

    if($rowO['id_product'] == $id_product){
        $_SESSION['id_product'] = $rowO['id_product'];
        $_SESSION['product_name'] = $rowO['product_name'];
        $_SESSION['status_product'] = $rowO['status_product'];
        $_SESSION['ingredients_product'] = $rowO['ingredients_product'];
        $_SESSION['image_product'] = $rowO['image_product'];
        $format = number_format($rowO['price'],0,',','.');
        $_SESSION['price'] = $format;
        $_SESSION['temporary_price'] = $rowO['price'];
        $_SESSION['category_product'] = $rowO['category_product'];
        $_SESSION['description_product'] = $rowO['description_product'];

        $Min = date('Y-m-d', strtotime('+1 days'));
        $Max = date('Y-m-d', strtotime('+14 days'));

        $querryO = "SELECT max(id_order) as kodeTerbesar FROM orderitem ";
        $dataO = mysqli_query($conn,$querryO);
        $checkO = mysqli_fetch_array($dataO);

        $kodeOrder = $checkO['kodeTerbesar'];
 
	    $urutan = (int) substr($kodeOrder, 3, 3);
 
	    $urutan++;
 
	    $huruf = "OI";
	    $kodeOrder = $huruf . sprintf("%03s", $urutan);

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
    <title>Product</title>
    <link rel="stylesheet" href="css/styleOrder.css">
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
                                    <p class="order_price">Price : <?php echo $rowJoin['temporary_price']?></p>
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
                        <p class="order_total_price">Total Price:<?php echo $price?></p>
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
                                    <p class="order_quantity">Quantity : <?php echo $rowHistory['quantity']?></p>
                                    <p class="order_price">Price : <?php echo $rowHistory['temporary_price']?></p>
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
        <a class="signout" onclick="location.href='PHP/logout.php'">SIGN OUT</a>
    </header>
    <section>
        <div class="product">
            <div class="product_description">
                <img class="product_img" src="Images/<?=$_SESSION['image_product']?>" alt="IMG">
                <div class="description">
                    <div class="d_part1">
                        <p class="d1_text1"><?php echo $_SESSION['product_name']?></p>
                        <p class="d1_text2">RP <?php echo $_SESSION['price']?>,00</p>
                    </div>
                    <div class="d_part2">
                        <p class="d2_text1">Status&ensp;&emsp;:</p>
                        <p class="d2_text2"><?php if(!empty($_SESSION['status_product'])){ echo $_SESSION['status_product']; } else { echo "-";}?></p></p>
                    </div>
                    <div class="d_part3">
                        <p class="d2_text1">Category&ensp;&emsp;:</p>
                        <p class="d2_text2"><?php echo $_SESSION['category_product']?></p>
                    </div>
                    <div class="d_part4">
                        <p class="d2_text1">Ingredients&ensp;&emsp;:</p>
                        <p class="d2_text2"><?php echo $_SESSION['ingredients_product']?></p>
                    </div>
                    <div class="d_part5">
                        <p class="d3_text1">Description&ensp;:</p>
                        <p class="d3_text2"><?php if(!empty($_SESSION['description_product'])){ echo $_SESSION['description_product']; } else { echo "-";}?></p>
                    </div>
                </div>
            </div>
            <div class="order_product">
                <p class="order_text">Order Product</p>
                <form action="PHP/orderitem.php?id=<?php echo $_SESSION['id_product']?>'" method="POST">
                    <div> 
                        <p>
                            <input type="hidden" name="id_order" value="<?php echo $kodeOrder ?>">
                        </p>
                        <p class="quantity_text">Quantity:
                            <input type="number" name="quantity" required>
                        </p>
                        <p class="schedule_text">Schedule:
                            <input type="date"name="order_date" id="datefield" min="<?php echo $Min?>" max="<?php echo $Max?>" onkeydown="return false" required>
                        </p>
                        <p>
                            <input type="hidden" name="status" value="No Payment Validation">
                        </p>
                    </div>
                    <div class="order_btn">
                        <button type="submit" name="submit">+ Shopping Cart</button>
                    </div>
                </form>
            </div>
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
</body>
<!-- <script>
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("datefield").setAttribute("max",today);
</script> -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>