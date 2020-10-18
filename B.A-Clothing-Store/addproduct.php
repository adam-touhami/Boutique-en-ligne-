
<?php
session_start();
require 'connection.php';
include 'header2.php';
if(!empty($_SESSION['id']))
{
    $user = mysqli_query($con, 'SELECT admin FROM users WHERE id = ' . $_SESSION['id'] . ' AND admin = 1');
    $user = mysqli_fetch_assoc($user);
    if(empty($user))
    {
        header('location: index.php');
    }
}
else
{
    header('location: login.php');
}
$errors = [];
$categories = mysqli_query($con, 'SELECT * FROM categories ORDER BY display_order ');
$categories = mysqli_fetch_all($categories);
     function checkLogo()
    {
        $type = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);
        $output = [
            'type' => $type
        ];
        
        if (!in_array("." . $type, ['.PNG', '.jpg', '.jpeg'])) {
            $output['error'] = "Image format allowed : " . implode(", ", ['.png', '.jpg', '.jpeg']);
        }
        return $output;
    }

    
     function setLogo($db)
    {
        $items = mysqli_query($db, 'SELECT id FROM items WHERE id = ' . mysqli_insert_id($db));
        $items = mysqli_fetch_assoc($items);
        $pathAvatar = 'data/product/';
        $name = $items['id'] . ".jpg";
        foreach (scandir($pathAvatar) as $avatar) {
            if (pathinfo($avatar, PATHINFO_FILENAME) == pathinfo($name, PATHINFO_FILENAME)) {
                $path = $pathAvatar . $avatar;
                unset($path);
            }
        }
        move_uploaded_file($_FILES["picture"]["tmp_name"], $pathAvatar . $name);
    }
if(!empty($_POST))
{
    
    $title = $_POST['title'];
    $price = $_POST['price'];
    $categoryId = $_POST['category_id'];
    $checkLogo = checkLogo();
    if(!empty($checkLogo['error']))
    {
        $errors[] = $checkLogo['error'];
    }
    if(empty($errors))
    {
        mysqli_query($con, 'INSERT INTO items(name, price, category_id) VALUE("' . $title . '", ' . $price . ',  ' . $categoryId . ')');
        setLogo($con);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,500&display=swap" rel="stylesheet">
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


    <title>B.A clothing store</title>
</head>
<body id="add_to_the_product">
    
    <main id="add_to_the_product_main">
        <form class="#add_to_the_product_main_form" action="addproduct.php" method="POST" enctype="multipart/form-data">
        <header>
    Add Product
    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
    </header>
            <label for="title"> Title</label>
            <input class="form_one" type="text" name="title" require> <br>
            <label for="picture">Picture</label>
            <input class="form_three" type="file" name="picture"> <br>
            <label for="price">Price</label>
            <input class="form_two"type="number" name="price" require> <br>
            <select name="category_id">
                <?php foreach($categories as $category)  { ?>
                    <option value="<?= $category[0] ?>"><?= $category[1] ?></option>
                <?php } ?>
            </select>
            <button type="submit">Submit</button> <br>
        </form>
        </div>
    </main>
    <!-- <footer>

    </footer> -->
</body>
</html>