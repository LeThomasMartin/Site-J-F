<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// sendmail.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Méthode non autorisée.";
    exit;
}

// Récupère et nettoie les champs
$name    = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
$email   = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : '';
$message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';

if (empty($name) || empty($email) || empty($message)) {
    echo "Merci de remplir tous les champs.";
    exit;
}

// Paramètres SMTP (Microsoft 365)
$smtpHost = 'smtp.office365.com';
$smtpPort = 587;
$smtpUser = 'Soumission@escaliermonteaubois.ca';
$smtpPass = 'Chasseorignal#1'; // <-- remplace par le mot de passe réel

$mail = new PHPMailer(true);

try {
    // Pour débogage (décommente pendant le test)
    // $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
    // pour le debug SMTP (affiche les échanges serveur/client)
$mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
$mail->Debugoutput = 'html';
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUser;
    $mail->Password   = $smtpPass;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // tls
    $mail->Port       = $smtpPort;

    // Expéditeur (doit être l'adresse authentifiée)
    $mail->setFrom($smtpUser, 'Escalier Monte au Bois');

    // Répondre à l'émetteur du formulaire
    $mail->addReplyTo($email, $name);

    // Destinataire (la boîte de ton oncle)
    $mail->addAddress($smtpUser);

    // Contenu
    $mail->isHTML(true);
    $mail->Subject = "Nouveau message depuis le site — $name";
    $mail->Body    = "<p><strong>Nom :</strong> " . htmlentities($name) . "</p>"
                   . "<p><strong>Email :</strong> " . htmlentities($email) . "</p>"
                   . "<p><strong>Message :</strong><br>" . nl2br(htmlentities($message)) . "</p>";
    $mail->AltBody = "Nom: $name\nEmail: $email\n\nMessage:\n$message";

    $mail->send();

    // Réponse simple (tu peux rediriger vers une page de remerciement)
    echo "Message envoyé avec succès !";
} catch (Exception $e) {
    // En cas d'erreur, afficher le message pour débogage
    http_response_code(500);
    echo "Erreur lors de l'envoi : " . $mail->ErrorInfo;
}
