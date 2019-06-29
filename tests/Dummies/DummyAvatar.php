<?php
/**
 * Contains the DummyAvatar class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-18
 *
 */

namespace Konekt\User\Tests\Dummies;

use Konekt\User\Contracts\Avatar;

class DummyAvatar implements Avatar
{
    private $data;

    private $isDeleted = false;

    public function __construct(string $data = null)
    {
        $this->data = $data;
    }

    public static function create(string $data = null): Avatar
    {
        return new self($data);
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function delete()
    {
        $this->isDeleted = true;
    }

    public function getUrl(string $variant = null): string
    {
        $variant = is_null($variant) ? '' : "{$variant}_";

        return "http://localhost/{$variant}{$this->data}.jpg";
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }
}
