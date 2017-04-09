<?php
/**
 * Contains the AvatarResolver Interface.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-18
 *
 */


namespace Konekt\User\Contracts;


use Illuminate\Http\UploadedFile;

interface AvatarResolver
{
    /**
     * Return the specific type's
     *
     * @return string
     */
    public function getTypeSlug();

    /**
     * Returns the name of the resolver type
     *
     * @return string
     */
    public function getTypeName();

    /**
     * Set avatar data (URL, id, image data, whatever)
     *
     * @param $data
     *
     * @return mixed
     */
    public function setData($data);

    /**
     * Returns the avatar data
     *
     * @return string
     */
    public function getData();

    /**
     * Returns the url for the avatar
     *
     * @return string
     */
    public function getUrl();

    /**
     * Saves the avatar
     *
     * @param UploadedFile $file
     *
     * @return bool
     */
    public function save(UploadedFile $file);

    /**
     * Deletes the avatar
     *
     * @return bool
     */
    public function delete();

}