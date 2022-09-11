<?php
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

if ( !empty($username) || !empty($password) || !empty($email)){
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "8520";
    $dbname = "register";

    //create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

   if (mysqli_connect_error()){
    die('Connect_Error('.mysqli_connect_errno().')'.mysqli_connect_error());
   }else{
    $SELECT = "SELECT email from register Where email = ? Limit 1";
    $INSERT = "INSERT Into register (username, password, email) values(?, ?, ?)";

    //prepare statement
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    if ($rnum==0){
        $stmt->close();

        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();
        echo "New Recorded Inserted Succesfully";
    } else {
        echo "Someone Already Registered This E-mail";
    }
    $stmt->close();
    $conn->close();

   }

} else {
    echo "All field are required";
    die();
}

?>