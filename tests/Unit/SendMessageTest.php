<?php

namespace Tests\Unit;

use Matmper\Enum\ParseMode;
use Tests\TestCase;
use Mockery;
use PHPUnit\Framework\Attributes\Test;

class SendMessageTest extends TestCase
{
    #[Test]
    public function test_that_true_is_true(): void
    {
        $fakeToken = (string) getenv('TELEGRAM_BOT_TOKEN');
        $fakeChat = (string) getenv('TELEGRAM_BOT_CHAT');
        $text = '<b>Hello World</b>';

        $responseMock = [
            'ok' => true,
            'result' => [
                'message_id' => $this->faker->randomNumber(),
                'sender_chat' => [
                    'id' => $fakeChat,
                    'title' => $title = $this->faker->company(),
                    'type' => 'channel'
                ],
                'chat' => [
                    'id' => $fakeChat,
                    'title' => $title,
                    'type' => 'channel'
                ],
                'date' => 1740421740,
                'text' => $text,
                'has_protected_content' => true,
            ]
        ];

        $mockHttpClient = Mockery::mock('overload:Matmper\Services\HttpClient');
        $mockHttpClient->shouldReceive('setopt')->andReturn(true); // @phpstan-ignore method.notFound
        $mockHttpClient->shouldReceive('execute')->andReturn(json_encode($responseMock)); // @phpstan-ignore method.notFound

        $bot = new \Matmper\TelegramBot($fakeToken, $fakeChat);

        $response = $bot->sendMessage($text, [
            'parse_mode' => ParseMode::HTML->value,
        ]);

        $this->assertTrue($response->ok);
        $this->assertEquals(json_encode($responseMock), json_encode($response));
    }
}
