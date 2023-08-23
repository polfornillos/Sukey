<?php
    session_start();
    include("dbconnection.php");

    if (isset($_GET['search'])){
        $search = $_GET['search'];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://kit.fontawesome.com/fcba06baee.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
        <link rel="stylesheet" href="homePage_Style.css">
        
        
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
        <div id="featureProducts">
            <div id="listings-items-fp">
                <div class="item">
                <?php
                    $query = "select * from products";
                    $result = mysqli_query($conn, $query);

                    while($data = mysqli_fetch_assoc($result)){
                ?>
                    
                    <div class="productList">
                        
                    </div>
                    <div class="col-md-4">  
                    <form action="ProductPage.php" method="post">
                        <div  id="products">  
                            <button class="productName" type="submit" name="product_name" value="<?php echo $data['product_name']; ?>">
                                <img class="productImg" src="Products/<?php echo $data['img_dir']; ?>">
                            </button>
                            <div id ="product-details">
                                <p id="item-name"><?php echo $data['product_name'];  ?></p>
                                <p id="item-price">PHP <?php echo $data['price'];  ?></p>
                            </div>
                        </div>  
                     </form>  
                </div> 
                <?php
                    }
                ?>
                </div>
            </div>
        </div>

        <form action="Checkout.php">
            <button id="cart" type="submit"><i class="fa-solid fa-bag-shopping fa-2x"></i></button>
        </form>
        <div id=space2></div>

        <script src="homeJS.js"></script> 
        <?php 
        if (isset($_SESSION['id'])){
            echo " <script type='text/javascript'>changeStatus();</script>";
        }
        else{echo " <script type='text/javascript'>disableCart();</script>";
        }
        ?>
    </body>
</html>
