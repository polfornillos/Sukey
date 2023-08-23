<?php
    session_start();
    include("dbconnection.php");
    include("dbfunctions.php");

    if (isset($_GET['search'])){
        $search = $_GET['search'];
    }


    if(isset($_GET['empty'])){
        unset($_SESSION['cart']);
    }

    if(isset($_GET['remove'])){
        $id = $_GET['remove'];
        foreach($_SESSION['cart'] as $k => $part){
            if($id == $part['id']){
                unset($_SESSION['cart'][$k]);
            }
        }
    }

    if(isset($_GET['success'])){
        foreach($_SESSION['cart'] as $k => $item)
        {
            $qty = $item["qty"];
            $id  = $item["prodid"];
            $query = "update products set quantity = greatest(0, quantity - $qty) where id = $id";
            try{
                mysqli_query($conn, $query);
            }catch(Exception $e){
                $msg="The Username you entered has been taken!";
            }
        }
        unset($_SESSION['cart']);
        echo '<script>window.location.href="index.php";
                alert("Purchased successfully!")
                </script>';
    }

   
   

    $total=0;
    global $total;
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Checkout</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://kit.fontawesome.com/fcba06baee.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
        <link rel="stylesheet" href="CheckoutPageStyle.css">
        
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
        <div id="empty">
            <a class="empty" id="emptyCart" href="checkout.php?empty=1"><i class="fa-solid fa-trash-can fa-2x"><span class="emptyTxt">Remove all items</span></i></a>
        </div>

        <div id="purchase">
            <a class="purchase" id="purchaseCart"><i class="fa-solid fa-cash-register fa-2x"></i><span class="purchaseTxt">Checkout</span></i></a>
        </div>
        
        <div id=space></div>
        <?php if(isset($_SESSION['cart'])) :?>
            <?php foreach($_SESSION['cart'] as $k => $item) :?>

                <table>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <tr>
                        <td id="image"><img src="Products/<?php echo $item['img'];?>"></td>
                        <td width="200px"><?php echo $item['price']; ?></td>
                        <td width="300px"><?php echo $item['name']; ?></td>
                        <td><?php echo $item['qty']; ?></td>
                        <td width="200px">PHP <?php echo $item['price']*$item['qty']; ?></td>
                        <td  width="130px" style="text-align:center;color:red"><a id="remove"style="color: none;" href="checkout.php?remove=<?php echo $item['id'];?>"><i class="fa-solid fa-circle-minus fa-2x"></i></td>
                    </tr>
                    <?php $total+=$item['price']*$item['qty']?>
                </table>
               <br>
            <?php endforeach ?>
        <?php endif ?>
        <div class="payment-form">
                    <div id="payment-form-content">
                        <div id="payment-header">
                            <div id="payment-header-title">
                                <p>Choose Payment Method</p>
                                <button class ="closeBtn" type="button"></button>
                            </div>  
                        </div>
                        <div id="payment-form-details">
                            <form>
                                <button class ="cashondeliverybtn" type="button">Cash On Delivery</button>
                                <button class ="creditcardbtn" type="button" >Credit/Debit Card</button>
                            </form>
                        </div>
                    </div> 
                </div>
                
        <div class="cashondelivery-form">
            <div id="cashondelivery-form-content">
                    <div id="cashondelivery-header">
                        <div id="cashondelivery-header-title">
                                <p>Cash on Delivery</p>
                                <button class ="closeBtn1" type="button"></button>
                        </div>  
                    </div>
                    <div id="cashondelivery-form-details">
                    <form action="checkout.php">
                        <h1>Enter Your Shipping address:</h1>
                        <h3>Your total is: PHP <?php echo $total?></h3>
                        <textarea id="cashondelivery" class="cashondeliverytxt" required></textarea>
                        <input class ="cashondeliverysubmit" name="success" type="submit" value="Purchase">
                    </form>
                </div>
            </div> 
        </div>

        <div class="creditcard-form">
            <div id="creditcard-form-content">
                    <div id="creditcard-header">
                        <div id="creditcard-header-title">
                                <p>Credit/Debit Card</p>
                                <button class ="closeBtn2" type="button"></button>
                        </div>  
                    </div>
                    <div id="creditcard-form-details">
                    <form action="checkout.php">
                        <br>
                        <h3>Your total is: PHP <?php echo $total?></h3>
                        <h1 id=card-details>Enter Your Card Details:</h1>
                        <div class="cc-container">
                            <label>Card Number:</label>
                            <input type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" class="CCnumber" maxlength="19" placeholder="1234 5678 9012 3456"required>
                        </div>
                        <div class="cvv-container">
                            <label>CVV:</label>
                            <input type="tel" class="CVVnumber" maxlength="3" placeholder="123" required >
                        </div>
                        <div class="exp-container">
                            <label>Expiration Date:</label>
                            <input type="text" class="ExpirationDate" maxlength="5" placeholder="MM/YYYY" required>
                        </div>
                        
                        <h1 id=address>Enter Your Shipping address:</h1>
                        <textarea id="creditcard" name="pay" class="creditcardtxt" required></textarea>
                        <input class ="creditcardsubmit" name="success" type="submit" value="Purchase">
                    </form>
                </div>
            </div> 
        </div>
        <script src="checkoutJS.js"></script> 
        <script type="text/javascript">
            
            document.querySelector('.closeBtn').addEventListener('click',function(){
            document.querySelector('.payment-form').style.display ='none';
            });  
            document.querySelector('.purchase').addEventListener('click',function(){
            document.querySelector('.payment-form').style.display ='flex';
            });  
            document.querySelector('#purchase').addEventListener('click',function(){
            document.querySelector('.payment-form').style.display ='flex';
            });  

            document.querySelector('.cashondeliverybtn').addEventListener('click',function(){
            document.querySelector('.cashondelivery-form').style.display ='flex';
            }); 
            document.querySelector('.closeBtn1').addEventListener('click',function(){
            document.querySelector('.cashondelivery-form').style.display ='none';
            }); 

            document.querySelector('.creditcardbtn').addEventListener('click',function(){
            document.querySelector('.creditcard-form').style.display ='flex';
            }); 
            document.querySelector('.closeBtn2').addEventListener('click',function(){
            document.querySelector('.creditcard-form').style.display ='none';
            }); 

            function changeStatus(){
                var element = document.getElementById("onlinestatus");
                element.style.backgroundColor = "green";
            }

            
        </script>
        <?php
            if (isset($_SESSION['id'])){
                echo " <script type='text/javascript'>changeStatus();</script>";
            }
            else{
                echo " <script type='text/javascript'>disableCart();</script>";
            }
        ?>
    </body>
</html>