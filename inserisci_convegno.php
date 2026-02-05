<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inserisci_convegno</title>
</head>
<body>
    <h1>inserisci_convegno</h1>
   
        <label for="nPartecipanti">inserisci numero partecipanti:</label>
        <input type="number" id="nPartecipanti" name="nPartecipanti" onchange="addConvegno()" required><br><br>
        
    
<form action="salva_convegno.php" method="post" class="convegno-form">
    <label for="nPartecipanti">inserisci numero partecipanti:</label>
    <label> for="nomeConvegno">Nome Convegno:</label>
    <input type="text" id="nomeConvegno" name="nomeConvegno" required><br><br>
    <input type="number" id="nPartecipanti" name="nPartecipanti" onchange="addConvegno()" required><br><br>
    
    <div id="partecipantiContainer"></div>
    <input type="submit" value="Submit">
</form>

</body>
<link rel="stylesheet" href="inserisci_convegno.css">
<script src="Convegno.js"></script>
</html>
