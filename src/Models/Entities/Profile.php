<?php
/**
 * Contains the Profile entity class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-18
 *
 */


namespace Konekt\User\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Konekt\User\Contracts\AvatarResolverInterface;
use Konekt\User\Models\Factories\AvatarResolverFactory;

class Profile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /** @var  AvatarResolverInterface|null */
    protected $avatarResolver;

    public function user()
    {
        return $this->belongsTo(User::class, 'country_id');
    }

    /**
     * Returns the avatar object of the user
     *
     * @return AvatarResolverInterface|null
     */
    public function avatar()
    {
        if (!$this->avatarResolver) {
            if (!$this->avatar_type) {
                return null;
            }

            $this->avatarResolver = AvatarResolverFactory::create($this->avatar_type, $this->avatar_data);
        }

        return $this->avatarResolver;
    }

    /**
     * Returns whether the user has an avatar
     *
     * @return bool
     */
    public function hasAvatar()
    {
        return (bool) $this->avatar;
    }

}