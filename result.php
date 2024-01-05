<?php
    session_start();
    $userID = $_SESSION["id"];
    $result = $_SESSION["result"];  
    require_once("config.php");
    $sql = "UPDATE player SET playerPokemon = NULL, playerHp = NULL, playerStatus = NULL WHERE playerID = :userID;";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    unset($_SESSION["result"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Win or Lose</title>
    <style>
        @import url(https://fonts.googleapis.com/earlyaccess/cwtexfangsong.css);
        body{
            font-family: "cwTeXFangSong";
        }
        .background-container {
            background-color: aquamarine;
            background-size: cover;
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        #win {
            display: none;
            transform: translate(40%,50%);
            color: green;
            font-size:30px;
            font-weight: bold;
        }
        #lose {
            display: none;
            transform: translate(40%,50%);
            color: red;
            font-size:30px;
            font-weight: bold;
        }
        @keyframes moveUpDown {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(300px); /* 設定垂直移動的距離 */
            }
        }

        /* 將動畫應用到文字上 */
        .moving-text {
            animation: moveUpDown 4s ease-in-out infinite; 
            position: absolute;
            top:25%;
            left: 25%;
            font-size:35px;
        }
        #continue{
            position: absolute;
            bottom: 20%;
            right: 55%;
            width: 200px;
            height: 100px;
            font-size:18px;
        }
        #logout{
            position: absolute;
            bottom: 20%;
            right: 35%;
            width: 200px;
            height:100px;
            font-size:18px;
            font-family: "cwTeXFangSong";
        }
        #dropdown-container {
            position: absolute;
            top: 10px;
            right: 10px;
            color:aqua;
        }
        select {
            width: 200px; 
            height: 30px; 
            background-color: ghostwhite; 
        }
        @media screen and (max-width: 768px) {
            #win,#lose{
                position: absolute;
                right:50%;
                top: 0%;
            }
            #logout{
                position: absolute;
                right: 20%;
            }
            .moving-text{
                animation: moveUpDown 4s ease-in-out infinite; 
                position: absolute;
                top:18%;
                left: 15%;
                font-size:25px;
            }
        }
    </style>
</head>
<body>
    <div class="background-container"></div>
    <div class="result" id="win">You win! Congratulations!</div>
    <div class="result" id="lose">You lose! Fight!</div>
    <p class="moving-text">給我們一點意見讓我們做得更好!請按左上方按鈕!。</p>
    <button id="continue" class="btn btn-success">繼續遊玩</button>
    <button id="logout" class="btn btn-danger">登出</button>
    <form action="#" method="get">
        <select name="help" onchange="window.location.href=this.value">
            <option value="https://wiki.52poke.com/zh-hant/%E5%B1%9E%E6%80%A7%E7%9B%B8%E5%85%8B%E8%A1%A8">屬性攻略</option>
            <option value="https://tw.portal-pokemon.com/">寶可夢官方網站</option>
            <option value="mailto:01057037@mail.ntou.edu.tw" selected>聯絡我們</option>
        </select>
    </form>
    <script>
        var result = null;
        try{
            result = <?php echo $result; ?>;
        } catch(e){
            console.log(e);
        }
        if(result == 1){
            document.getElementById("win").style.display = "block";
        }
        else{
            document.getElementById("lose").style.display = "block";
        }
        document.getElementById("continue").onclick = function(){
            window.location.href = "index.php";
        }
        document.getElementById("logout").onclick = function(){
            window.location.href = "logout.php";
        }
    </script>
</body>
</html>
