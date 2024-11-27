<?php
// Démarrer la session pour gérer les erreurs ou les succès de la connexion


// Inclusion du fichier AuthController
require_once(__DIR__ . '/../../controllers/AuthController.php');
require_once(__DIR__ . '/../../models/Personnel.php'); // S'assurer que le modèle Personnel est inclus

// Initialisation du contrôleur AuthController
$personnelModel = new Personnel(); // Créer une instance de votre modèle Personnel
$authController = new AuthController($personnelModel); // Passer le modèle au contrôleur

// Vérifier si le formulaire a été soumis
$errorMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $emailOrMatricule = $_POST['email_matricule'];
    $password = $_POST['password'];

    // Appeler la méthode login du contrôleur pour traiter la connexion
    $result = $authController->login($emailOrMatricule, $password);

    // Si le résultat est une chaîne, cela signifie qu'il y a eu une erreur
    if (is_string($result)) {
        $errorMessage = $result; // Afficher l'erreur sur la page
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../app/views/auth/css/connexion.css">
</head>

<body>
    <div class="container">
        <div class="image-section">
            <img src="../app/views/auth/logo_white.png" alt="Logo" class="logo">
            <img src="../app/views/auth/login.png" alt="Connexion Image" class="image">
        </div>

        <div class="form-section">
            <h2>Connexion</h2>

            <!-- Message d'erreur -->
            <?php if (!empty($errorMessage)) : ?>
                <div class="error-message" style="color: red;"><?= htmlspecialchars($errorMessage) ?></div>
            <?php endif; ?>

            <form action="index.php?action=login" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="input-container">
                    <label for="matricule" class="form-label">Email ou Matricule</label>
                    <input type="text" id="matricule" name="matricule" class="form-control" required>
                    <div class="error-message" style="color: red; visibility: hidden;"></div>
                </div>

                <div class="input-container password-container">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="form-control" required>
                        <span id="toggle-password" class="toggle-password">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                        <div class="error-message" style="color: red; visibility: hidden;"></div>
                    </div>
                </div>

                <button id="login-button" type="submit">Se connecter</button>

                <!-- Message d'erreur PHP -->
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
                    unset($_SESSION['error_message']);
                }
                ?>
            </form>
        </div>
    </div>

    <!-- Lien vers le fichier JavaScript -->
    <script src="../app/views/auth/js/connexion.js"></script>
</body>

</html>
