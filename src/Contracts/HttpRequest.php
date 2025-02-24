<?php

namespace Matmper\Contracts;

interface HttpRequest
{
    /**
     * Set new CURLOPT
     *
     * @param int $name
     * @param mixed $value
     * @return void
     */
    public function setopt(int $name, $value): void;

    /**
     * curl_execute
     *
     * @return string
     */
    public function execute(): string;
}
