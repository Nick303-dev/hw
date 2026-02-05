<?php
session_start();

// Controllo login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit();
}

// Controllo se il nome del convegno è stato passato in GET
if (!isset($_GET['nomeConvegno']) || empty($_GET['nomeConvegno'])) {
    die("Errore: nessun convegno selezionato.");
}

// Nome del file JSON
$file = $_GET['nomeConvegno'] . '.json';

// Controllo che il file esista
if (!file_exists($file)) {
    die("Errore: il convegno non esiste.");
}

// Leggo e decodifico i dati
$partecipantiData = json_decode(file_get_contents($file), true);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza Convegno: <?php echo htmlspecialchars($_GET['nomeConvegno']); ?></title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h1>Partecipanti del convegno: <?php echo htmlspecialchars($_GET['nomeConvegno']); ?></h1>

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
    <?php else : ?>
        <p>Nessun partecipante registrato per questo convegno.</p>
    <?php endif; ?>
</body>
</html>
