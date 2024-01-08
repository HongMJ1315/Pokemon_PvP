<!DOCTYPE html>
<html lang="en">
<?php
    require_once("config.php");
    session_start();
    $userID = $_SESSION["id"];
    $roomID = $_SESSION["roomID"];

    echo "<div style='width: 100%; height: 100vh; position: relative;'>
        <h1 style='position: absolute; top: 0%; left: 5%;' class='background-container'><span style='color: red;'>your room number is " . $roomID . "</span></h1>
      </div>";
?>



<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>玩家信息</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #ffffff;
        }

        .background-container {
            background-image: url("background/menu.png");
            background-size: cover;
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .player-container {
            position: absolute;
            right: 20%;
            background-color: #b5eef9;
            width: 60%;
            height: 45%;
            border-radius: 10px;
        }

        .player {
            display: inline-block;
            margin: 100px;
        }

        .player img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-top: 30px;
            /* 向上調整圖片位置 */
        }

        .player-info {
            margin-top: -80px;
            /* 向上調整 Player ID 位置 */
        }

        .status-text {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 5px;
            position: absolute;
            right:20%;
            bottom: 0%;
        }

        .button-container {
            margin-top: 20px;
        }

        #player1start {
            display: none;
            position: absolute;
            bottom: 300px;
            right: 280px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 5px;
        }

        #player2ready {
            display: none;
            position: absolute;
            bottom: 230px;
            right: 400px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 5px;
        }

        #player2cancelready {
            display: none;
            position: absolute;
            bottom: 230px;
            right: 280px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 5px;
        }
        #playerleave {
            /* display: none; */
            position: absolute;
            bottom: 230px;
            right: 260px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 5px;
        }

        button {
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

        button:hover {
            background: #2079b0;
            background-image: -webkit-linear-gradient(top, #2079b0, #eb94d0);
            background-image: -moz-linear-gradient(top, #2079b0, #eb94d0);
            background-image: -ms-linear-gradient(top, #2079b0, #eb94d0);
            background-image: -o-linear-gradient(top, #2079b0, #eb94d0);
            background-image: linear-gradient(to bottom, #2079b0, #eb94d0);
            text-decoration: none;
        }

        #status-text {
            position: absolute;
            width: 110px;
            height: 30px;
            right: 100px;
            bottom: 230px;
        }
        #playerleave{
            position: absolute;
            left:5%;
            width:20%;
            bottom:20%;
        }
        #playerleave{
            position: absolute;
            left:5%;
            width:20%;
            bottom:20%;
        }
        #player1start{
            position: absolute;
            left:53%;
            width:20%;
            bottom:20%;
        }
        #player2ready{
            position: absolute;
            left:53%;
            width:20%;
            bottom:20%;
        }
        #player2cancelready{
            position: absolute;
            left:75%;
            width:20%;
            bottom:20%;
        }
        @media screen and (max-width: 768px) {
            .player-container{
                position: absolute;
                width:90%;
                height:60%;
                padding: 0px;
                left: 5%;
            }
            #player1{
                position: absolute;
                left: 0%;
            }
            #player2{
                position: absolute;
                right: 0%;
            }
            #status-text{
                position: absolute;
                right: 14%;
                bottom: 35%;
            }
            #playerleave{
                position: absolute;
                left:10%;
                width:20%;
                bottom:10%;
            }
            #player1start{
                position: absolute;
                left:53%;
                width:20%;
                bottom:20%;
            }
            #player2ready{
                position: absolute;
                left:53%;
                width:20%;
                bottom:20%;
            }
            #player2cancelready{
                position: absolute;
                left:75%;
                width:20%;
                bottom:20%;
            }
        }
    </style>
