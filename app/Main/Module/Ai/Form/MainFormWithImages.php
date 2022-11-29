<?php namespace Ai\Form;

use Ai\Form\Form;
use Image\Model\Image\ImageMapper;
use Image\Model\Image\ImageXObject;
use Image\Model\Image\ImageXObjectMapper;
use M\Form\Control as Ctrl;

abstract class MainFormWithImages extends MainForm
{
    /**
     * Get control: images
     *
     * @param bool $mandatory
     * @return Ctrl\Upload
     */
    protected function getControlImages($mandatory = false)
    {
        $controlUpload = new Ctrl\Upload(
            $this->getControlImageId(),
            $this->getImageHandler(),
            $this->getImageStorage(),
            $mandatory
        );

        $controlUpload->getViewDecorator()->setDescription(t('Allowed extensions: @allowedExtensions. Maximum @size.', ['@allowedExtensions' => 'jpg, png', '@size' => '2MB']));

        if (!$this->getDataObject()->isNew()) {
            $defaultImages = [];

            foreach ((new \Image\Model\Image\ImageMapper())->addFilterDataObject($this->getDataObject(), false)->getAll() as $image) {
                if (!$controlUpload->getFileHandler()->getMultiple()) {
                    $defaultImages = [];
                }

                $defaultImages[] = (new Ctrl\Upload\File($image->getUrl()))->setOriginalFilename($image->getTitle());
            }

            /* @var $image \Image\Model\Image\Image */
            $controlUpload->setDefaultValue($defaultImages);
        }

        return $controlUpload;
    }

    /**
     * @return string
     */
    protected function getControlImageId(): string
    {
        return $this->getId() . '_images';
    }

    /* -- PROCESSING -- */

    /**
     * Post processing
     *
     * @param Form $form
     * @param array $vars
     * @return boolean
     */
    public function getActionsPostProcessing(Form $form, array $vars)
    {
        if (!parent::getActionsPostProcessing($form, $vars)) {
            return false;
        }

        $storage = $vars[$this->getControlImageId()];

        /* @var $storage \M\Form\Control\Upload\StorageLocal */

        // Remove the previous images
        $currentImages = [];
        foreach ((new ImageMapper())->addFilterDataObject($this->getDataObject(), false)->getAll()->getArrayCopy() as $currentImage) {
            $currentImages[$currentImage->getUrl()] = $currentImage;
        }

        $sortVar = \M\Server\Request::getVariable('images-sorted-' . $this->getControlImageId());
        $imagesSorted = $sortVar ? explode(',', $sortVar) : [];
        $i = count($imagesSorted);

        foreach ($storage->store() as $imageFile) {
            if ($imageFile && $imageFile->exists()) {
                if (array_key_exists($imageFile->getPath(), $currentImages)) {
                    $image = $currentImages[$imageFile->getPath()];
                    unset($currentImages[$imageFile->getPath()]);
                } else {
                    $image = new \Image\Model\Image\Image();
                    $image->setTitle($imageFile->getOriginalFilename());
                    $image->setFileExtension($imageFile->getExtension());
                    $image->setUrl($imageFile->getPath());
                    $image->setStorageType(\Image\Model\Image\ImageDefinition::STORAGE_LOCAL_FILESYSTEM);
                    $image->setDateAdded(new \M\Time\Date());
                    $image->save();
                }

                $sorting = array_search($image->getHashIdEncrypted(), $imagesSorted);
                if ($sorting === false) {
                    $sorting = $i++;
                }

                $ixo = ImageXObject::create($image, $this->getDataObject(), $sorting);

                (new ImageXObjectMapper())->save($ixo);
            }
        }

        // Remove the old images
        foreach ($currentImages as $oldImage) {
            $oldImage->delete();
        }

        return true;
    }

    /**
     * Get image handler
     *
     * @return Ctrl\Upload\FileHandler
     */
    public function getImageHandler()
    {
        return new Ctrl\Upload\FileHandler($this->getId(), ['jpeg', 'jpg', 'gif', 'png'], '5MB', true);
    }

    /**
     * Get storage
     *
     * @return Ctrl\Upload\StorageLocal
     */
    public function getImageStorage()
    {
        return (new Ctrl\Upload\StorageLocal(new \M\Fs\Local\Directory('files/images/' . $this->getId())));
    }
}