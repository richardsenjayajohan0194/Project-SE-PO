<?php

include 'PHP/config.php';

session_start();
if(isset($_POST['submit'])){
    $username = $_POST['username'];   
    $pass =md5($_POST['password']);

    
    $selectA = "SELECT * FROM admin WHERE username = '$username' && password = '$pass' ";
    $resultA = mysqli_query($conn,$selectA);
    $checkA = mysqli_num_rows($resultA);

    $selectU = "SELECT * FROM user WHERE user_name = '$username' && password = '$pass' ";
    $resultU = mysqli_query($conn,$selectU);
    $checkU = mysqli_num_rows($resultU);

    $selectB = "SELECT * FROM bisnis_partner WHERE seller_business = '$username' && password = '$pass' ";
    $resultB = mysqli_query($conn,$selectB);
    $checkB = mysqli_num_rows($resultB);

    $total_user = $checkA + $checkU + $checkB;
    if($total_user == 1){
        if($checkA == 1){
            $rowA = mysqli_fetch_array($resultA);
            if($rowA['user_role'] == 'Admin'){
                $_SESSION['username'] = $rowA['username'];
                header("location:AdminViewB.php");
            }
            
        }
        if($checkU == 1){
            $rowU = mysqli_fetch_array($resultU);
            if($rowU['user_role'] == 'User'){
                $_SESSION['id_user'] = $rowU['id_user'];
                $_SESSION['user_name'] = $rowU['user_name'];
                header("location:user_page.php");
            }
            
        }else{
            $error[] = 'incorent username or password';
        }
    
        if($checkB == 1){
            $rowB = mysqli_fetch_array($resultB);
            if($rowB['user_role'] == 'Business Partner'){
                $_SESSION['seller_business'] = $rowB['seller_business'];
                $_SESSION['id_bisnis_partner'] = $rowB['id_bisnis_partner'];
                $_SESSION['address'] = $rowB['address'];
                $_SESSION['phone_num'] = $rowB['phone_num'];
                $_SESSION['city'] = $rowB['city'];
                $_SESSION['bisnis_partner_name'] = $rowB['bisnis_partner_name'];
                $_SESSION['category'] = $rowB['category'];
                $_SESSION['description'] = $rowB['description'];
                $_SESSION['logo'] = $rowB['logo'];
                header("location:business_page.php");
            }
        
        }else{
            $error[] = 'incorent username or password';
        }
        
        $total_user = 0;
    };
}

    
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/styleLogin.css">
  <title>Login Page</title>
</head> 
<body>
    <header>
        <img class="logo" src="Images/Logo.png" alt="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="">HOME</a></li>
                <li><a href="">PRODUCT</a></li>
                <li><a href="">ABOUT</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="" method="POST">
                    <h2>LOGIN</h2>
                    <div class="inputbox">
                    <ion-icon name="person-outline"></ion-icon>
                        <input type="text" name="username" required value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>">
                        <label for="">Username</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" required>
                        <label for="">Password</label>
                    </div>
                    <div class="forget">
                        <label><a href="#">Forget Password</a></label>
                    </div>
                    <button type="submit" name="submit" class="btn-btn info">Login</button>
                    <div class="register">
                        <p>Don't have a account? <a href="register.php">Register</a></p>
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
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>
</html>