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
use Konekt\Enum\Eloquent\CastsEnums;
use Konekt\User\Contracts\User as UserContract;
use Konekt\User\Events\UserWasActivated;
use Konekt\User\Events\UserWasCreated;
use Konekt\User\Events\UserWasDeleted;
use Konekt\User\Events\UserWasInactivated;

/**
 * User Entity class
 *
 */
class User extends Authenticatable implements UserContract
{
    use Notifiable, SoftDeletes, CastsEnums;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'is_active'
    ];

    protected $dates = ['created_at', 'updated_at', 'last_login_at'];

    protected $enums = [
        'type' => 'UserTypeProxy@enumClass'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $events = [
        'created' => UserWasCreated::class,
        'deleted' => UserWasDeleted::class
    ];

    public function profile()
    {
        return $this->hasOne(ProfileProxy::modelClass(), 'id', 'id');
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
