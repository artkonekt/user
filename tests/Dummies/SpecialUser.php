<?php

declare(strict_types=1);

/**
 * Contains the SpecialUser class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-18
 *
 */

namespace Konekt\User\Tests\Dummies;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Konekt\Enum\Eloquent\CastsEnums;
use Konekt\User\Contracts\Profile as ProfileContract;
use Konekt\User\Contracts\User as UserContract;
use Konekt\User\Models\UserType;

class SpecialUser extends Authenticatable implements UserContract
{
    use Notifiable;
    use SoftDeletes;
    use CastsEnums;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'type'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $enums = [
        'type' => UserType::class
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getProfile(): ?ProfileContract
    {
        return null;
    }

    public function inactivate()
    {
    }

    public function activate()
    {
    }
}
