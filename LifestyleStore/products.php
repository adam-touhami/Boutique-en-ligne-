<?php
    session_start();
    require 'check_if_added.php';
    require 'connection.php';
    $products = [];
    if(!empty($_GET['category_id']))
    {
        $products = mysqli_query($con, 'SELECT * FROM items WHERE category_id = ' . $_GET['category_id']);
        $products = mysqli_fetch_all($products);
    }
    
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
            <div class="container">
                <div class="jumbotron">
                    <h1>Welcome to B.A clothing store!</h1>
                    <p>We have the best computers, phones and shirts for you. we have all in one place.</p>
                </div>
            </div>
            <div class="container">
                <div class="row">
                <?php foreach($products as $product)  { 
                    
                    ?>    
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail">
                            <a href="cart.php">
                                <img src="data/product/<?= $product[0] ?>.jpg" alt="<?= $product[1] ?>">
                            </a>
                            <center>
                                <div class="caption">
                                    <h3><?= $product[1] ?></h3>
                                    <p>Price: <?= $product[2] ?> € </p>
                                    <?php if(!isset($_SESSION['email'])){  ?>
                                        <p><a href="login.php" role="button" class="btn btn-primary btn-block">Buy Now</a></p>
                                        <?php
                                        }
                                        else{
                                            if(check_if_added_to_cart($product[0])){
                                                echo '<a href="#" class=btn btn-block btn-success disabled>Added to cart</a>';
                                            }else{
                                                ?>
                                                <a href="cart_add.php?id=<?= $product[0] ?>" class="btn btn-block btn-primary" name="add" value="add" class="btn btn-block btr-primary">Add to cart</a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    
                                </div>
                            </center>
                        </div>
                    </div>
                <?php } ?>
                
            </div>
            <br><br><br><br><br><br><br><br>
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
