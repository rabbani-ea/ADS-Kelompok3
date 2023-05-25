<?php
session_start();

require_once('./php/CreateDb.php');
require_once('./php/component.php');

$database = new CreateDB("ProductDB", "Producttdb");

if(isset($_POST['add'])){
    if(isset($_SESSION['cart'])){
        $item_array_id = array_column($_SESSION['cart'],"product_id");

        if(in_array($_POST['product_id'], $item_array_id)){
            echo "<script>alert('Product is already added in the cart..!')</script>";
            echo "<script>window.location = 'index.php'</script>";
        }else{
            $count = count($_SESSION['cart']); // Fixed the line, added missing '=' sign
            $item_array = array(
                'product_id'=>$_POST['product_id']
            );

            $_SESSION['cart'][$count] = $item_array;
            print_r($_SESSION['cart']);
        }
    }else{
        $item_array = array(
            'product_id'=>$_POST['product_id']
        );

        $_SESSION['cart'][0] = $item_array;
        print_r($_SESSION['cart']);
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Limaawaktu Shop</title>
    <script src="https://kit.fontawesome.com/4a00daa95e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.css" integrity="sha512-Z0kTB03S7BU+JFU0nw9mjSBcRnZm2Bvm0tzOX9/OuOuz01XQfOpa0w/N9u6Jf2f1OAdegdIPWZ9nIZZ+keEvBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>

  <body>
  <?php require_once ("php/header.php"); ?>
    <div class="container">
        <div class="row text-center py-5">
        <?php
        $result = $database->getData();
        while($row = mysqli_fetch_assoc($result)){
            component($row['product_name'], $row['product_price'], $row['product_image'],$row['id']);
        }

        ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>