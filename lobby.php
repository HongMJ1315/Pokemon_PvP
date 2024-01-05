
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/earlyaccess/cwtexfangsong.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      background-image: url('background/login.png');
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    #createRoomButton1{
        position: absolute;
        right: 52%;
        bottom: 40%;
        width:170px;
        height:80px;
        font-size:24px;
      }
    #createRoomButton2{
        position: absolute;
        right: 38%;
        bottom: 40%;
        width:170px;
        height:80px;
        font-size:24px;
    }
    #logoutButton{
        position: absolute;
        right:5%;
        top:5%;
        width:170px;
        height:80px;
        font-size:24px;
    }
    @media screen and (max-width: 768px) {
        #createRoomButton1{
          width: 80%;
          left: 10%;
          bottom: 55%;
        }
        #createRoomButton2 {
          width: 80%; /* 讓按鈕佔據整個寬度 */
          left:10%;
          bottom:40%;
        }
        body{
          background-size: cover;
        }
    }
    .centered-text {
        text-align: center;
        color: #3b4af6; /* 藍色 */
        margin-top: 50vh; /* 將文字置於頁面垂直中央 */
        transform: translateY(-50%);
    }
  </style>
  <script>
    function redirectToChoosePage() {
      // 跳轉到 choose.html 文件
      window.location.href = 'choose.html';
    }
    function redirectToindexPage() {
      // 跳轉到 choose.html 文件
      window.location.href = 'logout.php';
    }

    function createRoomButton() {
        window.location.href = 'lobby_event.php?operator=create';
    }

    function joinRoomButton() {
        var roomID = prompt("請輸入房間號碼");
        if (roomID) {
            window.location.href = 'lobby_event.php?operator=join&roomID=' + roomID;
        }
    }

    function init(){
        $.ajax({
            url: "lobby_event.php",
            type: "GET",
            data: {
                operator: "insertPlayer"
            },
            error: function (message) {
                console.log(message);
            }
        });
    }
    init();
  </script>
</head>
<body>
    <?php
        session_start();  //很重要，可以用的變數存在session裡
        $username=$_SESSION["username"];
        $id = $_SESSION["id"];
        echo "<h1 class='centered-text'>你好 ".$username."</h1>";
        echo "<h1 class='centered-text'>你的ID是 ".$id."</h1>";
        $roomID = isset($_SESSION["roomID"]) ? $_SESSION["roomID"] : "";
        if($id == NULL){
            echo "<script>alert('請先登入'); window.location.href='index.php';</script>";
        }
        if($roomID != ""){
            echo "<h1>你的房間號碼是 ".$roomID."</h1>";
            //三秒後跳轉
            header("Refresh:3;url=room.php");
        }
    ?>
    <button id="loginButton" onclick="redirectToChoosePage()">Enter</button>
    <button id="createRoomButton" onclick="createRoomButton()">Create Room</button>
    <button id="createRoomButton" onclick="joinRoomButton()">Join Room</button>
    <button id="logoutButton" onclick="redirectToindexPage()">登出</button>
</body>
</html>
