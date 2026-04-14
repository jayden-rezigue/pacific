<?php
if (isset($_POST["submitteam"])) {
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["teamsize"])) {
        if (is_numeric($_POST["teamsize"])) {
            $name = test_input($_POST["name"]);
            $email = test_input($_POST["email"]);
            $teamsize = test_input($_POST["teamsize"]);

            session_start();
            $_SESSION["teamname"] = $name;

            require_once __DIR__ . "/dbcon.php";
            try {
                $sQuery = "INSERT INTO teams (name, email, teamsize) VALUES (:nm, :ml, :tms)";
                $oStmt = $db->prepare($sQuery);
                $oStmt->bindValue(":nm", $name);
                $oStmt->bindValue(":ml", $email);
                $oStmt->bindValue(":tms", $teamsize);

                $oStmt->execute();
            } catch(PDOException $e) { 
                $sMsg =
                "<p>
                Regelnummer: ".$e->getLine()."<br>
                Bestand: ".$e->getFile()."<br>
                Foutmelding: ".$e->getMessage()."
                </p>";
                trigger_error($sMsg); 
                die();
            }
            header("Refresh: 1, url=room_1.php");
            echo "<h2>Team successvol toegevoegd</h2>";
            exit();
        }
    } else {
        header("Refresh: 2, url=teamregistratie.php");
        echo "<h2>Graag alles invullen</h2>";
        exit(); 
    }
} else {
    header("Refresh: 2, url=teamregistratie.php");
    echo "<h2>Je bent hier niet op de juiste manier gekomen!</h2>";
    exit();
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>