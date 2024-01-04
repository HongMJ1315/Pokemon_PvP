<?php
    require_once("config.php");
    session_start();
    $userID = $_SESSION["id"];
    $roomID = $_SESSION["roomID"];
    $pokemon = isset($_SESSION["pokemon"])?$_SESSION["pokemon"]:null;
    $operator = $_GET["operator"];
    $value = isset($_GET["value"])?$_GET["value"]:null;
    $userID2 = isset($_GET["userID2"])?$_GET["userID2"]:null;
    if($operator == "GetPlayerPokemon"){
        getPlayerPokemon($db, $roomID, $userID);
    }
    elseif($operator == "SetTurn"){
        setTurn($db, $roomID, $value);
    }
    elseif($operator == "GetTurn"){
        getTurn($db, $roomID);
    }
    elseif($operator == "GetDamageInfo"){
        getDamageInfo($db, $roomID);
    }
    elseif($operator == "GetPlayerHP"){
        getPlayerHP($db, $roomID);
    }
    elseif($operator == "SetPlayerHP"){
        setPlayerHP($db, $roomID, $userID2, $value);
    }
    

/*
room(roomID, player1ID, player2ID,
    turn, effect, skills, damage, statu)
player(playerID, playerHp, playerPokemon, playerStatus)
*/  
    function setPlayerHP($db, $roomID, $userID, $value){
        $sql = 
        "UPDATE player
        JOIN room ON player.playerID = room.player1ID OR player.playerID = room.player2ID
        SET player.playerHp = :playerHp
        WHERE room.roomID = :roomID AND player.playerID = :userID;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':playerHp', $value);
        $stmt->bindParam(':roomID', $roomID);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
    }
    function getPlayerHP($db, $roomID){
        $sql = 
        "SELECT 
            player1.playerHp AS player1Hp,
            player2.playerHp AS player2Hp
        FROM room
        JOIN player AS player1 ON room.player1ID = player1.playerID
        JOIN player AS player2 ON room.player2ID = player2.playerID
        WHERE room.roomID = :roomID;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':roomID', $roomID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $player1Hp = $row["player1Hp"];
        $player2Hp = $row["player2Hp"];
        // to JSON
        $result = [
            "player1Hp" => $player1Hp,
            "player2Hp" => $player2Hp
        ];
        echo json_encode($result);
    }
    function getDamageInfo($db, $roomID){
        $sql = "SELECT effect, skills, damage FROM room WHERE roomID = :roomID;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':roomID', $roomID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $damage = $row["damage"];
        $skill = $row["skills"];
        $effect = $row["effect"];
        // to JSON
        $result = [
            "damage" => $damage,
            "skill" => $skill,
            "effect" => $effect
        ];
        echo json_encode($result);
    }
    function getTurn($db, $roomID){
        $sql = "SELECT turn FROM room WHERE roomID = :roomID;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':roomID', $roomID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $turn = $row["turn"];
        // to JSON
        $result = [
            "turn" => $turn
        ];
        echo json_encode($result);
    }
    function setTurn($db, $roomID, $value){
        $sql = "UPDATE room SET turn = :turn WHERE roomID = :roomID;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':turn', $value);
        $stmt->bindParam(':roomID', $roomID);
        $stmt->execute();
    }
    function getPlayerPokemon($db, $roomID, $userID){
        $sql = 
        "SELECT 
            player1.playerPokemon AS player1Pokemon,
            player2.playerPokemon AS player2Pokemon,
            player1.playerID AS player1ID,
            player2.playerID AS player2ID
        FROM room
        JOIN player AS player1 ON room.player1ID = player1.playerID
        JOIN player AS player2 ON room.player2ID = player2.playerID
        WHERE room.roomID = :roomID;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':roomID', $roomID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $player1PokemonID = $row["player1Pokemon"];
        $player2PokemonID = $row["player2Pokemon"];
        $player1ID = $row["player1ID"];
        $player2ID = $row["player2ID"];
        // to JSON
        $result = [
            "player1PokemonID" => $player1PokemonID,
            "player2PokemonID" => $player2PokemonID
        ];
        if($userID == $player1ID)
            $_SESSION["pokemon"] = $player1PokemonID;
        else if($userID == $player2ID)
            $_SESSION["pokemon"] = $player2PokemonID;
        echo json_encode($result);
    }


?>