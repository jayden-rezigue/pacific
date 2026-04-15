<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $rating = (int)$_POST['rating'];
    $comment = htmlspecialchars($_POST['comment']);
    $date = date('Y-m-d H:i:s');
    
    // Opslaan naar database toevoegen
    $success = true;
    
    if ($success) {
        echo "<p style='color: green;'>Review geplaatst!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pacifico | Plaats een review</title>
</head>
<body>
    <h1>Review je ervaring!</h1>
    
    <form method="POST">
        <label>Naam:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Hoe beoordeelt u Kamer 1?:</label><br>
        <select name="rating" required>
            <option value="">Select...</option>
            <option value="1">⭐ 1 Star</option>
            <option value="2">⭐⭐ 2 Stars</option>
            <option value="3">⭐⭐⭐ 3 Stars</option>
            <option value="4">⭐⭐⭐⭐ 4 Stars</option>
            <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
        </select><br>

        <label>Hoe beoordeelt u Kamer 2?:</label><br>
        <select name="rating" required>
            <option value="">Select...</option>
            <option value="1">⭐ 1 Star</option>
            <option value="2">⭐⭐ 2 Stars</option>
            <option value="3">⭐⭐⭐ 3 Stars</option>
            <option value="4">⭐⭐⭐⭐ 4 Stars</option>
            <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
        </select><br>

        <label>Hoe beoordeelt u Kamer 3?:</label><br>
        <select name="rating" required>
            <option value="">Select...</option>
            <option value="1">⭐ 1 Star</option>
            <option value="2">⭐⭐ 2 Stars</option>
            <option value="3">⭐⭐⭐ 3 Stars</option>
            <option value="4">⭐⭐⭐⭐ 4 Stars</option>
            <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
        </select><br>

        <label>Hoe beoordeelt u de tijdsduur van Pacifico?:</label><br>
        <select name="rating" required>
            <option value="">Select...</option>
            <option value="1">⭐ 1 Star</option>
            <option value="2">⭐⭐ 2 Stars</option>
            <option value="3">⭐⭐⭐ 3 Stars</option>
            <option value="4">⭐⭐⭐⭐ 4 Stars</option>
            <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
        </select><br>

        <label>Hoe beoordeelt u de thema geassocieerd met Pacifico?:</label><br>
        <select name="rating" required>
            <option value="">Select...</option>
            <option value="1">⭐ 1 Star</option>
            <option value="2">⭐⭐ 2 Stars</option>
            <option value="3">⭐⭐⭐ 3 Stars</option>
            <option value="4">⭐⭐⭐⭐ 4 Stars</option>
            <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
        </select><br>

        <label>Hoe beoordeelt u de kwaliteit van Pacifico?:</label><br>
        <select name="rating" required>
            <option value="">Select...</option>
            <option value="1">⭐ 1 Star</option>
            <option value="2">⭐⭐ 2 Stars</option>
            <option value="3">⭐⭐⭐ 3 Stars</option>
            <option value="4">⭐⭐⭐⭐ 4 Stars</option>
            <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
        </select><br><br>

        <label>Hoe beoordeelt u het puzzelsysteem van Pacifico?:</label><br>
        <select name="rating" required>
            <option value="">Select...</option>
            <option value="1">⭐ 1 Star</option>
            <option value="2">⭐⭐ 2 Stars</option>
            <option value="3">⭐⭐⭐ 3 Stars</option>
            <option value="4">⭐⭐⭐⭐ 4 Stars</option>
            <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
        </select><br><br>
        
        <label>Algehele waardering:</label><br>
        <select name="rating" required>
            <option value="">Select...</option>
            <option value="1">⭐ 1 Star</option>
            <option value="2">⭐⭐ 2 Stars</option>
            <option value="3">⭐⭐⭐ 3 Stars</option>
            <option value="4">⭐⭐⭐⭐ 4 Stars</option>
            <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
        </select><br><br>

        <label>Reactie:</label><br>
        <textarea name="comment" rows="4" cols="50" required></textarea><br><br>
        
        <button type="submit">Plaats Review</button>
    </form>
</body>
</html>