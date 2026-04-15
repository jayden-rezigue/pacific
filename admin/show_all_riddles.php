<?php
require '../dbcon.php';

// Zoeken en filteren
$zoek = $_GET['zoek'] ?? '';
$filterRoom = $_GET['room'] ?? '';

$sql = "SELECT * FROM riddles WHERE 1=1";
$params = [];

if ($zoek !== '') {
    $sql .= " AND (riddle LIKE ? OR answer LIKE ? OR hint LIKE ?)";
    $params[] = "%$zoek%";
    $params[] = "%$zoek%";
    $params[] = "%$zoek%";
}

if ($filterRoom !== '') {
    $sql .= " AND roomId = ?";
    $params[] = $filterRoom;
}

$sql .= " ORDER BY roomId ASC, id ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$riddles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Alle unieke rooms ophalen voor filter
$rooms = $pdo->query("SELECT DISTINCT roomId FROM riddles ORDER BY roomId ASC")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Raadsels</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            /* background: #ffffff; */
            color: #e0e0e0;
            min-height: 100vh;
            padding: 30px 20px;
        }

        h1 {
            text-align: center;
            font-size: 2em;
            color: #000000;
            margin-bottom: 8px;
            
        }

        .subtitel {
            text-align: center;
            color: #888;
            margin-bottom: 30px;
            font-size: 0.95em;
        }

        /* ── Zoek & Filter balk ── */
        .filterbalk {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 30px;
        }

        .filterbalk input,
        .filterbalk select {
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #00cfff44;
            background: #111133;
            color: #e0e0e0;
            font-size: 0.95em;
            min-width: 200px;
        }

        .filterbalk button {
            padding: 10px 20px;
            background: #00cfff;
            color: #0a0a2e;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            font-size: 0.95em;
        }

        .filterbalk button:hover { background: #00aadd; }


        /* ── Room secties ── */
        .room-sectie {
            margin-bottom: 40px;
        }

        .room-titel {
            font-size: 1.2em;
            color: #00cfff;
            border-left: 4px solid #00cfff;
            padding-left: 12px;
            margin-bottom: 16px;
        }

        /* ── Kaarten grid ── */
        .kaarten-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        .kaart {
            background: #111133;
            border: 1px solid #00cfff22;
            border-radius: 12px;
            padding: 18px;
            transition: transform 0.2s, border-color 0.2s;
            position: relative;
        }



        .kaart .id-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #00cfff22;
            color: #00cfff;
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 0.78em;
        }

        .kaart .riddle-tekst {
            font-size: 0.95em;
            line-height: 1.5;
            color: #ddd;
            margin-bottom: 14px;
            padding-right: 40px;
        }

        .kaart .info-rij {
            display: flex;
            gap: 8px;
            align-items: flex-start;
            margin-bottom: 6px;
            font-size: 0.88em;
        }

        .kaart .info-label {
            color: #00cfff;
            font-weight: bold;
            min-width: 70px;
            flex-shrink: 0;
        }

        .kaart .info-waarde {
            color: #ccc;
        }

        .kaart .acties {
            display: flex;
            gap: 8px;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid #ffffff11;
        }

        .btn-bewerk {
            background: #ffc107;
            color: #111;
            padding: 5px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.82em;
            font-weight: bold;
        }



        .btn-bewerk:hover { background: #e0a800; }

        /* ── Geen resultaten ── */
        .geen-resultaten {
            text-align: center;
            padding: 60px 20px;
            color: #555;
            font-size: 1.1em;
        }

        /* ── Terug knop ── */
        .terug {
            display: inline-block;
            margin-bottom: 20px;
            color: #00cfff;
            text-decoration: none;
            font-size: 0.9em;
        }
        .terug:hover { text-decoration: underline; }
    </style>
</head>
<body>

<a href="add_riddle.php" class="terug">← Terug naar beheer</a>

<h1> Raadsel Overzicht</h1>
<p class="subtitel">Alle raadsels uit de database</p>


<!-- ── Zoek & Filter ── -->
<form method="GET" class="filterbalk">
    <input
        type="text"
        name="zoek"
        placeholder="🔍 Zoek op vraag, antwoord of hint..."
        value="<?= htmlspecialchars($zoek) ?>"
    >
    <select name="room">
        <option value="">Alle rooms</option>
        <?php foreach ($rooms as $r): ?>
            <option value="<?= $r ?>" <?= $filterRoom == $r ? 'selected' : '' ?>>
                Room <?= $r ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Zoeken</button>
    <?php if ($zoek !== '' || $filterRoom !== ''): ?>
    <?php endif; ?>
</form>

<!-- ── Raadsels per room ── -->
<?php if (empty($riddles)): ?>
    <div class="geen-resultaten">
         Geen raadsels gevonden<?= $zoek ? " voor \"" . htmlspecialchars($zoek) . "\"" : '' ?>.
    </div>
<?php else: ?>

    <?php
    // Groepeer per roomId
    $perRoom = [];
    foreach ($riddles as $r) {
        $perRoom[$r['roomId']][] = $r;
    }
    ?>

    <?php foreach ($perRoom as $roomId => $rRiddles): ?>
    <div class="room-sectie">
        <div class="room-titel"> Room <?= $roomId ?> <span style="color:#555; font-size:0.8em;">(<?= count($rRiddles) ?> raadsel<?= count($rRiddles) !== 1 ? 's' : '' ?>)</span></div>
        <div class="kaarten-grid">
            <?php foreach ($rRiddles as $riddle): ?>
            <div class="kaart">
                <span class="id-badge">#<?= $riddle['id'] ?></span>
                <p class="riddle-tekst"><?= htmlspecialchars($riddle['riddle']) ?></p>
                <div class="info-rij">
                    <span class="info-label"> Antwoord:</span>
                    <span class="info-waarde"><?= htmlspecialchars($riddle['answer']) ?></span>
                </div>
                <div class="info-rij">
                    <span class="info-label"> Hint:</span>
                    <span class="info-waarde"><?= htmlspecialchars($riddle['hint'] ?? '–') ?></span>
                </div>
                <div class="acties">
                    <a href="add_riddle.php?bewerk=<?= $riddle['id'] ?>" class="btn-bewerk"> Bewerk</a>

                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>

<?php endif; ?>

</body>
</html>