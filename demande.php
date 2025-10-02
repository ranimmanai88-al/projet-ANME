<?php
ini_set('display_errors', 0);
error_reporting(0);

session_start();

include 'connection.php';

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = [
        'nom_commercial', 'gouvernorat', 'email', 'num_telephone', 'num_telecopieur',
        'identifiant_unique', 'adresse_siege', 'delegation', 'capital_social',
        'identifiant_fiscal', 'responsable_nom', 'responsable_prenom',
        'responsable_nationalite', 'responsable_date_naissance', 'responsable_lieu_naissance',
        'responsable_cin', 'responsable_email'
    ];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            die("Erreur : Le champ '$field' est manquant dans le formulaire.");
        }
    }

    $nom_commercial = $_POST['nom_commercial'];
    $gouvernorat = $_POST['gouvernorat'];
    $email = $_POST['email'];
    $num_telephone = $_POST['num_telephone'];
    $num_telecopieur = $_POST['num_telecopieur'];
    $identifiant_unique = $_POST['identifiant_unique'];
    $adresse_siege = $_POST['adresse_siege'];
    $delegation = $_POST['delegation'];
    $capital_social = $_POST['capital_social'];
    $identifiant_fiscal = $_POST['identifiant_fiscal'];
    $responsable_nom = $_POST['responsable_nom'];
    $responsable_prenom = $_POST['responsable_prenom'];
    $responsable_nationalite = $_POST['responsable_nationalite'];
    $responsable_date_naissance = $_POST['responsable_date_naissance'];
    $responsable_lieu_naissance = $_POST['responsable_lieu_naissance'];
    $responsable_cin = $_POST['responsable_cin'];
    $responsable_email = $_POST['responsable_email'];

    $conn = mysqli_connect('localhost', 'root', '', 'stage');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $check_sql = "SELECT * FROM demande WHERE identifiant_unique = '$identifiant_unique'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Demande existe déjà, veuillez saisir une autre demande.'); window.location='index.php?page=login';</script>";
    } else {
        $sql = "INSERT INTO demande (
            nom_commercial, gouvernorat, email, num_telephone, num_telecopieur, identifiant_unique,
            adresse_siege, delegation, capital_social, identifiant_fiscal, responsable_nom, responsable_prenom,
            responsable_nationalite, responsable_date_naissance, responsable_lieu_naissance,
            responsable_cin, responsable_email
        ) VALUES (
            '$nom_commercial', '$gouvernorat', '$email', '$num_telephone', '$num_telecopieur', '$identifiant_unique',
            '$adresse_siege', '$delegation', '$capital_social', '$identifiant_fiscal', '$responsable_nom', '$responsable_prenom',
            '$responsable_nationalite', '$responsable_date_naissance', '$responsable_lieu_naissance',
            '$responsable_cin', '$responsable_email'
        )";

        if (mysqli_query($conn, $sql)) {
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);

            $pdf->Cell(0, 10, 'PROSOL - DEMANDE D\'ELIGIBILITE', 0, 1, 'C');
            $pdf->Ln(10);

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, 'Informations concernant l\'entreprise :', 0, 1);
            $pdf->SetFont('Arial', '', 12);

            $pdf->Cell(0, 10, "Nom commercial : $nom_commercial", 0, 1);
            $pdf->Cell(0, 10, "Gouvernorat : $gouvernorat", 0, 1);
            $pdf->Cell(0, 10, "Email : $email", 0, 1);
            $pdf->Cell(0, 10, "Numéro de téléphone : $num_telephone", 0, 1);
            $pdf->Cell(0, 10, "Numéro de télécopieur : $num_telecopieur", 0, 1);
            $pdf->Cell(0, 10, "Identifiant unique : $identifiant_unique", 0, 1);
            $pdf->Cell(0, 10, "Adresse du siège social : $adresse_siege", 0, 1);
            $pdf->Cell(0, 10, "Délégation : $delegation", 0, 1);
            $pdf->Cell(0, 10, "Valeur du capital social : $capital_social", 0, 1);
            $pdf->Cell(0, 10, "Identifiant fiscal : $identifiant_fiscal", 0, 1);
            $pdf->Ln(10);

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, 'Informations concernant le premier responsable de l\'entreprise :', 0, 1);
            $pdf->SetFont('Arial', '', 12);

            $pdf->Cell(0, 10, "Nom : $responsable_nom", 0, 1);
            $pdf->Cell(0, 10, "Prénom : $responsable_prenom", 0, 1);
            $pdf->Cell(0, 10, "Nationalité : $responsable_nationalite", 0, 1);
            $pdf->Cell(0, 10, "Date de naissance : $responsable_date_naissance", 0, 1);
            $pdf->Cell(0, 10, "Lieu de naissance : $responsable_lieu_naissance", 0, 1);
            $pdf->Cell(0, 10, "Numéro CIN : $responsable_cin", 0, 1);
            $pdf->Cell(0, 10, "Email : $responsable_email", 0, 1);

            $pdf_file = 'demande_eligibilite.pdf';
            $pdf->Output($pdf_file, 'F'); 

            echo "<script>
                alert('Demande ajoutée avec succès.');
                window.location.href='$pdf_file'; 
            </script>";

            exit();
        } else {
            echo "<script>alert('Erreur : " . mysqli_error($conn) . "');</script>";
        }
    }

    mysqli_close($conn);
}
?>
