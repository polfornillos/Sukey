<?php

    function check_login($conn){
        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];
            $result = "select * from user where username = '$username' limit 1";

            if($result && mysqli_num_rows($result) > 0){
                $user_data = mysqli_fetch_assoc($result);

                return $user_data;
            }
        }

        header("Location: login.php");
        die;
    }
?>