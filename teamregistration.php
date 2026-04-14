<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Registratie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="homebody">

    <div class="form-container">
        <h2 class="hometext">Team Registratie</h2>
        <form action="submit_team.php" method="post">
            <table class="question_table">
                <tr>
                    <td><label for="teamname">Team naam:</label></td>
                    <td><input class="input" type="text" name="name" id="teamname" required></td>
                </tr>
                <tr>
                    <td><label for="email">E-mail:</label></td>
                    <td><input class="input" type="email" name="email" id="email" required></td>
                </tr>
                <tr>
                    <td><label for="teamsize">Aantal Spelers:</label></td>
                    <td><input class="input" type="number" name="teamsize" id="teamsize" required></td>
                </tr>
                <tr>
                    <td><input class="button" type="submit" value="Submit" name="submitteam"></td>
                    <td><input class="button" type="reset" value="Reset"></td>
                </tr>
            </table>
        </form>
    </div>

</body>
</html>