<!DOCTYPE html>
<html>

<head>
    <title>Formulaire de Connexion</title>
    <link rel="stylesheet" type="text/css" href="../vue/style/login.css">
</head>

<body>
    <h1>Connexion</h1>
    <?php if (!empty($messageErreur)) {
        echo '<p style="color:red;">' . $messageErreur . '</p>';
        if (isset($message)) {
            echo "<p>$message</p>";
        }
    } ?>
    <form method="POST" action="../controleur/login.php">
        <label for="username">Numéro de conducteur:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Se connecter">
        <p>Changement de <a href="../controleur/changement_mdp.php">mot de passe.</a></p>
        <button id="toggle-dark-mode"></button>
    </form>
    <script src="../controleur/darkmode.js"></script>
</body>

</html>