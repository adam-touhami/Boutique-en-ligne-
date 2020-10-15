
<?php
session_start();
require 'connection.php';
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
    function checkLogo()
    {
        $type = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);
        $output = [
            'type' => $type
        ];
        if (!in_array("." . $type, ['.PNG', '.jpg', '.jpeg'])) {
            $output['error'] = "Format d'image autorisé: " . implode(", ", ['.png', '.jpg', '.jpeg']);
        }
        return $output;
    }

    
     function setLogo($db)
    {
    
        $pathAvatar = 'data/category/';
        $name = mysqli_insert_id($db) . ".jpg";
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
        $categoryName = htmlentities($_POST['title']);
        $description = htmlentities($_POST['description']);
        $displayOrder = $_POST['display_order'];
        $errors = [];
        $checkLogo = checkLogo();
        if(!empty($checkLogo['error']))
        {
            $errors[] = $checkLogo['error'];
        }
        if(empty($errors))
        {
            mysqli_query($con, 'INSERT INTO categories(title, description, display_order) VALUE("' . $categoryName . '", "' . $description . '",  ' . $displayOrder . ')');
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


    <title>B.A clothing store</title>
</head>
<body id="add_to_the_product">
    
    <main id="add_to_the_product_main">
        <form class="#add_to_the_product_main_form" action="addcategory.php" method="POST"  enctype="multipart/form-data">
        <header>
    Add Category
    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
    </header>
            <label for="title"> Title</label>
            <input class="form_one" type="text" name="title" require id='title'> <br>
            <label for="description"> Description</label>
            <input class="form_one" type="text" name="description" id="description"><br>
            <label for="display_roder"> Display order</label>
            <input class="form_one" type="number" name="display_order" id="display_order">
            <label for="picture">Picture</label>
            <input class="form_three" type="file" name="picture"> <br>
            <button type="submit">Submit</button> <br>
        </form>
        </div>
    </main>
    <!-- <footer>

    </footer> -->
</body>
</html>