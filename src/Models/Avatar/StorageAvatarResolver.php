<?php
/**
 * Contains the StorageAvatarResolver.php class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-18
 *
 */


namespace Konekt\User\Models\Avatar;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageAvatarResolver extends BaseAvatarResolver
{

    /**
     * @inheritDoc
     */
    public function getTypeName()
    {
        return __('Internal storage');
    }

    /**
     * @inheritDoc
     */
    public function getUrl()
    {
        return Storage::url($this->getData());
    }

    /**
     * @inheritDoc
     */
    public function save(UploadedFile $file)
    {
        $path = $file->storePublicly('avatars');

        if (false === $path) {
            return false;
        }

        $this->setData($path);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function delete()
    {
        return Storage::delete($this->getData());
    }


}