<?php
session_start();

// Controllo login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit();
}

try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=convegni;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recupero tutti i convegni per la select
    $stmt = $conn->prepare("SELECT id, nome FROM convegni");
    $stmt->execute();
    $convegni = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $partecipantiData = [];

    // Se è stato selezionato un convegno
    if (isset($_GET['convegno_id']) && !empty($_GET['convegno_id'])) {

        $convegno_id = $_GET['convegno_id'];

        // Recupero partecipanti del convegno selezionato
        $stmt = $conn->prepare("
            SELECT p.nome, p.cognome, p.email, p.cf
            FROM partecipanti p
            INNER JOIN partecipano pa ON p.id = pa.partecipante_id
            WHERE pa.convegno_id = :convegno_id
        ");

        $stmt->bindParam(':convegno_id', $convegno_id, PDO::PARAM_INT);
        $stmt->execute();
        $partecipantiData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Visualizza Convegni</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        form { text-align: center; margin-top: 30px; }
    </style>
</head>
<body>

<h1 style="text-align:center;">Seleziona un Convegno</h1>

<form method="GET">
    <select name="convegno_id" required>
        <option value="">-- Seleziona --</option>
        <?php foreach ($convegni as $c): ?>
            <option value="<?php echo $c['id']; ?>"
                <?php if (isset($_GET['convegno_id']) && $_GET['convegno_id'] == $c['id']) echo "selected"; ?>>
                <?php echo htmlspecialchars($c['nome']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Visualizza</button>
</form>

<?php if (!empty($partecipantiData)) : ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th>CF</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($partecipantiData as $index => $p) : ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($p['nome']); ?></td>
                    <td><?php echo htmlspecialchars($p['cognome']); ?></td>
                    <td><?php echo htmlspecialchars($p['email']); ?></td>
                    <td><?php echo htmlspecialchars($p['cf']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (isset($_GET['convegno_id'])) : ?>
    <p style="text-align:center;">Nessun partecipante registrato per questo convegno.</p>
<?php endif; ?>

</body>
</html>