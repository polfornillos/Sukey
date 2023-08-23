<?php
    session_start();
    include("dbconnection.php");

    if($_SERVER['REQUEST_METHOD']=="POST"){

        $msg = null;
        global $msg;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $suffix = $_POST['suffix'];

        if(!empty($username) && !empty($password)){

            $query = "insert into user(username, password, first_name, middle_name, last_name, suffix) 
            values('$username', '$password', '$firstname', '$middlename', '$lastname', '$suffix')";
            try{
                mysqli_query($conn, $query);
                header("Location: login.php");
                die;
            }catch(Exception $e){
                $msg="The Username you entered has been taken!";
            }
            
        }
        else{
            $msg= "Please enter valid information(s)!";
        }
    }
?>

<html>
<head>
	<title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/fcba06baee.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <link rel="stylesheet" href="registerStyle.css">
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

        <div id="registerUI">
            <form method = "post">
                <p id="registertxt">Register</p>
                <label>Username: </label>
                <input id="usernametext" type="text" name="username" required><br/><br/>
                <label>Password: </label>
                <input id="passtext" type="password" name="password" required><br/><br/>
                <label>First Name: </label>
                <input id="fntext" type="text" name="firstname" required><br/><br/>
                <label>Middle Name: </label>
                <input id="text" type="text" name="middlename" ><br/><br/>
                <label>Last Name: </label>
                <input id="lntext" type="text" name="lastname" required><br/><br/>
                <label>Suffix: </label>
                <input id="suffixtext" type="text" name="suffix"><br/><br/>
                <p id="errormessage"><?php if (isset($msg)){echo $msg;}?></p>
                <input id="btn" type="submit" value="Sign Up"><br/><br/>
                <input type="button" id="signBtn" value="Login" onClick="document.location.href='login.php'">
            </form>
        </div>
        
    </div>
</body>
</html>