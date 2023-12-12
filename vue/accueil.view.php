<!DOCTYPE html>
<html>

<head>
    <title>Page d'accueil</title>
    <link rel="stylesheet" type="text/css" href="../vue/style/affiche.css">
</head>

<body>
    <h1>Bienvenue sur la page d'accueil</h1>
    <p>Informations de l'utilisateur :</p>
    <table class="table">
        <ul>
            <li>Nom :
                <?php echo $informationsUtilisateur['nom']; ?>
            </li>
            <li>Prénom :
                <?php echo $informationsUtilisateur['prenom']; ?>
            </li>
            <li>Numéro de permis :
                <?php echo $informationsUtilisateur['num_permis']; ?>
            </li>
            <li>Date du permis :
                <?php $date = date_create($informationsUtilisateur['date_permis']);
                echo date_format($date, 'd/m/Y'); ?>
            </li>
        </ul>
    </table>
    <br>
    <a href="./formulaire.php">Liste infractions</a>
    <a href="./logout.php">Déconnexion</a>
    <button id="toggle-dark-mode"></button>
</body>
<script src="../controleur/darkmode.js"></script>

</html>