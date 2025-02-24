<?php

declare(strict_types=1);

namespace Matmper;

use stdClass;

class TelegramResponse
{
    /**
     * @var boolean
     */
    public bool $ok;

    /**
     * @var stdClass
     */
    public stdClass $result;

    public function __construct(bool $ok, stdClass $result)
    {
        $this->ok = $ok;
        $this->result = $result;
    }

    /**
     * @param stdClass $data
     * @return self
     */
    public static function fromStdClass(stdClass $data): self
    {
        return new self(
            $data->ok ?? false,
            $data->result ?? new stdClass()
        );
    }
}
