<?php

include 'PHP/config.php';
if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);   
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $pass =md5($_POST['password']);
    $cpass=md5($_POST['cpassword']);
    $user_role = $_POST['user_role'];

    if($user_role == 'Bisnis Partner'){
        $city = $_POST['city']; 
        $name_business = mysqli_real_escape_string($conn, $_POST['business']);
        $category = $_POST['category'];
        $imagefile = "Images/"; //directory files
        $name = basename($_FILES["upload"]["name"]); //namafile image
        $file = $_FILES["upload"]["tmp_name"]; 
        $image = $imagefile . $name; //letak image yang sudah dimasukkan
        $validation = pathinfo($image,PATHINFO_EXTENSION);
        $extention = array('jpg','png','jpeg','JPG','PNG','JPEG'); //tipe image yang dadpat di ambil
    }
    
    if($user_role != 'Role'){

        $selectA = "SELECT * FROM admin WHERE username='$username' ";
        $resultA = mysqli_query($conn,$selectA);
        $checkA = mysqli_num_rows($resultA);
    
        $selectU = "SELECT * FROM user WHERE user_name='$username' ";
        $resultU = mysqli_query($conn,$selectU);
        $checkU = mysqli_num_rows($resultU);
    
        $selectB = "SELECT * FROM bisnis_partner WHERE seller_business='$username' ";
        $resultB = mysqli_query($conn,$selectB);
        $checkB = mysqli_num_rows($resultB);
    
        $totaluser = $checkA + $checkU + $checkB;
        if($totaluser == 0){
            if($pass == $cpass){
                if($user_role == 'User'){
                    
                    if($checkU  == 0){
                        $sql= "INSERT INTO user(user_name,address,phone_num,password,user_role)VALUES('$username','$address','$phone','$pass','$user_role')";
                        $result = mysqli_query($conn,$sql);
                        header('location:login.php');
                            
                    }            
                    
                }else if($user_role == 'Business Partner'){
                
                    if($checkB == 0){
                        if(in_array($validation,$extention)){
                            move_uploaded_file($file, $image);
                            $logo = $_FILES["upload"]["name"];
                            $sql= "INSERT INTO bisnis_partner(seller_business,address,phone_num,city,password,user_role,bisnis_partner_name, category,description,logo)VALUES('$username','$address','$phone','$city','$pass','$user_role','$name_business','$category',NULL,'$logo')";
                            $result = mysqli_query($conn,$sql);
                            header('location:login.php');
                        }else{
                            $error3 = 'wrong extension Image just for jpg,png,jpeg';
                        }
                    } 
                    
                    
                }
                    $totaluser = 0;
            }
                $error2 = 'Wrong Password';
                
                
                
        }else if($totaluser != 0 && $pass != $cpass){
            $error1 = 'Username has been used';
            $error2 = 'Wrong Password';

        }else{
            $error1 = 'Username has been used';
                
            $totaluser = 0;
        }
        
        
    }
    
}   
 

?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="css/styleRegister.css">
  <script src="JS/alert.js"></script>
  <title>Register Page</title>
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
        <div id="form-box1">
            <div class="form-value">
                <form action="" method="post" enctype="multipart/form-data" id="formId">
                    <h2>REGISTER</h2>
                    <div class="role_group1">
                        <p class="role">Role</p>
                        <select name="user_role" class="user_role" onchange="Visible(this)">
                            <option id="user1" value="User" selected>User</option>
                            <option id="business_partner1" value="Business Partner">Business Partner</option>
                        </select>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" name="username" required>
                        <label for="username">Username</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="location-outline"></ion-icon>
                        <input type="text" name="address" required>
                        <label for="address">Address</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="call-outline"></ion-icon>
                        <input type="text" name="phone" required>
                        <label for="phone">Phone</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" id="password" name="password" required>
                        <label for="password">Password</label>  
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" id="cpassword" name="cpassword" required>
                        <label for="cpassword">Confirm Password</label>
                    </div>
                    <div class="submit_btn1">
                        <button type="submit" name="submit" class="btn-btn info" onclick="matchPassword()">Register</button>
                    </div>
                    <div class="login">
                        <p>Already have account? <a href="login.php">Login now</a></p>
                    </div>
                </form>
            </div>
        </div>
        <div id="form-box2">
            <div class="form-value">
                <form action="" method="post" enctype="multipart/form-data" id="formId1" >
                    <h2>REGISTER</h2>
                    <div class="role_group2">
                        <p class="role">Role</p>
                        <select name="user_role" class="business_role" onchange="Visible(this)">
                            <option id="business_partner2" value="Business Partner" selected>Business Partner</option>
                            <option id="user2" value="User">User</option>
                        </select>
                    </div>
                    <div class="column">
                        <div class="part">
                            <div class="inputbisnis">
                                <ion-icon name="person-outline"></ion-icon>
                                <input type="text" name="username" required>
                                <label for="username">Username</label>
                            </div>
                            <div class="inputbisnis">
                                <ion-icon name="location-outline"></ion-icon>
                                <input type="text" name="address" required>
                                <label for="address">Address</label>
                            </div>
                            <div class="inputbisnis">
                                <ion-icon name="business-outline"></ion-icon>
                                <input type="text" name="city" required>
                                <label for="city">City</label>
                            </div>
                            <div class="inputbisnis">
                                <ion-icon name="call-outline"></ion-icon>
                                <input type="text" name="phone" required>
                                <label for="phone">Phone</label>
                            </div>
                        </div>
                        <div class="part">
                            <div class="inputbisnis">
                                <input type="text" id="business" name="business" required>
                                <label for="business">Business Name</label>
                            </div>
                            <div class="style_category">
                                <p class="category">Category</p>
                                <select name="category" class="business_category">
                                    <option>Fashion</option>
                                    <option>Food And Beverage</option>
                                </select>
                            </div>
                            <div class="inputfile" id="filename">
                                <label class="button" for="upload">Upload Logo</label>
                                <input id="upload" type="file" name="upload" required>
                            </div>
                        </div>
                    </div>
                    <div class="style_password" style="display: flex; margin-top: -35px;">
                        <div class="inputbisnis">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                            <input type="password" id="password" name="password" required>
                            <label for="password">Password</label>  
                        </div>
                        <div class="inputbisnis">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                            <input type="password" id="cpassword" name="cpassword" required>
                            <label for="cpassword">Confirm Password</label>
                        </div>
                    </div>
                    <div class="submit_btn2">
                        <button type="submit" name="submit" class="btn-btn info" onsubmit="matchPassword()">Register</button>
                    </div>
                    <div class="login">
                        <p>Already have account? <a href="login.php">Login now</a></p>
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