</head>
<body>
    <div class="background-container"></div>
    <div class="player-container">
        <div class="player" id="player1">
            <div class="player-info"></div>
            <img src="" alt="Player 1">
        </div>
        <div class="player" id="player2">
            <div class="player-info"></div>
            <img src="" alt="Player 2">
        </div>
        <div class="status-text" id="status-text">未準備</div>
        <button id="player1start">開始</button>
        <button id="player2ready">準備</button>
        <button id="player2cancelready">取消準備</button>
        <button id="playerleave">離開</button>

        <!-- <button id="showButtons">顯示隱藏buttons</button> -->
    </div>
    <script>
        // 你的圖片文件
        const images = ['background/picture1.jpg', 'background/picture2.jpg', 'background/picture3.jpg', 'background/picture4.jpg'];
        var interval = null;
        var roomStatus = null;
        let userID = "<?php echo $userID; ?>";
        // 隨機選擇圖片
        function getRandomImage() {
            return images[Math.floor(Math.random() * images.length)];
        }

        // 設定玩家信息
        function setPlayerInfo(playerId, playerElement) {
            const playerImage = getRandomImage();
            const playerInfoElement = playerElement.querySelector('.player-info');

            // 設定玩家ID
            playerInfoElement.textContent = `Player ID: ${playerId}`;

            // 設定圖片
            playerElement.querySelector('img').src = playerImage;
        }

        // 設定兩個玩家的信息
        // setPlayerInfo(1, document.getElementById('player1'));
        // setPlayerInfo(2, document.getElementById('player2'));

        // 開始遊戲的函數
        function startGame() {
            console.log("startGame");
            // alert('游戏开始！');
            $.ajax({
                url: "room_event.php",
                type: "GET",
                data: {
                    operator: "Start",
                    value: "<?php echo $userID; ?>"
                },
                success: function (response) {
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            
            })
        }

        function leaveRoom(){
            $.ajax({
                url: "room_event.php",
                type: "GET",
                data: {
                    operator: "LeaveRoom",
                    value: "<?php echo $userID; ?>"
                },
                success: function (response) {
                    console.log(response);
                    resetPlayerRoom();
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        }
        // 准备的函數
        function prepare() {
            alert('玩家准备！');
            // 在這裡可以添加進一步的准备相關邏輯
        }

        // 取消准备的函數
        function cancelPrepare() {
            alert('取消准备！');
            // 在這裡可以添加進一步的取消准备相關邏輯
        }

        function showPrepareButton() {
            document.getElementById('player2ready').style.display = 'inline-block';
        }
        function hidePrepareButton() {
            document.getElementById('player2ready').style.display = 'none';
        }
        function showCancelPrepareButton() {
            document.getElementById('player2cancelready').style.display = 'inline-block';
        }
        function hideCancelPrepareButton() {
            document.getElementById('player2cancelready').style.display = 'none';
        }
        function showStartButton() {
            document.getElementById('player1start').style.display = 'inline-block';
        }
        function hideStartButton() {
            document.getElementById('player1start').style.display = 'none';
        }
        function resetPlayerRoom(){
            $.ajax({
                url: "room_event.php",
                type: "GET",
                data: {
                    operator: "ResetPlayerRoom",
                    userID: userID
                },
                success: function (response) {
                    alert("房間不存在");
                    interval = clearInterval(interval);
                    interval2 = clearInterval(interval2);
                    window.location.href = "lobby.php";
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        }
        function checkRoomStatus(){
            $.ajax({
                url: "room_event.php",
                type: "GET",
                data: {
                    operator: "CheckRoom"
                },
                success: function (response) {
                    console.log(response);
                    // 將 JSON 格式的字串轉換成 JavaScript 的物件
                    const roomInfo = JSON.parse(response);
                    console.log(roomInfo);
                    if(roomInfo.roomID == null){

                        resetPlayerRoom();
     
                        return;
                    }
                    if(roomInfo.status == 1){
                        alert("遊戲開始");
                        window.location.href = "choose.php";
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        }
        function checkPlayer2Status(){
            $.ajax({
                url: "room_event.php",
                type: "GET",
                data: {
                    operator: "GetPlayerInfo"
                },
                success: function (response) {
                    console.log(response);
                    // 將 JSON 格式的字串轉換成 JavaScript 的物件
                    const playerInfo = JSON.parse(response);
                    if(playerInfo.length == 0){
                        return;
                    }
                    console.log(playerInfo);
                    if(playerInfo.player2Name == null){
                        document.getElementById('player2').querySelector('.player-info').textContent = "Player ID:";
                        document.getElementById('player2').querySelector('img').src = "";
                        interval = clearInterval(interval);
                        interval = setInterval(function () {
                            getPlayerInfo();
                        }, 1000);
                        return;
                    }
                    if(playerInfo.player2Status == 1){
                        showStartButton();
                        $("#status-text").text("準備完成");
                    }
                    else if(playerInfo.player2Status == 0){
                        hideStartButton();
                        $("#status-text").text("未準備");
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        }


        function getPlayerInfo() {
            // room.php 會回傳一個 JSON 格式的字串
            // 裡面包含了兩個玩家的狀態
            // GET 參數為 room_id
            $.ajax({
                url: "room_event.php",
                type: "GET",
                data: {
                    operator: "GetPlayerInfo"
                },
                success: function (response) {
                    // 將 JSON 格式的字串轉換成 JavaScript 的物件
                    const playerInfo = JSON.parse(response);
                    console.log(playerInfo);
                    //檢查 playerInfo 長度
                    if(playerInfo.length == 0){
                        console.log("playerInfo == []");
                        interval = clearInterval(interval);
                        // interval2 = clearInterval(interval2);
                        resetPlayerRoom();
                        window.location.href = "lobby.php";
                        return;
                    }
                    if(playerInfo.player2Name != null){
                        setPlayerInfo(playerInfo.player2Name, document.getElementById('player2'));
                        interval = clearInterval(interval);
                        if(userID == playerInfo.player2ID){
                            showPrepareButton();
                        }
                        if(userID == playerInfo.player1ID){
                            interval = setInterval(function () {
                                checkPlayer2Status();
                            }, 1000);
                        }
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        }
    
        function init(){
            console.log("init");
            $.ajax({
                url: "room_event.php",
                type: "GET",
                data: {
                    operator: "GetPlayerInfo"
                },
                success: function (response) {
                    console.log(response);
                    // 將 JSON 格式的字串轉換成 JavaScript 的物件
                    const playerInfo = JSON.parse(response);
                    if(playerInfo == []){
                        console.log("playerInfo == []");
                        return;
                    }
                    setPlayerInfo(playerInfo.player1Name, document.getElementById('player1'));
                },
                error: function (xhr) {
                    console.log(xhr);
                    
                }
            });
            interval = setInterval(function () {
                getPlayerInfo();
            }, 1000);   
            interval2 = setInterval(function () {
                checkRoomStatus();
            }, 1000);
            // event listener for player2cancelready
            $("#player2cancelready").click(function(){
                showPrepareButton();
                $.ajax({
                    url: "room_event.php",
                    type: "GET",
                    data: {
                        operator: "UpdatePlayer2Status",
                        value: 0
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    }
                });
                hideCancelPrepareButton();
                $("#status-text").text("未準備");
            });
            // event listener for player2ready
            $("#player2ready").click(function(){
                hidePrepareButton();
                $.ajax({
                    url: "room_event.php",
                    type: "GET",
                    data: {
                        operator: "UpdatePlayer2Status",
                        value: 1
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    }
                });
                showCancelPrepareButton();
                $("#status-text").text("準備完成");
            });
        }

        init();
        
        // event listener for player1start
        $("#player1start").click(function(){
            startGame();
        });
        // event listener for playerleave
        $("#playerleave").click(function(){
            leaveRoom();
        });
    </script>

</body>

</html>