<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    

    
    $users =json_decode(file_get_contents('utenti.json'), true);
    foreach ($users as $user) {
        if ($user['nome'] === $username && $user['password'] === $password) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header('Location: inserisci_convegno.php');
            exit();
        }
    }else {
        $error = 'Invalid username or password.';
    }
}

?>