<?php
require '../dbcon.php';

$melding = '';

// ── Toevoegen ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actie'])) {

    if ($_POST['actie'] === 'toevoegen') {
        $stmt = $pdo->prepare("INSERT INTO riddles (riddle, antwoord, hint, moeilijkheid) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['riddle'], $_POST['antwoord'], $_POST['hint'], $_POST['moeilijkheid']]);
        $melding = "✅ Raadsel toegevoegd!";
    }

    // ── Bewerken ──
    if ($_POST['actie'] === 'bewerken') {
        $stmt = $pdo->prepare("UPDATE riddles SET riddle=?, antwoord=?, hint=?, moeilijkheid=? WHERE id=?");
        $stmt->execute([$_POST['riddle'], $_POST['antwoord'], $_POST['hint'], $_POST['moeilijkheid'], $_POST['id']]);
        $melding = "✏️ Raadsel bijgewerkt!";
    }
}

// ── Verwijderen ──
if (isset($_GET['verwijder'])) {
    $stmt = $pdo->prepare("DELETE FROM riddles WHERE id = ?");
    $stmt->execute([$_GET['verwijder']]);
    $melding = "🗑️ Raadsel verwijderd!";
}

// ── Bewerk-formulier laden ──
$bewerkRaadsel = null;
if (isset($_GET['bewerk'])) {
    $stmt = $pdo->prepare("SELECT * FROM riddles WHERE id = ?");
    $stmt->execute([$_GET['bewerk']]);
    $bewerkRaadsel = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ── Alle raadsels ophalen ──
$riddles = $pdo->query("SELECT * FROM riddles ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin – Raadsels Beheren</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 40px auto; padding: 0 20px; background: #f5f5f5; }
        h1, h2 { color: #333; }
        .melding { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        form { background: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type=text], textarea, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { height: 80px; resize: vertical; }
        button { margin-top: 15px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th { background: #007bff; color: white; padding: 12px; text-align: left; }
        td { padding: 10px 12px; border-bottom: 1px solid #eee; vertical-align: top; }
        tr:hover { background: #f9f9f9; }
        .btn-bewerk { background: #ffc107; color: #333; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.85em; }
        .btn-verwijder { background: #dc3545; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.85em; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 0.8em; color: white; }
        .makkelijk { background: #28a745; }
        .gemiddeld  { background: #ffc107; color: #333; }
        .moeilijk   { background: #dc3545; }
    </style>
</head>
<body>

<h1>🧩 Raadsels Beheren</h1>

<?php if ($melding): ?>
    <div class="melding"><?= htmlspecialchars($melding) ?></div>
<?php endif; ?>


<!-- ── FORMULIER: Toevoegen of Bewerken ── -->
<h2><?= $bewerkRaadsel ? '✏️ Raadsel bewerken' : '➕ Nieuw raadsel toevoegen' ?></h2>
<form method="POST">
    <input type="hidden" name="actie" value="<?= $bewerkRaadsel ? 'bewerken' : 'toevoegen' ?>">
    <?php if ($bewerkRaadsel): ?>
        <input type="hidden" name="id" value="<?= $bewerkRaadsel['id'] ?>">
    <?php endif; ?>

    <label>Vraag</label>
    <textarea name="vraag" required><?= htmlspecialchars($bewerkRaadsel['vraag'] ?? '') ?></textarea>

    <label>Antwoord</label>
    <input type="text" name="antwoord" required value="<?= htmlspecialchars($bewerkRaadsel['antwoord'] ?? '') ?>">

    <label>Hint (optioneel)</label>
    <input type="text" name="hint" value="<?= htmlspecialchars($bewerkRaadsel['hint'] ?? '') ?>">

    <label>Moeilijkheid</label>
    <select name="moeilijkheid">
        <?php foreach (['makkelijk', 'gemiddeld', 'moeilijk'] as $niveau): ?>
            <option value="<?= $niveau ?>" <?= ($bewerkRaadsel['moeilijkheid'] ?? '') === $niveau ? 'selected' : '' ?>>
                <?= ucfirst($niveau) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit"><?= $bewerkRaadsel ? '💾 Opslaan' : '➕ Toevoegen' ?></button>
    <?php if ($bewerkRaadsel): ?>
        <a href="admin.php" style="margin-left:10px; color:#666;">Annuleren</a>
    <?php endif; ?>
</form>


<!-- ── TABEL: Alle raadsels ── -->
<h2>📋 Alle riddles (<?= count($riddles) ?>)</h2>
<table>
    <tr>
        <th>#</th>
        <th>Vraag</th>
        <th>Antwoord</th>
        <th>Hint</th>
        <th>Niveau</th>
        <th>Acties</th>
    </tr>
<?php foreach ($riddles as $r): ?>
<tr>
    <td><?= $r['id'] ?></td>
    <td><?= htmlspecialchars($r['riddle']) ?></td>      <!-- was: vraag -->
    <td><?= htmlspecialchars($r['answer']) ?></td>      <!-- was: antwoord -->
    <td><?= htmlspecialchars($r['hint'] ?? '–') ?></td>
    <td><?= $r['roomId'] ?></td>                        <!-- bonus: roomId tonen -->
    <td>
        <a href="?bewerk=<?= $r['id'] ?>" class="btn-bewerk">✏️ Bewerk</a>
        <a href="?verwijder=<?= $r['id'] ?>" class="btn-verwijder"
           onclick="return confirm('Zeker weten?')">🗑️ Verwijder</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>