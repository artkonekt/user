<?php
/**
 * Contains the User interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-03-24
 *
 */

namespace Konekt\User\Contracts;

interface User
{
    public function inactivate();

    public function activate();

    public function getProfile(): ?Profile;
}
