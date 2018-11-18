<?php
/**
 * Contains the Profile model class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-18
 *
 */

namespace Konekt\User\Models;

use Illuminate\Database\Eloquent\Model;
use Konekt\User\Contracts\Profile as ProfileContract;

class Profile extends Model implements ProfileContract
{
    protected $table = 'profiles';

    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass(), 'user_id');
    }

    protected static function boot()
    {
    }
}
