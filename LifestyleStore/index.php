<?php
session_start();
require 'connection.php';
$categories = mysqli_query($con, 'SELECT * FROM categories ORDER BY display_order');
$categories = mysqli_fetch_all($categories);
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>B.A clothing store</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- latest compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!-- External CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <div>
           <?php
            require 'header.php';
           ?>
           <div id="bannerImage">
               <div class="container">
                   <center>
                   <div id="bannerContent">
                       <h1>B.A clothing store</h1>
                       <a href="products.php" class="btn btn-danger">Buy</a>
                   </div>
                   </center>
               </div>
           </div>
           <div class="container">
        
               <div class="row">
               <?php foreach ($categories as $category ) { ?>
                    <div class="col-xs-4">
                        <div  class="thumbnail">
                            <a href="products.php?category_id=<?= $category[0] ?>">
                                    <img src="data/category/<?= $category[0] ?>.jpg" alt="<?= $category[1] ?>">
                            </a>
                            <center>
                                    <div class="caption">
                                            <p id="autoResize"><?= $category[1] ?></p>
                                            <p><?= $category[2] ?></p>
                                    </div>
                            </center>
                        </div>
                    </div>
                <?php } ?>
                   <div class="col-xs-4">
                       <div class="thumbnail">
                           <a href="products.php">
                               <img src="img/watch.jpg" alt="Watch">
                           </a>
                           <center>
                                <div class="caption">
                                    <p id="autoResize">Iphone</p>
                                    <p>Original watches from the best brands.</p>
                                </div>
                           </center>
                       </div>
                   </div>
                   <div class="col-xs-4">
                       <div class="thumbnail">
                           <a href="products.php">
                               <img src="img/shirt.jpg" alt="Shirt">
                           </a>
                           <center>
                               <div class="caption">
                                   <p id="autoResize">Shirts</p>
                                   <p>Our exquisite collection of shirts.</p>
                               </div>
                           </center>
                       </div>
                   </div>
               </div>
           </div>
            <br><br> <br><br><br><br>
           <footer class="footer"> 
               <div class="container">
               <center>
                   <p>This website is developed by Baktash WAQIBEEN</p>
               </center>
               </div>
           </footer>
        </div>
    </body>
</html>