<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$db = "clinic";

$conn = new mysqli($host,$user,$password,$db);

if($conn->connect_error){
    die("Connection Failed" . $connect_error);
}
if($_SERVER["REQUEST_METHOD"] == "POST")){

    $userName = $_POST["userName"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $sql = "SELECT id,dusername,demail,dpsswrd FROM doctors WHERE dusername = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$userName);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if(password_verify($password,$row['password'])){
            $_session["doctor_id"] = $row['id'];
            header('location: doctor/index.php');
            exit();
        }
        else echo "Motpasse est incorrect !";
    }else  echo "aucun utilisateur trouvé !";
    $stmt->close();

}
$conn->close();

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Mina Finance</title>
</head>
<body>
    <a class="logo" href="signIU.html">Mina Finance</a>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="signup.php" method="post">
                <h1> Créer un compte</h1>
                <span> ou utilisez votre email pour vous inscrire</span>
                <input type="text" placeholder="Name" name="userName" id="userName"/>
                <input type="email" placeholder="Email" name="email" id="email" />
                <input type="password" placeholder="Password"  name="password" id="password"/>
                <input type="radio" name="role"  id="doctor" value="doctor" required>
                <label for="doctor">Doctor</label>
                <input type="radio" name="role" id="receptionist" value="receptionniste" required>
                <label for="receptionniste">Receptionniste</label>
                <button>S'inscrire</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="login.php" method="post">
                <h1>Se connecter</h1>
                <span> ou utilisez votre compte</span>
                <input type="email" placeholder="Email" />
                <input type="password" placeholder="Mot de passe" />
                <input type="radio" name="role"  id="doctor" value="Doctor" required>
                <label for="doctor">Doctor</label>
                <input type="radio" name="role" id="receptionist" value="receptionniste" required>
                <label for="receptionist">Receptionniste</label>
                <a href="#">Mot de passe oublié ?</a>
                <button>Se connecter</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1> Content de vous revoir!</h1>
                    <p> Pour rester en contact avec nous, veuillez vous connecter avec vos informations personnelles</p>
                    <button class="ghost" id="signIn">Se connecter</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1> Bonjour mon ami!</h1>
                    <p> Entrez vos informations personnelles et commencez votre voyage avec nous</p>
                    <button class="ghost" id="signUp">S'inscrire</button>
                </div>
            </div>
        </div>
    </div>
    <script src="main.js"></script>


    
</body>
</html>