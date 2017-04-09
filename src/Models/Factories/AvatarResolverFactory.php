<?php
/**
 * Contains the AvatarFactory class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-18
 *
 */


namespace Konekt\User\Models\Factories;


use Konekt\User\Contracts\AvatarResolver;

class AvatarResolverFactory
{
    /**
     * Creates an avatar resolver
     *
     * @param string $typeSlug
     * @param null   $data
     *
     * @return AvatarResolver
     */
    public static function create(string $typeSlug, $data = null)
    {
        /** @var AvatarResolver $avatarResolver */
        $avatarResolver = app(slug_to_classpath($typeSlug));

        if ($avatarResolver && $data) {
            $avatarResolver->setData($data);
        }

        return $avatarResolver;
    }

}