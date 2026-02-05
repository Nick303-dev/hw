<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit();
}
$file = $_POST['nomeConvegno'].'.json';
$i=0;
$partecipantiData = [];

foreach ($_POST['partecipanti'] as $partecipante) {
$i++;
    $partecipantiData[] = [
        'nome' => $partecipante['nome'],
        'cognome' => $partecipante['cognome'],
        'email' => $partecipante['email'],
        'cf' => $partecipante['cf']
    ];
    file_put_contents($file, json_encode($partecipantiData, JSON_PRETTY_PRINT));

    
}
header('Location: visualizza_convegno.php');
?>