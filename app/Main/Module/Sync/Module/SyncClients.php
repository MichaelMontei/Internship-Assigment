<?php

namespace Main\Module\Sync\Module;

use M\Exception\RuntimeErrorException;

class SyncClients
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    /**
     * @throws RuntimeErrorException
     */
    public function handle(): void
    {
        foreach ($this->data as $clientNode) {
            /* @var $clientNode array */
            (new SyncClient($clientNode))->handle();
        }
    }
}
