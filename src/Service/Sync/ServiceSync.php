<?php

namespace CommonSource\Service\Sync;

use CommonSource\Service\Intentions\Sync;

class ServiceSync extends Sync
{
    /**
     * @return array
     */
    protected function routes(): array
    {
        return [
            'create' => '/common/produce',
            'notify' => '/common/notify'
        ];
    }
}
