<?php
/**
 * Contains the BaseAvatarResolver class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-18
 *
 */


namespace Konekt\User\Models\Avatar;


use Illuminate\Http\UploadedFile;
use Konekt\User\Contracts\AvatarResolver;

abstract class BaseAvatarResolver implements AvatarResolver
{
    /** @var  string */
    protected $data;

    /**
     * @inheritDoc
     */
    public function getTypeSlug()
    {
        return classpath_to_slug(static::class);
    }

    /**
     * @inheritDoc
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    abstract public function getTypeName();

    /**
     * @inheritDoc
     */
    abstract public function getUrl();

    /**
     * @inheritDoc
     */
    abstract public function save(UploadedFile $file);

    /**
     * @inheritDoc
     */
    abstract public function delete();

}