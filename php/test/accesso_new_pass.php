<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Reimposta Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Icone e stile -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="Css/accedi.css">
    <link rel="icon" type="image/x-icon" href="icone/logo_default.png">
</head>
<body>
    <div class="container">
        <h1><i class="fa-solid fa-key"></i> Reimposta la tua password</h1>

        <form action="cambia_password.php" method="post">
            <!-- Token ricevuto via URL -->
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">

            <!-- Nuova password -->
            <div class="form-group">
                <input type="password" name="password" required placeholder="Nuova password">
            </div>

            <!-- Conferma nuova password -->
            <div class="form-group">
                <input type="password" name="confirm_password" required placeholder="Conferma password">
            </div>

            <button type="submit">Cambia Password</button>
        </form>

        <div class="back-link">
            <a href="accedi.html"><i class="fa-solid fa-arrow-left"></i> Torna al login</a>
        </div>
    </div>

    <script src="Js/accedi.js"></script>
</body>
</html>
