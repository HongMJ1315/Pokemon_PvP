<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: lobby.php");
    exit;  //記得要跳出來，不然會重複轉址過多次
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url('background/login.png'); /* 背景圖片的 URL */
            background-size: cover; /* 使背景圖片充滿整個視窗 */
            transition: background-color 0.3s ease; 
        }

        form {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            border-radius: 10px;
        }

        label {
            display: inline-block;
            width: 80px;
            text-align: right;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        input {
            padding: 8px;
            margin-bottom: 16px;
            transition: background-color 0.3s ease; /* 背景色變化的動畫效果 */
        }
        
        input[type="submit"],
        input[type="button"] {
            width: 100px;
            height: 80px;
            background: #eb94d0;
            /* 创建渐变 */
            background-image: -webkit-linear-gradient(top, #eb94d0, #2079b0);
            background-image: -moz-linear-gradient(top, #eb94d0, #2079b0);
            background-image: -ms-linear-gradient(top, #eb94d0, #2079b0);
            background-image: -o-linear-gradient(top, #eb94d0, #2079b0);
            background-image: linear-gradient(to bottom, #eb94d0, #2079b0);
            /* 给按钮添加圆角 */
            -webkit-border-radius: 28;
            -moz-border-radius: 28;
            border-radius: 28px;
            text-shadow: 3px 2px 1px #9daef5;
            -webkit-box-shadow: 6px 5px 24px #666666;
            -moz-box-shadow: 6px 5px 24px #666666;
            box-shadow: 6px 5px 24px #666666;
            font-family: Arial;
            color: #fafafa;
            font-size: 27px;
            padding: 19px;
            text-decoration: none;
        }
        input[type="sumbit"]:hover,
        input[type="button"]:hover{
            background: #2079b0;
            background-image: -webkit-linear-gradient(top, #2079b0, #eb94d0);
            background-image: -moz-linear-gradient(top, #2079b0, #eb94d0);
            background-image: -ms-linear-gradient(top, #2079b0, #eb94d0);
            background-image: -o-linear-gradient(top, #2079b0, #eb94d0);
            background-image: linear-gradient(to bottom, #2079b0, #eb94d0);
            text-decoration: none;
        }
        input:focus,
        input:active {
            background-color: #ffa07a; /* 獲得焦點時的背景色 */
        }
    </style>
</head>
<body>

    <form method="post" action="login.php">
        <label for="username">帳號：</label>
        <input type="text" id="username" name="username" required>
        <br>
        
        <label for="password">密碼：</label>
        <input type="password" id="password" name="password" required>
        <br>

        <input type="submit" value="進入">
        <input type="button" value="註冊" onclick="location.href='register.html'">
    </form>

    <script>
        // 使用 JavaScript 監聽 keydown 事件
        document.getElementById('username').addEventListener('keydown', function () {
            document.body.style.backgroundColor = '#ffa07a'; // 背景色變化
        });

        document.getElementById('password').addEventListener('keydown', function () {
            document.body.style.backgroundColor = '#ffa07a'; // 背景色變化
        });
    </script>

    </body>
    </html>






