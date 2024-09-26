<?php
namespace Plugins\EmailSender;

require 'Plugins/EmailSender/PHPMailer/src/Exception.php';
require 'Plugins/EmailSender/PHPMailer/src/PHPMailer.php';
require 'Plugins/EmailSender/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Engine\Config;

class EmailSender
{
    private $mailer;
    private $config;

    public function __construct()
    {
        $config = new Config();
        $this->config = $config->get('smtp');
        $this->mailer = new PHPMailer(true);
        $this->setupMailer();
    }

    private function setupMailer()
    {
        try {
            //Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host = $this->config['hostname'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $this->config['username'];
            $this->mailer->Password = $this->config['password'];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = $this->config['port'];

            // Set the encoding to UTF-8
            $this->mailer->CharSet = 'UTF-8';

            //Recipients
            $this->mailer->setFrom($this->config['from'], 'Breaking Brains');
        } catch (Exception $e) {
            error_log("Mailer Error: " . $this->mailer->ErrorInfo);
        }
    }

    function renderEmailTemplate($template, $data)
    {
        $output = file_get_contents($template);
    
        // Replace placeholders with actual data
        foreach ($data as $key => $value) {
            $output = str_replace('{{' . $key . '}}', $value, $output);
        }
    
        return $output;
    }

    public function sendEmail($to, $subject, $body)
    {
        try {
            //Recipients
            $this->mailer->addAddress($to);

            //Content
            $this->mailer->isHTML(true);                                  
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
            $this->mailer->AltBody = strip_tags($body);

            $this->mailer->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}
