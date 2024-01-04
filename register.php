<?php
require_once("config.php");

function registerUser($db) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Check if the username already exists
        $checkQuery = "SELECT * FROM user WHERE username=:username";
        $checkStatement = $db->prepare($checkQuery);
        $checkStatement->bindParam(':username', $username);
        $checkStatement->execute();

        if ($checkStatement->rowCount() == 0) {
            // Username does not exist, proceed with registration
            $insertQuery = "INSERT INTO user (userID, username, password) VALUES (NULL, :username, :password)";
            $insertStatement = $db->prepare($insertQuery);
            $insertStatement->bindParam(':username', $username);
            $insertStatement->bindParam(':password', $password);

            if ($insertStatement->execute()) {
                echo "註冊成功!3秒後將自動跳轉頁面<br>";
                echo "<a href='index.php'>未成功跳轉頁面請點擊此</a>";
                header("refresh:3;url=index.php");
                exit;
            } else {
                echo "Error creating table: " . $insertStatement->errorInfo()[2];
            }
        } else {
            // Username already exists
            echo "該帳號已有人使用!<br>3秒後將自動跳轉頁面<br>";
            echo "<a href='register.html'>未成功跳轉頁面請點擊此</a>";
            header('HTTP/1.0 302 Found');
            header("refresh:3;url=register.html");
            exit;
        }
    }
}

// Call the function with the $db variable
registerUser($db);

// Close the PDO connection (not necessary here as it's automatically closed when the script ends)

function function_alert($message)
{
    // Display the alert box
    echo "<script>alert('$message'); window.location.href='index.php';</script>";

    return false;
}
?>
