<?php

declare(strict_types=1);

namespace Matmper;

use Matmper\Services\HttpClient;

class TelegramBot
{
    /**
     * @var string
     */
    private string $botToken;

    /**
     * @var string
     */
    private string $chatID;

    /**
     * @param string $botToken  123456789:ABC-DEF1234ghIkl-zyx57W2v1u123ew11
     * @param string $chatID    -1234567890
     */
    public function __construct(string $botToken, string $chatID)
    {
        $this->botToken = $botToken;
        $this->chatID = $chatID;
    }

    /**
     * Send a new message to Telegram Chat
     *
     * @param string $message
     * @param array<string,mixed> $parameters
     * @return TelegramResponse
     * @throws \Matmper\Exceptions\ParameterNotAllowedException
     * @throws \Matmper\Exceptions\TelegramBotException
     */
    public function sendMessage(string $message, array $parameters = []): TelegramResponse
    {
        $body = [
            'chat_id' => $this->chatID,
            'text' => $message,
        ];

        foreach ($parameters as $parameter => $value) {
            if (!in_array($parameter, $this->getAllowedParameters())) {
                throw new \Matmper\Exceptions\ParameterNotAllowedException($parameter);
            }

            $body[$parameter] = $value;
        }

        return $this->request('sendMessage', $body);
    }

    /**
     * Request to Telegram API
     *
     * @param string $uri
     * @param array<string,mixed> $body
     * @return TelegramResponse
     * }
     * @throws \Matmper\Exceptions\TelegramBotException
     */
    private function request(string $uri, array $body): TelegramResponse
    {
        try {
            $curl = new HttpClient("https://api.telegram.org/bot{$this->botToken}/{$uri}");

            $curl->setopt(CURLOPT_RETURNTRANSFER, true);
            $curl->setopt(CURLOPT_ENCODING, '');
            $curl->setopt(CURLOPT_MAXREDIRS, 3);
            $curl->setopt(CURLOPT_TIMEOUT, $this->env('TELEGRAM_BOT_WEBHOOK_TIMEOUT', 5));
            $curl->setopt(CURLOPT_FOLLOWLOCATION, true);
            $curl->setopt(CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            $curl->setopt(CURLOPT_POST, true);
            $curl->setopt(CURLOPT_CUSTOMREQUEST, 'POST');
            $curl->setopt(CURLOPT_POSTFIELDS, json_encode($body));
            $curl->setopt(CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

            $response = $curl->execute();
            $response = json_decode($response);
        } catch (\Throwable $th) {
            throw new \Matmper\Exceptions\TelegramBotException($th->getMessage(), $th->getCode(), $th);
        }

        return new TelegramResponse($response->ok, $response->result);
    }

    /**
     * Get allowed parameters
     *
     * @return string[]
     */
    private function getAllowedParameters(): array
    {
        return [
            'business_connection_id',
            'parse_mode',
            'message_thread_id',
            'entities',
            'link_preview_options',
            'disable_notification',
            'protect_content',
            'allow_paid_broadcast',
            'message_effect_id',
            'reply_parameters',
            'reply_markup',
        ];
    }

    /**
     * Get environment variable value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     * @throws \Matmper\Exceptions\EnvironmentNotFoundException
     */
    private function env(string $name, $default = null)
    {
        try {
            $env = !empty(getenv($name)) ? getenv($name) : null;

            if ($env) {
                return $env;
            }

            $env = !empty($_ENV[$name]) ? $_ENV[$name] : null;

            if ($env) {
                return $env;
            }

            $env = function_exists('env') ? env($name) : null; // or interface_exists()

            if ($env) {
                return $env;
            }
        } catch (\Throwable $th) {
            throw new \Matmper\Exceptions\EnvironmentNotFoundException($name, HttpClient::HTTP_NOT_FOUND, $th);
        }

        return $default;
    }
}
