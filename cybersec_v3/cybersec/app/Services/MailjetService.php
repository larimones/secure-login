<?php

namespace App\Services;

use App\Interfaces\Services\IMailjetService;
use Exception;
use Mailjet\Client;
use Mailjet\Resources;

class MailjetService implements IMailjetService
{
    private Client $mailJetClient;

    public function __construct()
    {
        $this->mailJetClient = new Client(env(key: "MAILJET_PUBLICKEY",), env("MAILJET_SECRETKEY", ), true, ['version' => 'v3.1']);
    }

    public function send($email, $name, $subject){
        $response = $this->mailJetClient->post(Resources::$Email, ['body' => $this->mountEmailBody($email, $name, $subject)]);
// dd($response);
        if (!$response->success()){
            throw new Exception("Não foi possível encaminhar o e-mail nesse momento. Por favor tente mais tarde.");
        }
    }

    private function mountEmailBody($email, $name, $subject)
    {
        return [
            'Messages' => [
                [
                    'From' => [
                        'Email' => env("MAILJET_SENDEREMAIL"),
                        'Name' => env("APP_NAME")
                    ],
                    'To' => [
                        [
                            'Email' => $email,
                            "Name" => $name
                        ]
                    ],
                    'Subject' => (string) $subject,
                    'HTMLPart' => 'this is your verification code. Please enter it in the app.'
                ]
            ]
        ];
    }
}