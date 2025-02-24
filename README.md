# Telegram PHP - SDK Bot

## Requirements
    - PHP `^8.0`
    - cURL Extension

## Installation

Install the package via Composer:

```bash
$ composer require matmper/php-telegram-sdk-bot
```

## Usage

This package allows you to easily interact with Telegram's Bot API.
You can send messages, receive updates, and handle bot interactions with a few lines of code.

Create Telegram BOT: [From BotFather to Hello World](https://core.telegram.org/bots/tutorial)

### Sending a Message

Telegram Doc: [sendMessage](https://core.telegram.org/bots/api#sendmessage)

```php
require 'vendor/autoload.php';

use Matmper\TelegramBot;
use Matmper\Enum\ParseMode;

$botToken = '12345678:a1b2c3d4f5g6';
$chatID = '-100000000';

$telegram = new TelegramBot($botToken, $chatID);
$telegram->sendMessage('Hello world!');

// Send more optional options in the body of the request
$telegram->sendMessage('<b>Hello world!</b>', ['parse_mode' => ParseMode::HTML->value]);
```

## Contribution & Development

Contributions are welcome! This project is open-source and free for distribution.

### Development Setup

Clone the repository and install dependencies:
```bash
$ composer install --dev --prefer-dist
```

Ensure all tests and coding standards are met before submitting a pull request:
```bash 
$ composer check
```

All contributions must be submitted via pull requests and must pass tests and coding standards before being merged.
