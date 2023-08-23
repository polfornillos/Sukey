<?php
    session_start();
    include("dbconnection.php");
    include("dbfunctions.php");

    if (isset($_GET['search'])){
        $search = $_GET['search'];
    }
    
    if (isset($_POST['product_name'])){
        $query = "select * from products where product_name = '".$_POST['product_name']."'";
        $result = mysqli_query($conn, $query);

        while($data = mysqli_fetch_assoc($result)){
            $name = $data['product_name'];
            $qty = $data['quantity'];
            if($qty == 0){
                $msg = "Out of stock";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php if (isset($msg)){echo $name;} ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://kit.fontawesome.com/fcba06baee.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
        <link rel="stylesheet" href="productPageStyle.css">
        
        
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700&display=swap');
        </style>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>        
    </head>

    <body>
           
        <div id ="logo">    
            <a id="sukeyLogo" href="index.php" style="text-decoration:none">Su<span>key!</span></a>  
        </div>
        <nav>
            <div class="nav-area">
                <form action="search.php" method="GET">
                    <div class="nav-bar">
                        <input id="search-bar" type="text" name="search" placeholder="Search for anything">
                        <button type="submit" id="searchBtn"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <button type="submit" id="homeIcon" onclick="window.location='index.php';"><div id="onlinestatus"></div><i class="fa-solid fa-house fa-2x"></i></button>
                <button type="submit" id="cartIcon" onclick="window.location='Checkout.php';"><i class="fa-solid fa-basket-shopping fa-2x"></i></button>
                <button type="submit" id="logoutIcon" onclick="window.location='logout.php';"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i></button>

            </div>
        </nav>

        <div id=space></div>

        <div id="productPageBody">
            <div id="productImage">
                <?php
                    if (isset($_POST['product_name'])){
                        $query = "select * from products where product_name = '".$_POST['product_name']."'";
                        $result = mysqli_query($conn, $query);
                        while($data = mysqli_fetch_assoc($result)){
                ?>
                    
            </div>
            <div id="productDesc">
                <form action="ProductPage.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <img class="productImg" src="Products/<?php echo $data['img_dir']; ?>"><input type="hidden" name="img" value="<?php echo $data['img_dir'];?>"></img>
                    <h2 class="productName"><input type="hidden" name="name" value="<?php echo $data['product_name']; ?>"><?php echo $data['product_name']; ?></h2>
                    <h2 class="productPrice"><input type="hidden" name="price" value="<?php echo $data['price']; ?>">PHP <?php echo $data['price']; ?></h2>
                    <p class="productQty">Stocks Left: <?php echo $data['quantity']; ?></p>
                    <p class="outofstock"><?php if (isset($msg)){echo $msg;}?></p>
                    <?php
                     }}
                    ?>
                    <input type="number" id="quantity" name="qty" min="1" max="<?php echo $qty?>" required>
                    <button id="addtocart" name="add-to-cart" type="submit">Add to cart</button>      
                </form>
            </div>
	    </div>
        <form action="Checkout.php">
            <button id="cart" type="submit"><i class="fa-solid fa-bag-shopping fa-2x"></i></button>
        </form>
        <div id=space></div>
                    
        <script src="homeJS.js"></script> 
        <?php

            if (isset($_SESSION['id'])){
                echo " <script type='text/javascript'>changeStatus();</script>";
                
                if(isset($_POST['add-to-cart'])){
                    $_SESSION['cart'][]=array(
                        'id' =>rand(100,1000),
                        'prodid' => $_POST['id'],
                        'name' => $_POST['name'],
                        'price' => $_POST['price'],
                        'img' => $_POST['img'],
                        'qty' =>$_POST['qty'],
                    );
                    echo '<script>window.location.href="index.php";
                    alert("Item added to cart successfully")
                    </script>';
                }
            }
            else{echo " <script type='text/javascript'>disableCart();</script>";}
        ?>
    </body>
</html>
