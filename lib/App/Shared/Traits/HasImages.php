<?php namespace App\Shared\Traits;

use AppKit\Form\Uploads\UploadedFile;
use AppKit\Form\Uploads\UploadedFileList;
use Image\Model\Image\Image;
use Image\Model\Image\ImageDefinition;
use Image\Model\Image\ImageMapper;
use Image\Model\Image\ImageXObject;
use M\DataObject\DataObject;
use M\DataObject\FilterLimit;
use M\DataObject\FilterOrderRandom;
use M\DataObject\Interfaces\ObjectInterface;
use M\DataObject\Interfaces\ResultSet;
use M\Exception\RuntimeErrorException;
use M\Form\Control\Upload\File;
use M\Time\Date;

/**
 * Trait HasImages, just an object that can have images linked to it
 *
 * @package App\Traits
 */
trait HasImages
{
    /* -- PROPERTIES -- */

    /**
     * Default thumbnail
     *
     * @var string
     */
    protected $thumbnail = 'full';


    /* -- PUBLIC -- */

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return $this
     */
    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * Get the image of this object
     *
     * @param string $realm
     * @return Image|DataObject|NULL
     */
    public function getImage(string $realm = 'image'): ?Image
    {
        return (new ImageMapper())
            /* @var $this ObjectInterface */
            ->addFilterDataObject($this, false)
            ->addFilterRealm($realm)
//            ->addFilterPublished()
            ->getOne();
    }

    /**
     * Get an image list
     *
     * @param string|null $realm
     * @return ResultSet
     */
    public function getImageList(string $realm = 'image'): ResultSet
    {
        return (new ImageMapper())
            /* @var $this ObjectInterface */
            ->addFilterDataObject($this, false)
            ->addFilterRealm($realm)
            //->addFilterPublished()
            ->getAll();
    }

    /**
     * Get the full href of this object's image
     *
     * @param string|null $thumbnail
     * @param string $realm
     * @return string
     * @throws RuntimeErrorException
     */
    public function getImageHref(string $thumbnail = null, string $realm = 'image'): string
    {
        $thumbnail = $thumbnail ?? $this->getThumbnail();
        $image = $this->getImage($realm);
        if ( ! $image) {
            return '';
        }
        return $this->_getHrefForImage($image, $thumbnail);
    }

    /**
     * Returns an array containing the href's for all this object's images
     *
     * @param string|null $thumbnail
     * @param string|null $realm
     * @return array
     * @throws RuntimeErrorException
     */
    public function getImageHrefList(string $thumbnail = null, string $realm = 'image'): array
    {
        $thumbnail = $thumbnail ?? $this->getThumbnail();
        $list = [];
        /* @var $image Image */
        foreach ($this->getImageList($realm) as $image) {
            $list[] = $this->_getHrefForImage($image, $thumbnail);
        }
        return $list;
    }

    /**
     * Will process the files that have been provided to the upload
     * Removes any file that is from this object if a file has been uploaded
     *
     * @param UploadedFileList $files
     * @param string|null $realm
     * @return boolean
     */
    public function processFiles(UploadedFileList $files, string $realm = 'image'): bool
    {

        $currentImages = [];
        foreach((new ImageMapper())->addFilterDataObject($this, false)->addFilterRealm($realm)->getAll()->getArrayCopy() as $currentImage) {
            $currentImages[$currentImage->getUrl()] = $currentImage;
        }

        $orderIndex = 0;
        foreach($files as $i => $file)
        {
            /* @var $file UploadedFile */
            if(array_key_exists($file->getPath(), $currentImages)) {
                $image = $currentImages[$file->getPath()];
                unset($currentImages[$file->getPath()]);
            } else {
                $image = new Image();
                $image->setTitle($file->getOriginalFilename());
                $image->setFileExtension(pathinfo($file->getOriginalFilename(), PATHINFO_EXTENSION));
                $image->setFileBasename($file->getOriginalFilename());
                $image->setUrl($file->getPath());
                $image->setStorageType(ImageDefinition::STORAGE_LOCAL_FILESYSTEM);
                $image->setDateAdded(new Date());
                $image->setPublished(true);
                $image->save();
            }

            ImageXObject::create(
                $image,
                $this,
                $orderIndex++
            )->setRealm($realm)->save();
        }

        // Remove the old images
        foreach($currentImages as $key => $oldImage) {
            $oldImage->delete();
        }

        return true;
    }

    /**
     * Get images
     *
     * @param bool $published
     * @param int|null $limit
     * @param bool $randomize
     * @return \M\DataObject\ResultSet
     */
    public function getImages(bool $published = null, ?int $limit = null, bool $randomize = false, int $offset = 0): \M\DataObject\ResultSet
    {
        $mapper = $this->getImageMapper($published);

        if ($limit) {
            $mapper->addFilter(new FilterLimit($offset, $limit));
        }

        if ($randomize) {
            $mapper->addFilter(new FilterOrderRandom());
        }

        return $mapper->getAll();
    }

    /**
     * @return File[]
     */
    public function getImagesAsUploadFiles(): array
    {
        $images = $this->getImages();
        /* @var $image Image */
        $result = [];
        foreach ($images as $image) {
            $file = new File($image->getUrl());
            if ($file->exists()) {
                $result[] = $file;
            }
        }

        return $result;
    }


    /* -- PRIVATE/PROTECTED -- */

    /**
     * @param bool $published
     * @return ImageMapper
     */
    public function getImageMapper(bool $published = null): ImageMapper
    {
        $mapper = new ImageMapper();
        if ($published !== null) {
            $mapper->addFilterPublished((bool) $published);
        }
        /* @var $this ObjectInterface */
        $mapper->addFilterDataObject($this, false);

        return $mapper;
    }

    /**
     * Get the href for the image provided
     *
     * @param Image $image
     * @param string|null $thumbnail
     * @return string
     * @throws RuntimeErrorException
     */
    protected function _getHrefForImage(Image $image, string $thumbnail = null): string
    {
        $thumbnail = $thumbnail ?? $this->getThumbnail();
        return href(
            'thumbnail/' . $thumbnail . '/' . $image->getHashIdEncrypted(). '/' .
            $image->getFileBasename()
        );
    }
}
