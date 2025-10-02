<?php
session_start();
include 'connection.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_POST['new-password']) && isset($_POST['confirm-password'])) {
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];
    $email = $_POST['email'];

   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse e-mail invalide.";
        exit();
    }

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE `inscriptions` SET mot_de_passe = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            echo "<script>alert('Mot de passe mis à jour avec succès.'); window.location='index.php?page=recover';</script>";


        } else {
            echo "<script>alert('Erreur lors de la mise à jour du mot de passe: " . mysqli_error($db) . "'); window.location='index.php?page=recover';</script>";
        }
    } else {
        echo "<script>alert('Les mots de passe ne sont pas les memes.'); window.location='index.php?page=generate';</script>";

    }
}

$conn->close();

?>