<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "clinic";

$conn = new mysqli($host,$username,$password,$db);

if($conn->connect_error){
    die("Connection failed". $conn->connect_error);
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userName = mysqli_real_escape_string($conn,$_POST["userName"]);
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
    $role = $_POST["role"];

}

function checkAndRegister($conn,$table,$userNameField,$emailField,$passwordField,$userName,$email,$password,$role){
    $sql = "SELECT * FROM $table WHERE $emailField = '$email' OR $userNameField = '$userName'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        echo " Le nom d'utilisateur ou l'e-mail existe déjà !";
    }else{
        $sql = "INSERT INTO $table ($userNameField,$emailField,$passwordField) VALUES('$userName','$email','$password');";

        if($conn->query($sql)){
            echo " Inscription réussie !";
        }else echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if($role === 'doctor'){
    $table = 'doctors';
    $userNameField = 'dusername';
    $emailField = 'demail';
    $passwordField = 'dpsswrd';
    checkAndRegister($conn,$table,$userNameField,$emailField,$passwordField,$userName,$email,$password,$role);
}elseif( $role === "receptionniste"){
    $table = 'receptionists';
    $userNameField = 'rusername';
    $emailField = 'remail';
    $passwordField = 'rpsswrd';
    checkAndRegister($conn,$table,$userNameField,$emailField,$passwordField,$userName,$email,$password,$role);
}

$conn->close();
?>