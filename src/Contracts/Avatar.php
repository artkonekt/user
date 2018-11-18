<?php
/**
 * Contains the Avatar interface.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-18
 *
 */

namespace Konekt\User\Contracts;

interface Avatar
{
    public static function create(string $data = null): Avatar;

    public function getData(): string;

    public function getUrl(string $variant = null): string;

    public function delete();
}
