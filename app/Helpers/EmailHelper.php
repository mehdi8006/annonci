<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper
{
    /**
     * Send a password reset email
     *
     * @param string $email
     * @param string $name
     * @param string $token
     * @return bool
     */
    public static function sendPasswordResetEmail($email, $name, $token)
    {
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST', 'smtp.mailtrap.io');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME', '');
            $mail->Password   = env('MAIL_PASSWORD', '');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
            $mail->Port       = env('MAIL_PORT', 2525);
            $mail->CharSet    = 'UTF-8';
            
            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@annoncia.com'), env('MAIL_FROM_NAME', 'Annoncia'));
            $mail->addAddress($email, $name);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Réinitialisation de votre mot de passe - Annoncia';
            
            $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $email], false));
            
            // Email template
            $mail->Body = self::getPasswordResetEmailTemplate($name, $resetUrl);
            $mail->AltBody = "Bonjour {$name}, Cliquez sur ce lien pour réinitialiser votre mot de passe: {$resetUrl}";
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Log error
            \Log::error("Erreur d'envoi d'email: " . $mail->ErrorInfo);
            return false;
        }
    }
    
    /**
     * Get HTML template for password reset email
     */
    private static function getPasswordResetEmailTemplate($name, $resetUrl)
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Réinitialisation de mot de passe</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    background-color: #f9f9f9;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background: #ffffff;
                }
                .header {
                    text-align: center;
                    padding: 20px 0;
                    background-color: #3b82f6;
                    color: white;
                }
                .content {
                    padding: 20px;
                }
                .button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #3b82f6;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    margin: 20px 0;
                }
                .footer {
                    text-align: center;
                    font-size: 12px;
                    color: #777;
                    padding: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Annoncia</h1>
                </div>
                <div class="content">
                    <h2>Bonjour ' . $name . ',</h2>
                    <p>Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte Annoncia.</p>
                    <p>Cliquez sur le bouton ci-dessous pour réinitialiser votre mot de passe :</p>
                    <p style="text-align: center;">
                        <a href="' . $resetUrl . '" class="button">Réinitialiser mon mot de passe</a>
                    </p>
                    <p>Si vous n\'avez pas fait cette demande, vous pouvez ignorer cet e-mail et votre mot de passe restera inchangé.</p>
                    <p>Ce lien de réinitialisation expirera dans 24 heures.</p>
                </div>
                <div class="footer">
                    <p>© ' . date('Y') . ' Annoncia. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>';
    }
    /**
 * Send an email verification email
 *
 * @param string $email
 * @param string $name
 * @param string $token
 * @return bool
 */
public static function sendVerificationEmail($email, $name, $token)
{
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = env('MAIL_HOST', 'smtp.mailtrap.io');
        $mail->SMTPAuth   = true;
        $mail->Username   = env('MAIL_USERNAME', '');
        $mail->Password   = env('MAIL_PASSWORD', '');
        $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
        $mail->Port       = env('MAIL_PORT', 2525);
        $mail->CharSet    = 'UTF-8';
        
        // Recipients
        $mail->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@annoncia.com'), env('MAIL_FROM_NAME', 'Annoncia'));
        $mail->addAddress($email, $name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Vérification de votre compte - Annoncia';
        
        $verificationUrl = url(route('email.verify', ['token' => $token, 'email' => $email], false));
        
        // Email template
        $mail->Body = self::getVerificationEmailTemplate($name, $verificationUrl);
        $mail->AltBody = "Bonjour {$name}, Merci de vous être inscrit sur Annoncia. Cliquez sur ce lien pour vérifier votre adresse email: {$verificationUrl}";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log error
        \Log::error("Erreur d'envoi d'email: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Get HTML template for verification email
 */
private static function getVerificationEmailTemplate($name, $verificationUrl)
{
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Vérification de votre compte</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height:.6;
                color: #333;
                background-color: #f9f9f9;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background: #ffffff;
            }
            .header {
                text-align: center;
                padding: 20px 0;
                background-color: #3b82f6;
                color: white;
            }
            .content {
                padding: 20px;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #3b82f6;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                margin: 20px 0;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                color: #777;
                padding: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Annoncia</h1>
            </div>
            <div class="content">
                <h2>Bonjour ' . $name . ',</h2>
                <p>Merci de vous être inscrit sur Annoncia.</p>
                <p>Pour finaliser votre inscription, veuillez cliquer sur le bouton ci-dessous afin de vérifier votre adresse e-mail :</p>
                <p style="text-align: center;">
                    <a href="' . $verificationUrl . '" class="button">Vérifier mon adresse e-mail</a>
                </p>
                <p>Si vous n\'avez pas créé de compte sur Annoncia, vous pouvez ignorer cet e-mail.</p>
                <p>Ce lien de vérification expirera dans 72 heures.</p>
            </div>
            <div class="footer">
                <p>© ' . date('Y') . ' Annoncia. Tous droits réservés.</p>
            </div>
        </div>
    </body>
    </html>';
}
}