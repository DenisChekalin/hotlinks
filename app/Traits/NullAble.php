<?php

declare(strict_types=1);

namespace App\Traits;

trait NullAble
{
    protected $isEmpty = false;

    public static function null(): self
    {
        $entity = app(static::class);
        $entity->setEmpty();
        return $entity;
    }

    public function isEmpty(): bool
    {
        return $this->isEmpty;
    }

    protected function setEmpty(): void
    {
        $this->isEmpty = true;
    }
}
