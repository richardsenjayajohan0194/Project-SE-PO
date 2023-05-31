<?php

include 'PHP/config.php';

session_start();

if(!isset($_SESSION['username'])){
    header('location:login.php');

}else{
    $sql = "SELECT * FROM bisnis_partner";

    $result = mysqli_query($conn,$sql);
    
    $sqlProduct = "SELECT * FROM product";
    
    $resultProduct = mysqli_query($conn,$sqlProduct);

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/AdminViewB.css">
    <title>Daftar Bisnis Partner</title>
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
        <nav>
            <ul class="welcome">
                <li>
                    <p class="welcome_text">Welcome,</p>
                </li>
                <li>
                    <p class="user_text"><?php echo $_SESSION['username']?></p>
                </li>
            </ul>
        </nav>
        <button class="signout" onclick="location.href='logout.php'">SIGN OUT</button>
    </header>
    <!-- Container -->
    <div class="container">
        <div class="row my-2">
            <div class="col-md">
                <h3 class="text-center fw-bold text-uppercase">Data Bisnis Partner</h3>
                <hr>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md">
                <table id="data" class="table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>ID BP</th>
                            <th>Username</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Nama Bisnis</th>
                            <th>Logo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                
                    <tbody>
                    <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                        <tr>
                            <div>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $row['id_bisnis_partner'];?></td>
                            <td><?php echo $row['seller_business'];?></td>
                            <td><?php echo $row['address'];?></td>
                            <td><?php echo $row['phone_num'];?></td>
                            <td><?php echo $row['city'];?></td>
                            <td><?php echo $row['bisnis_partner_name'];?></td>
                            </div>
                            
                            <td><img src="Images/<?=$row['logo']?>" width="100px" height="100px"></td>
                            
                            <td style="text-align: center;">
                                <a href="EditB.php?id=<?= $row['id_bisnis_partner']; ?>" class="btn btn-warning btn-sm" style="font-weight: 600;" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['id_bisnis_partner'];?>"><i class="bi bi-pencil-square"></i>&nbsp;Ubah</a> |
                                <a href="DeleteB.php?id=<?= $row['id_bisnis_partner']; ?>" class="btn btn-danger btn-sm" style="font-weight: 600;" onclick="return confirm('Apakah anda yakin ingin menghapus data <?= $row['bisnis_partner_name']; ?> ?');"><i class="bi bi-trash-fill"></i>&nbsp;Hapus</a>
                            </td>
                    
                    
                    

                    <!-- Modal -->
                    
                    <div class="modal fade" id="exampleModal<?php echo $row['id_bisnis_partner'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Bisnis Partner</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="EditB.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $row['id_bisnis_partner']; ?>">
                                        <div class="form-group">
                                            <label for="formGroupExampleInput">Username</label>
                                            <input type="text" name="seller_business" class="form-control" id="formGroupExampleInput" placeholder="Username" value="<?php echo $row['seller_business']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput">Address</label>
                                            <input type="text" name="address" class="form-control" id="formGroupExampleInput" placeholder="Address" value="<?php echo $row['address']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput">Phone</label>
                                            <input type="text" name="phone_num" class="form-control" id="formGroupExampleInput" placeholder="Phone" value="<?php echo $row['phone_num']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput">City</label>
                                            <input type="text" name="city" class="form-control" id="formGroupExampleInput" placeholder="City" value="<?php echo $row['city']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput2">Nama Bisnis</label>
                                            <input type="text" name="bisnis_partner_name" class="form-control" id="formGroupExampleInput2" placeholder="Nama Bisnis" value="<?php echo $row['bisnis_partner_name']?>">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="formGroupExampleInput">Upload Logo</label>
                                            <input type="file" class="form-control" name="new_image" id="formFile" value="">
                                            <input type="hidden" class="form-control" name="logo"  value="<?php echo $row['logo']?>">
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="upload" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>   
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <tbody>   
                </table>
            </div>
        </div>
    </div>

<!-- Container -->
<div class="container">
        <div class="row my-2">
            <div class="col-md">
                <h3 class="text-center fw-bold text-uppercase">Data Product</h3>
                <hr>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md">
                <table id="data2" class="table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Id Product</th>
                            <th>Id Bisnis</th>
                            <th>Product Name</th>
                            <th>Image Product</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                
                    <tbody>
                    <?php 
                        $no = 1;
                        while($rowProduct = mysqli_fetch_assoc($resultProduct)){
                    ?>
                        <tr>
                            <div>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $rowProduct['id_product'];?></td>
                            <td><?php echo $rowProduct['id_bisnis_partner'];?></td>
                            <td><?php echo $rowProduct['product_name'];?></td>
                            <td><img src="Images/<?=$rowProduct['image_product']?>" width="100px" height="100px"></td>
                            <td><?php echo $rowProduct['status_product'];?></td>
                            <td><?php echo $rowProduct['price'];?></td>
                            </div>
                            
                            
                            
                            <td style="text-align: center;">
                                <a href="DeleteB.php?id=<?= $row['id_bisnis_partner']; ?>" class="btn btn-danger btn-sm" style="font-weight: 600;" onclick="return confirm('Apakah anda yakin ingin menghapus data <?= $row['bisnis_partner_name']; ?> ?');"><i class="bi bi-trash-fill"></i>&nbsp;Hapus</a>
                            </td>
                    <?php }?>
                    <tbody>   
                </table>
            </div>
        </div>
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Data Tables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Fungsi Table
            $('#data').DataTable();
            // Fungsi Table
        });
        $(document).ready(function() {
            // Fungsi Table
            $('#data2').DataTable();
            // Fungsi Table
        });
    </script>
</body>

</html>