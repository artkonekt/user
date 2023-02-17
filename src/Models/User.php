<?php
/**
 * Contains the User entity class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-18
 *
 */

namespace Konekt\User\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Konekt\Enum\Eloquent\CastsEnums;
use Konekt\User\Contracts\User as UserContract;
use Konekt\User\Contracts\Profile as ProfileContract;
use Konekt\User\Events\UserWasActivated;
use Konekt\User\Events\UserWasCreated;
use Konekt\User\Events\UserWasDeleted;
use Konekt\User\Events\UserWasInactivated;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property int $login_count
 * @property UserType $type
 * @property bool $is_active
 * @property Carbon|null $last_login_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 */
class User extends Authenticatable implements UserContract
{
    use Notifiable, SoftDeletes, CastsEnums;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'type', 'is_active'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    protected $enums = [
        'type' => 'UserTypeProxy@enumClass'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $events = [
        'created' => UserWasCreated::class,
        'deleted' => UserWasDeleted::class
    ];

    public function getProfile(): ?ProfileContract
    {
        return $this->profile;
    }

    public function profile()
    {
        return $this->hasOne(ProfileProxy::modelClass(), 'user_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function inactivate()
    {
        $this->is_active = false;
        $this->save();

        event(new UserWasInactivated($this));
    }

    public function activate()
    {
        $this->is_active = true;
        $this->save();

        event(new UserWasActivated($this));
    }
}
