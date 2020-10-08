
<?php
session_start();
require 'connection.php';
$errors = [];
$categories = mysqli_query($con, 'SELECT * FROM categories ORDER BY display_order ');
$categories = mysqli_fetch_all($categories);
     function checkLogo()
    {
        $type = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);
        $output = [
            'type' => $type
        ];
        var_dump($type);
        if (!in_array("." . $type, ['.PNG', '.jpg', '.jpeg'])) {
            $output['error'] = "Format d'image autorisé: " . implode(", ", ['.png', '.jpg', '.jpeg']);
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
    $checkLogo = checkLogo();
    if(!empty($checkLogo['error']))
    {var_dump($_FILES);
        $errors[] = $checkLogo['error'];
    }
    if(empty($errors))
    {
        mysqli_query($con, 'INSERT INTO items(name, price) VALUE("' . $title . '", ' . $price . ' )');
        setLogo($con);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.A clothing store</title>
</head>
<body>
    <header>
    Add Product here
    </header>
    <main>
        <form action="addproduct.php" method="POST" enctype="multipart/form-data">
            <label for="title"> Title</label>
            <input type="text" name="title" require>
            <label for="picture">picture</label>
            <input type="file" name="picture">
            <label for="price">Price</label>
            <input type="number" name="price" require>
            <button type="submit">Submit</button>
            <select name="category_id">
                <?php foreach($categories as $category)  { ?>
                    <option value="<?= $category[0] ?>"><?= $category[1] ?></option>
                <?php } ?>
            </select>
        </form>
    </main>
    <footer>

    </footer>
</body>
</html>