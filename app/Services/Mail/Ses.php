<?php

namespace App\Services\Mail;

use App\Services\Config;
use App\Services\Aws\Factory;

class Ses extends Base
{
    protected $client;

    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->client = Factory::createSes();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getSender()
    {
        return Config::get('aws_ses_sender');
    }

    /**
     * @codeCoverageIgnore
     */
    public function send($to, $subject, $text)
    {
        $this->client->sendEmail([
            'Destination' => [ // REQUIRED
                'ToAddresses' => [$to],
            ],
            'Message' => [ // REQUIRED
                'Body' => [ // REQUIRED
                    'Html' => [
                        'Data' => $text, // REQUIRED
                    ],
                    'Text' => [
                        'Data' => $text, // REQUIRED
                    ],
                ],
                'Subject' => [ // REQUIRED
                    'Data' => $subject// REQUIRED
                ],
            ],
            'Source' => $this->getSender(), // REQUIRED
        ]);
    }
}
