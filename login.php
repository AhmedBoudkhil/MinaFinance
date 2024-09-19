<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "clinic";

$conn = new mysqli($host,$username,$password,$db);

if($conn->connect_error){
    die("Connection failed". $conn->connect_error);
}

function checkCre($conn,$table,$email,$password,$emailField,$psswrdField,$role){
    $sql = "SELECT * FROM $table WHERE $emailField ='$email' ";

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($password,$user[$psswrdField])){
            session_start();
            $_SESSION[$role.'_id'] = $user["id"];
            header("location: $role/index.php");
            exit();
        }else{
            echo "Mot de passe ou email est invalid !";
        }
    }else  die("Aucun compte trouvé cet email");

}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $role = $_POST["role"];
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = $_POST["password"];

    if($role == "doctor"){
        $table = "doctors";
        $emailField = "demail";
        $psswrdField = "dpsswrd";
        checkCre($table,$email,$password,$emailField,$psswrdField,$role);
        
    }elseif($role == "receptionniste"){
        $table = "receptionists";
        $emailField = "remail";
        $psswrdField = "rpsswrd";
        checkCre($table,$email,$password,$emailField,$psswrdField,$role){
    }else die("Invalid Role ! ");
}
$conn->close();
?>