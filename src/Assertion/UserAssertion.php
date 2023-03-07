<?php

namespace App\Source\Assertion;

use CommonSource\Assertion\Code\Assertable;

class UserAssertion extends Assertable
{

    protected function init(): array
    {
        return [
            $this->model->login,
            $this->model->phone_number
        ];
    }
}
