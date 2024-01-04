<?php
// Include config file
$db = require_once "config.php";

// Define variables and initialize with empty values
$username = $_POST["username"];
$password = $_POST["password"];
// $hash=password_hash($password,PASSWORD_DEFAULT);

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Prepare SQL statement
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Check if there is a matching user
        if ($stmt->rowCount() == 1) {
            // Fetch the row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verify the password using password_verify()
            if (password_verify($password, $row["password"])) {
                // Start the session
                session_start();
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $row["userID"];
                $_SESSION["username"] = $row["username"];
            

                // Redirect to enter.php page
                header("location: lobby.php");
            } else {
                function_alert("帳號或密碼錯誤");
            }
        } else {
            function_alert("帳號或密碼錯");
        }
    } catch (PDOException $e) {
        function_alert("發生錯誤: " . $e->getMessage());
    }
} else {
    function_alert("發生錯誤");
}

// Close the connection (connection is in config.php)
$db = null;

function function_alert($message)
{
    // Display the alert box
    echo "<script>alert('$message'); window.location.href='lobby.php';</script>";
    return false;
}
?>
