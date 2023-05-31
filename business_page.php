<?php

include 'PHP/config.php';

session_start();

if(!isset($_SESSION['seller_business'])){
    header('location:login.php');
    
}else{
    
    $querryP = "SELECT max(id_product) as kodeTerbesar FROM product ";
    $dataP = mysqli_query($conn,$querryP);
    $checkP = mysqli_fetch_array($dataP);

    $kodeProduct = $checkP['kodeTerbesar'];
 
	$urutan = (int) substr($kodeProduct, 3, 3);
 
	$urutan++;
 
	$huruf = "PD";
	$kodeProduct = $huruf . sprintf("%03s", $urutan);

    if(isset($_POST['upload'])){

        $id_bisnis_partner = $_SESSION['id_bisnis_partner'];
        $id_product = $_POST['id_product'];
        $product_name = mysqli_real_escape_string($conn,$_POST['product_name']);
        $status_product = $_POST['status_product'];
        $ingredients_product = $_POST['ingredients_product'];
        $price = $_POST['price'];
        $category_product = $_POST['category_product'];
        $description_product = $_POST['description_product'];

        //Image
        $imagefile = "Images/"; //directory files
        $name = basename($_FILES["image_product"]["name"]); //namafile image
        $file = $_FILES["image_product"]["tmp_name"]; 
        $image = $imagefile . $name; //letak image yang sudah dimasukkan
        $validation = pathinfo($image,PATHINFO_EXTENSION);
        $extention = array('jpg','png','jpeg','JPG','PNG','JPEG'); //tipe image yang dadpat di ambil
        
        if($status_product == "Halal" || $status_product == NULL){
            if(in_array($validation,$extention)){
                move_uploaded_file($file, $image);
                $image_product = $_FILES["image_product"]["name"];
                $sql= "INSERT INTO product(id_product, id_bisnis_partner, product_name, image_product, status_product, ingredients_product, price, category_product,description_product)VALUES('$id_product','$id_bisnis_partner','$product_name','$image_product','$status_product','$ingredients_product','$price','$category_product','$description_product')";
                $result = mysqli_query($conn,$sql);
                $_SESSION['msgsucces'] = 'Data has been saved';
            }else{
                $_SESSION['msg'] = 'Wrong extension image just jpg, png, and jperg';
            }
        } else {
            $_SESSION['msg'] = 'Sorry your status must be type correctly';
        }
        
    }
    $id_bisnis_partner = $_SESSION['id_bisnis_partner'];
    $sql = "SELECT * FROM product WHERE id_bisnis_partner='$id_bisnis_partner'";
    $result = mysqli_query($conn,$sql);
    
    $sqlJoin = "SELECT pro.id_bisnis_partner, pro.id_product, pro.product_name, pro.image_product, det.*, ord.*, us.id_user, us.user_name, us.address FROM  product pro, detail det, orderitem ord, user us WHERE pro.id_bisnis_partner = $id_bisnis_partner AND pro.id_product = det.id_product AND det.id_order = ord.id_order AND us.id_user = ord.id_user AND ord.status='Payment Validation'";
    $dataJoin = mysqli_query($conn,$sqlJoin);
    $checkJoin =  mysqli_num_rows($dataJoin);

    $price = 0;
    
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business</title>
    <link rel="stylesheet" href="css/styleBusiness_Page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script> 
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
        <div class="dropdown">
        <ion-icon name="list-outline" class="list"></ion-icon>
            <div class="dropdown-content">
                <p class="order_list">Order List</p>
                <?php if($checkJoin != 0){?>
                    <?php 
                        while($rowJoin = mysqli_fetch_assoc($dataJoin)){
                    ?>
                    <form action="PHP/accept.php?id=<?php echo $rowJoin['id_user']?>&id_order=<?php echo $rowJoin['id_order']?>" method="POST">
                        <div class="order_details">
                            <div style="display: flex;">
                                <div class="o_part1">
                                    <img class="order_image" src="Images/<?=$rowJoin['image_product']?>" alt="">
                                </div>
                                <div class="o_part2">
                                    <p class="order_name"><?php echo $rowJoin['product_name']?></p>
                                    <p class="order_date">Delivery Date : <?php echo $rowJoin['order_date']?></p>
                                    <p class="order_quantity">Quantity : <?php echo $rowJoin['quantity']?></p>
                                    <p class="order_location">Name : <?php echo $rowJoin['user_name']?></p>
                                    <p class="order_location">Location : <?php echo $rowJoin['address']?></p>
                                </div>
                            </div>
                            <div>
                                <button class="accept_btn" name="submit">Accept</button>
                            </div>
                        </div>
                    </form>    
                    <?php }?>
                <?php } else {?><p class="no_order">No Data</p><?php }?>
            </div>
        </div>
        <nav>
            <ul class="welcome">
                <li>
                    <p class="welcome_text">Welcome,</p>
                </li>
                <li>
                    <p class="user_text"><?php echo $_SESSION['seller_business']?></p>
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
            <div class="business_button">
                <button href="PHP/EditProfileB.php?id=<?= $_SESSION['id_bisnis_partner']; ?>" data-bs-toggle="modal"
                    data-bs-target="#exampleModal<?php echo $_SESSION['id_bisnis_partner'];?>">Edit Profile</button>
            </div>
            <div class="modal fade" id="exampleModal<?php echo $_SESSION['id_bisnis_partner'];?>" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="PHP/EditProfileB.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_SESSION['id_bisnis_partner']; ?>">
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Username</label>
                                    <input type="text" name="seller_business" class="form-control"
                                        id="formGroupExampleInput" placeholder="Username"
                                        value="<?php echo $_SESSION['seller_business']?>">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Address</label>
                                    <input type="text" name="address" class="form-control" id="formGroupExampleInput"
                                        placeholder="Address" value="<?php echo $_SESSION['address']?>">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Phone</label>
                                    <input type="text" name="phone_num" class="form-control" id="formGroupExampleInput"
                                        placeholder="Phone" value="<?php echo $_SESSION['phone_num']?>">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">City</label>
                                    <input type="text" name="city" class="form-control" id="formGroupExampleInput"
                                        placeholder="City" value="<?php echo $_SESSION['city']?>">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Nama Bisnis</label>
                                    <input type="text" name="bisnis_partner_name" class="form-control"
                                        id="formGroupExampleInput2" placeholder="Nama Bisnis"
                                        value="<?php echo $_SESSION['bisnis_partner_name']?>">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Category</label>
                                    <input type="text" name="category" class="form-control" id="formGroupExampleInput2"
                                        placeholder="Category" value="<?php echo $_SESSION['category']?>">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Description</label>
                                    <textarea type="text" name="description" class="form-control"
                                        id="formGroupExampleInput2"><?php if(isset($_SESSION['description'])) { echo htmlentities ($_SESSION['description']); }?></textarea>

                                </div>
                                <div class="form-group mt-2">
                                    <label for="formGroupExampleInput">Upload Logo</label>
                                    <input type="file" class="form-control" name="new_image" id="formFile" value="">
                                    <input type="hidden" class="form-control" name="logo"
                                        value="<?php echo $_SESSION['logo']?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="upload" class="btn btn-primary" >Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product">
            <div>
                <p class="product_text">Products</p>
                <b href="AdminViewB.php?id=<?= $_SESSION['id_bisnis_partner']; ?>" name="add_product"
                    class="plus_button" data-bs-toggle="modal"
                    data-bs-target="#exampleModal2<?php echo $_SESSION['id_bisnis_partner'];?>">+</b>
                <div style="clear: both;"></div>
            </div>
            <div class="modal fade" id="exampleModal2<?php echo $_SESSION['id_bisnis_partner'];?>" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_SESSION['id_bisnis_partner']; ?>">
                                <div class="form-group">
                                    <input type="hidden" name="id_product" class="form-control"
                                        id="formGroupExampleInput" placeholder="ID Product"
                                        value="<?php echo $kodeProduct ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Product Name</label>
                                    <input type="text" name="product_name" class="form-control"
                                        id="formGroupExampleInput" placeholder="Product Name">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Status Product</label>
                                    <input type="text" name="status_product" class="form-control"
                                        id="formGroupExampleInput" placeholder="Status Product">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Ingredientst</label>
                                    <textarea type="text" name="ingredients_product" class="form-control"
                                        id="formGroupExampleInput" placeholder="Ingredients"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Price</label>
                                    <input type="text" name="price" class="form-control" id="formGroupExampleInput"
                                        placeholder="Price">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Category Product</label>
                                    <input type="text" name="category_product" class="form-control"
                                        id="formGroupExampleInput2" placeholder="Category Product">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Description Product</label>
                                    <textarea type="text" name="description_product" class="form-control"
                                        id="formGroupExampleInput2" placeholder="Description Product"></textarea>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="formGroupExampleInput">Upload Image Product</label>
                                    <input type="file" class="form-control" name="image_product" id="formFile" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="upload" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list_product">
                <?php 
                while($row = mysqli_fetch_assoc($result)){
                ?>
                <div class="product_details">
                    <img class="images" src="Images/<?=$row['image_product']?>" alt="">
                    <p class="product_name"><?php echo $row['product_name'];?></p>
                    <!-- <button class="edit_btn">Edit</button> -->
                    <button href="PHP/EditProduct.php?id=<?= $row['id_product']; ?>" class="edit_btn" data-bs-toggle="modal"
                        data-bs-target="#exampleModal3<?php echo $row['id_product'];?>">Edit</button>
                </div>
                <div class="modal fade" id="exampleModal3<?php echo $row['id_product'];?>" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="PHP/EditProduct.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $row['id_product']; ?>">
                                    <div class="form-group">
                                        <label for="formGroupExampleInput">Product Name</label>
                                        <input type="text" name="product_name" class="form-control"
                                            id="formGroupExampleInput" placeholder="Product Name"
                                            value="<?php echo $row['product_name']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput">Status Product</label>
                                        <input type="text" name="status_product" class="form-control"
                                            id="formGroupExampleInput" placeholder=" Status Product"
                                            value="<?php echo $row['status_product']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput">Ingredients</label>
                                        <textarea type="text" name="ingredients_product" class="form-control"
                                            id="formGroupExampleInput" placeholder="Ingredientst"
                                            ><?php if(isset($row['ingredients_product'])) { echo htmlentities ($row['ingredients_product']); }?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput">Price</label>
                                        <input type="text" name="price" class="form-control" id="formGroupExampleInput"
                                            placeholder="Price" value="<?php echo $row['price']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput">Category Product</label>
                                        <input type="text" name="category_product" class="form-control"
                                            id="formGroupExampleInput" placeholder="Category Product"
                                            value="<?php echo $row['category_product']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput">Description Product</label>
                                        <textarea type="text" name="description_product" class="form-control"
                                            id="formGroupExampleInput" placeholder="Description Product"
                                            ><?php if(isset($row['description_product'])) { echo htmlentities ($row['description_product']); }?></textarea>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="formGroupExampleInput">Upload Logo</label>
                                        <input type="file" class="form-control" name="new_image" id="formFile" value="">
                                        <input type="hidden" class="form-control" name="image_product"
                                            value="<?php echo $row['image_product']?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="upload" class="btn btn-primary">Save
                                            changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

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
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Modals -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <?php if (@$_SESSION['msgsucces']) { ?>
       <script>
            Swal.fire('Sucess','<?php  echo $_SESSION['msgsucces']?>','success');
       </script>
    <?php unset($_SESSION['msgsucces']); } else if (@$_SESSION['msg']) { ?>
       <script>   
            Swal.fire('Error','<?php echo $_SESSION['msg']?>','error');
       </script>
   <?php unset($_SESSION['msg']); } ?>
   
    </body>

</body>

</html>