<?php
session_start();
include 'connection.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "stage";

    $db = new mysqli($host, $user, $password, $database);

    if ($db->connect_error) {
        echo "<script>alert('Erreur de connexion : " . $db->connect_error . "');</script>";
        die();
    }

    $type_prestataire = $_POST['type_prestataire'] ?? '';
    $role = $_POST['role'] ?? '';
    $sexe = $_POST['sexe'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $num_telephone = $_POST['num_telephone'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $lieu_naissance = $_POST['lieu_naissance'] ?? '';
    $fonction = $_POST['fonction'] ?? '';
    $nationalite = $_POST['nationalite'] ?? '';
    $identifiant_unique = $_POST['identifiant_unique'] ?? '';
    $identifiant_fiscal = $_POST['identifiant_fiscal'] ?? '';
    $date_creation = $_POST['date_creation'] ?? '';
    $raison_sociale = $_POST['raison_sociale'] ?? '';
    $capital_social = $_POST['capital_social'] ?? '';
    $adresse_siege = $_POST['adresse_siege'] ?? '';
    $gouvernorat = $_POST['gouvernorat'] ?? '';
    $delegation = $_POST['delegation'] ?? '';
    $telecopie = $_POST['telecopie'] ?? '';
    $email_societe = $_POST['email_societe'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $engagement = isset($_POST['engagement']) ? 1 : 0;
    $signature = isset($_FILES['signature']) ? $_FILES['signature'] : null;
    $rne = isset($_FILES['rne']) ? $_FILES['rne'] : null;

    $mot_de_passe_hash =md5($mot_de_passe);

    $target_dir = "uploads/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $signature_target = $_POST['signature'];//'';
    $rne_target = '';
    $carte_identite_fiscale_target = '';

    if ($rne && $rne['error'] === UPLOAD_ERR_OK) {
        $rne_target = $target_dir . basename($rne["name"]);
        if (!move_uploaded_file($rne["tmp_name"], $rne_target)) {
            echo "<script>alert('Erreur lors du téléchargement du fichier RNE.');</script>";
        }
    }

    if (isset($_FILES['carte_identite_fiscale']) && $_FILES['carte_identite_fiscale']['error'] === UPLOAD_ERR_OK) {
        $carte_identite_fiscale_target = $target_dir . basename($_FILES["carte_identite_fiscale"]["name"]);
        if (!move_uploaded_file($_FILES["carte_identite_fiscale"]["tmp_name"], $carte_identite_fiscale_target)) {
            echo "<script>alert('Erreur lors du téléchargement de la carte d\'identité fiscale.');</script>";
        }
    }

   

    $check_query = "SELECT * FROM inscriptions WHERE identifiant_unique='$identifiant_unique'";
    $result = $db->query($check_query);

    if ($result->num_rows > 0) {
        echo "<script>alert('Ce client existe déjà.');window.location.href='login.php';</script>";
    } else {
        $sql = "INSERT INTO inscriptions 
        (type_prestataire, role, sexe, prenom, nom, email, num_telephone, date_naissance, lieu_naissance, fonction, nationalite, identifiant_unique, identifiant_fiscal, date_creation, rne, carte_identite_fiscale, raison_sociale, capital_social, adresse_siege, gouvernorat, delegation, telecopie, email_societe, engagement, signature, mot_de_passe) 
        VALUES 
        ('$type_prestataire', '$role', '$sexe', '$prenom', '$nom', '$email', '$num_telephone', '$date_naissance', '$lieu_naissance', '$fonction', '$nationalite', '$identifiant_unique', '$identifiant_fiscal', '$date_creation', '$rne_target', '$carte_identite_fiscale_target', '$raison_sociale', '$capital_social', '$adresse_siege', '$gouvernorat', '$delegation', '$telecopie', '$email_societe', '$engagement', '$signature_target', '$mot_de_passe_hash')";

        if (mysqli_query($db, $sql)) {
            echo "<script>alert('Le compte client a été ajouté avec succès.'); window.location='index.php?page=login';</script>";


        } else {
            echo "<script>alert('Erreur : " . mysqli_error($db) . "');</script>";
        }
    }

    mysqli_close($db);

exit();


    
}
?>