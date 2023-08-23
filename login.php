<?php
    session_start();
    include("dbconnection.php");

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $msg = null;
        global $msg;
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password)){

            $query = "select * from user where username = '$username' limit 1";
            $result = mysqli_query($conn, $query);

            if($result){
                if($result && mysqli_num_rows($result)>0){
                    $userdata = mysqli_fetch_assoc($result);
                    if($userdata['password'] === $password){

                        $_SESSION['id'] = $userdata['id'];
                        header("Location:index.php");
                    }
                }
            }
            $msg = "Wrong username or password!";
           
        }
        else{
            $msg = "Please enter valid information(s)!";
        }
    }
?>

<html>
<head>
	<title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/fcba06baee.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <link rel="stylesheet" href="loginStyle.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700&display=swap');
    </style>
</head>
<body>
    <div id="main">
        <div id ="logo">    
            <a id="sukeyLogo" href="index.php" style="text-decoration:none">Su<span>key!</span></a> 
        </div>
        <p id="subtxt">The key to <span id="subtxtspan">all your needs</span></p> 
        
        <div id="loginUI">
            <form method = "post">
                <p id="logintxt">LOGIN</p>
                <div id=space></div>
                <label>Username: </label>
                <input id="text" type="text" name="username"><br/><br/>
                <label>Password: </label>
                <input id="passtxt" type="password" name="password"><br/><br/>
                <p id="errormessage"><?php if (isset($msg)){echo $msg;}?></p>
                <input id="btn" type="submit" value="Log In"><br/><br/>

                <input type="button" id="signBtn" value="Sign Up" onClick="document.location.href='register.php'">
            </form>
        </div>
    </div>
</body>
</html>
