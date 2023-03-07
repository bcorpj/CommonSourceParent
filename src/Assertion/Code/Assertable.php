<?php

namespace CommonSource\Assertion\Code;

use App\Source\Login\Access\Tokenable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Str;

/**
 * Assertable class
 *
 * Class is for check that request is valid and not expired
 *
 */
abstract class Assertable
{
    protected Model $model;
    protected string $checkSum;
    private Carbon $expiredAt;
    private string $firstField;
    private string $secondField;


    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->setFields($this->init());
    }

    public function isValid(string $requestToken): bool
    {
        $this->setCheckSum($requestToken);
        return $this->validate();
    }

    public function generate (): string
    {
        return $this->generateCheckSum();
    }

    abstract protected function init();

    protected function setFields (array $fields): void
    {
        $this->firstField = $fields[0];
        $this->secondField = $fields[1];
    }

    /**
     *
     * @return bool
     */
    protected function validate (): bool
    {
        if (Carbon::now()->gte($this->expiredAt))
            return false;

        $notHashed = $this->expiredAt->format('H:i') . '|' . $this->firstField . $this->secondField;
        return (bool)
            Tokenable::attempt($notHashed, $this->checkSum);
    }

    /**
     * It's generate checkSum
     * @return string
     */
    protected function generateCheckSum (): string
    {
        $expiration = Carbon::now()->addHour()->format('H:i');
        return $expiration . '|' . Tokenable::hash($expiration . '|' . $this->firstField . $this->secondField);
    }

    /**
     * @param string $checkSum
     * @return void
     */
    protected function setCheckSum(string $checkSum): void
    {
        $this->expiredAt = Carbon::createFromFormat('H:i', Str::before($checkSum, '|'));
        $this->checkSum = Str::after($checkSum, '|');
    }

}
