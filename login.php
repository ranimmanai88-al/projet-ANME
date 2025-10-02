<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $mot_de_passe = md5($_POST['mot_de_passe']);
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaSecret = '6LeEQr0qAAAAAGhnehGiKwYneTRKBDIAICjaBESn';
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaData = [
        'secret' => $recaptchaSecret,
        'response' => $recaptchaResponse
    ];

    $recaptchaOptions = [
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($recaptchaData)
        ]
    ];

    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaVerify = file_get_contents($recaptchaUrl, false, $recaptchaContext);
    $recaptchaResponseKeys = json_decode($recaptchaVerify, true);

    if (isset($recaptchaResponseKeys["success"]) && $recaptchaResponseKeys["success"] == true) {
        $sql = "SELECT * FROM inscriptions WHERE email = '$email' and mot_de_passe='".$mot_de_passe."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
          
            header("Location: index.php?page=demande"); 
        } else {
            echo "Aucun utilisateur trouvé avec cet email.<br>";
            echo "<script>alert('Aucun compte trouvé avec cet email d\'utilisateur.'); window.location='index.php?page=login';</script>";
        }
    } else {
        echo "reCAPTCHA invalide.<br>";
        echo "<script>alert('Vérification reCAPTCHA échouée. Veuillez réessayer.'); window.location='index.php?page=login';</script>";
    }
} else {
    echo "Accès non autorisé.<br>";
    echo "<script>alert('Accès non autorisé.'); window.location='index.php?page=login';</script>";
}

mysqli_close($conn);
?>