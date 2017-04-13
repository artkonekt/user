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

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Konekt\User\Contracts\User as UserContract;

/**
 * User Entity class
 *
 */
class User extends Authenticatable implements UserContract
{
    use Notifiable;

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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(ProfileRepository::modelClass(), 'id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


}