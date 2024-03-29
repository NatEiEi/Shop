<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';
?>

<?php
    $Username = $_POST['Username'];
    $FName = $_POST['FName'];
    $LName = $_POST['LName'];
    $Sex = $_POST['Sex'];
    $Password = $_POST['Password'];
    $Tel = $_POST['Tel'];

    $query = "SELECT * FROM newcustomer WHERE Username = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$Username]);

    if($statement->rowCount() == 0) {
        $hashed_password = password_hash($Password, PASSWORD_ARGON2I);
    
        $query =    "INSERT INTO newcustomer (Username ,Password, FName , LName , Sex , Tel) 
                    VALUES ( ? , ? , ? , ? , ? , ? );";
        $statement = $pdo->prepare($query);
        $statement->execute([$Username,$hashed_password, $FName, $LName , $Sex , $Tel]);
        echo "$hashed_password";
    } else {
        echo "Username is already used!";
    }
?>