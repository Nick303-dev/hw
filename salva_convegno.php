<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit();
}

if (!isset($_POST['nomeConvegno']) || empty($_POST['nomeConvegno'])) {
    die("Errore: nessun convegno selezionato.");
}

try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=convegni;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->beginTransaction(); // 🔒 sicurezza transazione

    $nomeConvegno = $_POST['nomeConvegno'];

    // 1️⃣ Recupero ID del convegno
    $stmt = $conn->prepare("SELECT id FROM convegni WHERE nome = :nome");
    $stmt->bindParam(':nome', $nomeConvegno, PDO::PARAM_STR);
    $stmt->execute();
    $convegno = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$convegno) {
        die("Convegno non trovato.");
    }

    $convegno_id = $convegno['id'];

    // 2️⃣ Prepariamo le query
    $stmtInsertPartecipante = $conn->prepare("
        INSERT INTO partecipanti (nome, cognome, email, cf)
        VALUES (:nome, :cognome, :email, :cf)
    ");

    $stmtCollega = $conn->prepare("
        INSERT INTO partecipano (convegno_id, partecipante_id)
        VALUES (:convegno_id, :partecipante_id)
    ");

    // 3️⃣ Inserimento partecipanti
    foreach ($_POST['partecipanti'] as $partecipante) {

        $stmtInsertPartecipante->execute([
            ':nome' => $partecipante['nome'],
            ':cognome' => $partecipante['cognome'],
            ':email' => $partecipante['email'],
            ':cf' => $partecipante['cf']
        ]);

        // Recupero ID appena inserito
        $partecipante_id = $conn->lastInsertId();

        // Collegamento nella tabella ponte
        $stmtCollega->execute([
            ':convegno_id' => $convegno_id,
            ':partecipante_id' => $partecipante_id
        ]);
    }

    $conn->commit(); // ✅ conferma

    header('Location: visualizza_convegno.php');
    exit();

} catch (PDOException $e) {
    $conn->rollBack(); // ❌ annulla tutto in caso di errore
    die("Errore: " . $e->getMessage());
}
?>