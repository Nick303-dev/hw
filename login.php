<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    
        $conn = new PDO("mysql:host=127.0.0.1;dbname=convegni;charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query con controllo diretto di username e password
        $stmt = $conn->prepare("
            SELECT * FROM utenti 
            WHERE nome = :nome AND password = :password
        ");

        $stmt->bindParam(':nome', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['nome'];

            header('Location: inserisci_convegno.php');
            exit();
        } else {
            $error = "Username o password errati.";
        }

    
}
?>