<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';

    if (isset($_POST['Username']) && isset($_POST['password'])){
        $Username = $_POST['Username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM customer WHERE Username='$Username'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {

            $Username = $user["Username"];
            $FName = $user['FName'];
            $LName = $user['LName'];
            
            $_SESSION['Username'] = $Username;
            $_SESSION['FName'] = $FName;
            $_SESSION['LName'] = $LName;

            echo "Login Successfully...";
            date_default_timezone_set('Asia/Bangkok');
            $query = "INSERT INTO log (Date, Username, Action) VALUES (NOW(), '$Username', 'Login')";
            $statement = $pdo->prepare($query);
            $statement->execute();
            header('Location: Home.php');
            exit;
        }
        else {
            echo "Login Failed...";
            echo "Username or Password Is not correct.";
        }
    }
?>

<div>
    <form action="login.php" method="POST" class="form-container">
      <h1>User Login</h1>

      <label for="Username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="Username" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>

      <button type="submit" class="btn">Login</button>
    </form>
</div>