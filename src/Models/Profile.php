<?php

declare(strict_types=1);
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
use Illuminate\Support\Carbon;
use Konekt\Address\Models\Person;
use Konekt\Address\Models\PersonProxy;
use Konekt\User\AvatarTypes;
use Konekt\User\Contracts\Avatar;
use Konekt\User\Contracts\Profile as ProfileContract;
use Konekt\User\Contracts\User;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property int $person_id
 * @property Person $person
 * @property string|null $avatar_type
 * @property string|null $avatar_data
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Profile extends Model implements ProfileContract
{
    protected $table = 'profiles';

    protected $guarded = ['id'];

    public function getUser(): User
    {
        return $this->user;
    }

    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass(), 'user_id');
    }

    public function person()
    {
        return $this->belongsTo(PersonProxy::modelClass(), 'person_id');
    }

    public function setAvatar(Avatar $avatar)
    {
        $this->avatar_type = AvatarTypes::getType(get_class($avatar));
        $this->avatar_data = $avatar->getData();
    }

    public function getAvatar(): ?Avatar
    {
        if (!$this->hasAvatar()) {
            return null;
        }

        $class = AvatarTypes::getClass($this->avatar_type);

        if (!class_exists($class)) {
            return null;
        }

        return new $class($this->avatar_data);
    }

    public function removeAvatar()
    {
        if ($avatar = $this->getAvatar()) {
            $avatar->delete();
        }

        $this->avatar_type = null;
        $this->avatar_data = null;
    }

    public function hasAvatar(): bool
    {
        return (bool) $this->avatar_type;
    }

    public function avatarUrl(string $variant = null): ?string
    {
        if (!$this->hasAvatar()) {
            return null;
        }

        return $this->getAvatar()?->getUrl($variant);
    }
}
