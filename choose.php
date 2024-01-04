<?php
    session_start();
    $userID = $_SESSION["id"];
    $roomID = $_SESSION["roomID"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Display</title>
    <style>
        body {
            position: relative;
            min-height: 100vh;
            margin: 0px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            background-image: url('background/background.jpg');
            background-size: cover;
        }
        
        img {
            width: 10%;
            height: 100px;
            border: 5px solid transparent; /* Set a transparent border by default */
            transition: transform 0.3s ease, border 0.3s ease; /* Include border in the transition */
        }
        
        img:hover {
            transform: scale(1.1);
            border: 5px solid rgb(192, 44, 44); /* Change to a solid border on hover */
        }
        
        .image-container {
            width: 100%;
            position: absolute;
            bottom: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .loading {
            /*full screen */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

        }
    </style>
    <script>
        var skills = [];
        var pokemonData = [];
        var interval = null;
        var interval2 = null;
        var playerInfo = null;
        let userID = <?php echo $userID; ?>;
        let roomID = "<?php echo $roomID; ?>";
        function getSkillsNames(skillIds) {
            // 將技能ID映射為技能名稱
            var skillNames = skillIds.map(function (skillId) {
                var foundSkill = skills.find(function (s) {
                    return s.id === skillId;
                });
                return foundSkill ? foundSkill.name : "未知技能";
            });
            return skillNames;
        }
        function showConfirmation(imgId) {
            // 獲取點擊的圖片的 id
            var pokemonId = document.getElementById(imgId).id;
    
            // 在 pokemonData 陣列中找到對應的 Pokemon 物件
            var selectedPokemon = pokemonData.find(function (pokemon) {
                return pokemon.name === pokemonId;
            });
            
            // 如果找到符合的 Pokemon，顯示相應的資料
            if (selectedPokemon) {
                var skillsNames = getSkillsNames(selectedPokemon.skills);
                var result = confirm(
                    "確認選擇 " +
                    selectedPokemon.name +
                    " 作為對戰寶可夢?\n" +
                    "HP: " + selectedPokemon.hp + "\n" +
                    "攻擊: " + selectedPokemon.attack + "\n" +
                    "防禦: " + selectedPokemon.defense + "\n" +
                    "速度: " + selectedPokemon.speed + "\n" +
                    "屬性: " + selectedPokemon.types.join(", ") + "\n" +
                    "技能: " + skillsNames
                );
                if(result == true){
                    $.ajax({
                        url: "choose_event.php",
                        type: "GET",
                        data: {
                            operator: "UpdatePlayerPokemon",
                            pokemon: selectedPokemon.name,
                        },
                        success: function (response) {
                            $("#pokemon").hide();
                            // window.location.href = "lobby.php";
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                }
            } 
            else {
                alert("找不到符合的寶可夢資料。");
            }
            var pokemonId = imgId;
            // 將 Pokemon 的 ID 傳遞到 battle.html
            // window.location.href = "battle.html?pokemonId=" + encodeURIComponent(pokemonId);
        }
        function checkAllPlayerStatus(){
            $.ajax({
                url: "choose_event.php",
                type: "GET",
                data: {
                    operator: "CheckAllPlayerStatus",
                },
                success: function (response) {
                    if(response == 1){
                        $.ajax({
                            url: "choose_event.php",
                            type: "GET",
                            data: {
                                operator: "UpdateRoomStatus",
                                roomID: roomID
                            },
                            success: function (response) {
                                interval = clearInterval(interval);
                                $("#pokemon").hide();
                                alert("對戰開始");
                                window.location.href = "battle.php";
                            }
                        });
                        
                    }
                    
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
        function init(){
            $("#pokemon").hide();
            // $("#loading").show();
            $.ajax({
                url: "pokemon.json",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    pokemonData = response;
                    $.ajax({
                        url: "skill.json",
                        type: "GET",
                        dataType: "json",
                        success: function (response) {
                            skills = response;
                            
                            $.ajax({
                                url: "room_event.php",
                                type: "GET",
                                data: {
                                    operator: "GetPlayerInfo",
                                    roomID: roomID
                                },
                                success: function (response) {
                                    const playerInfo = JSON.parse(response);
                                    $("#pokemon").show();
                                    // $("#loading").hide();
                                    interval = setInterval(checkAllPlayerStatus, 1000);
                                },
                            })
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                },
                error: function (err) {
                    console.log(err);
                }
            });
            
        }
        init();
        
        

    </script>
</head>
<body>
    <!-- <div class = "loading" id = "loading">
        <img src="loading.gif" alt="loading" width="100" height="100">
    </div> -->
    <div class="image-container" id = "pokemon">
        <img src="pokemon/Abra.png" id="Abra" onclick="showConfirmation(this.id)">
        <img src="pokemon/Blastoise.png" id="Blastoise" onclick="showConfirmation(this.id)">
        <img src="pokemon/Blaziken.png" id="Blaziken" onclick="showConfirmation(this.id)">
        <img src="pokemon/Bulbasaur.png" id="Bulbasaur" onclick="showConfirmation(this.id)">
        <img src="pokemon/Charizard.png" id="Charizard" onclick="showConfirmation(this.id)">
        <img src="pokemon/Charmander.png" id="Charmander" onclick="showConfirmation(this.id)">
        <img src="pokemon/Clefable.png" id="Clefable" onclick="showConfirmation(this.id)">
        <img src="pokemon/Dragonite.png" id="Dragonite" onclick="showConfirmation(this.id)">
        <img src="pokemon/Electivire.png" id="Electivire" onclick="showConfirmation(this.id)">
        <img src="pokemon/Exeggutor.png" id="Exeggutor" onclick="showConfirmation(this.id)">
        <img src="pokemon/Garchomp.png" id="Garchomp" onclick="showConfirmation(this.id)">
        <img src="pokemon/Gardevoir.png" id="Gardevoir" onclick="showConfirmation(this.id)">
        <img src="pokemon/Gengar.png" id="Gengar" onclick="showConfirmation(this.id)">
        <img src="pokemon/Gyarados.png" id="Gyarados" onclick="showConfirmation(this.id)">
        <img src="pokemon/Hydreigon.png" id="Hydreigon" onclick="showConfirmation(this.id)">
        <img src="pokemon/Scizor.png" id="Scizor" onclick="showConfirmation(this.id)">
        <img src="pokemon/Lucario.png" id="Lucario" onclick="showConfirmation(this.id)">
        <img src="pokemon/Machamp.png" id="Machamp" onclick="showConfirmation(this.id)">
        <img src="pokemon/Magneton.png" id="Magneton" onclick="showConfirmation(this.id)">
        <img src="pokemon/Mamoswine.png" id="Mamoswine" onclick="showConfirmation(this.id)">
        <img src="pokemon/Marowak.png" id="Marowak" onclick="showConfirmation(this.id)">
        <img src="pokemon/Meowth.png" id="Meowth" onclick="showConfirmation(this.id)">
        <img src="pokemon/Metagross.png" id="Metagross" onclick="showConfirmation(this.id)">
        <img src="pokemon/Onix.png" id="Onix" onclick="showConfirmation(this.id)">
        <img src="pokemon/Pidgeot.png" id="Pidgeot" onclick="showConfirmation(this.id)">
        <img src="pokemon/Pikachu.png" id="Pikachu" onclick="showConfirmation(this.id)">
        <img src="pokemon/Ponyta.png" id="Ponyta" onclick="showConfirmation(this.id)">
        <img src="pokemon/Salamence.png" id="Salamence" onclick="showConfirmation(this.id)">
        <img src="pokemon/Sandslash.png" id="Sandslash" onclick="showConfirmation(this.id)">
        <img src="pokemon/Sceptile.png" id="Sceptile" onclick="showConfirmation(this.id)">
        <img src="pokemon/Snorlax.png" id="Snorlax" onclick="showConfirmation(this.id)">
        <img src="pokemon/Squirtle.png" id="Squirtle" onclick="showConfirmation(this.id)">
        <img src="pokemon/Swampert.png" id="Swampert" onclick="showConfirmation(this.id)">
        <img src="pokemon/Togekiss.png" id="Togekiss" onclick="showConfirmation(this.id)">
        <img src="pokemon/Weezing.png" id="Weezing" onclick="showConfirmation(this.id)">
        <img src="pokemon/Mewtwo.png" id="Mewtwo" onclick="showConfirmation(this.id)">
    </div>
</body>
</html>
