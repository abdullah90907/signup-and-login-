<?php 

include 'connect.php';

if(isset($_POST['signUp'])){
    $name = $_POST['name']; // Changed from firstName and lastName to name
    $rank = $_POST['rank']; // New rank field
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "Email Address Already Exists!";
    } else {
        // Adjusted insert query to include name and rank
        $insertQuery = "INSERT INTO users(name, rank, email, password)
                        VALUES ('$name', '$rank', '$email', '$password')";
        if($conn->query($insertQuery) == TRUE){
            header("location: index.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
   $email = $_POST['email'];
   $password = $_POST['password'];
   $password = md5($password);
   
   $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
   $result = $conn->query($sql);
   if($result->num_rows > 0){
       session_start();
       $row = $result->fetch_assoc();
       $_SESSION['email'] = $row['email'];
       header("Location: homepage.php");
       exit();
   } else {
       echo "Not Found, Incorrect Email or Password";
   }
}
?>
