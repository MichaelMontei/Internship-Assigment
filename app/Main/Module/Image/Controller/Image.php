<?php namespace Image\Controller;

use App\Acl\Gatekeeper;
use Image\Model\Image\ImageXObjectMapper;

/**
 * Class Image
 * @package Main\Module\Image\Controller
 */
class Image extends \Main\Controller\MainAuthenticated
{
    /**
     * Remove
     *
     * @param string $hashId
     * @throws \M\Exception\ResourceNotFoundException
     * @throws \M\Exception\RuntimeErrorException
     */
    public function remove($hashId)
    {
        $image = (new \Image\Model\Image\ImageMapper())->getByHashIdEncrypted($hashId);

        if (!$image) {
            throw new \M\Exception\ResourceNotFoundException(sprintf(
                'No image found with hash id [%s]',
                $hashId
            ));
        }

        if (Gatekeeper::getActiveRole()->getId() !== Gatekeeper::ROLE_ADMIN_ID) {
            throw new \M\Exception\ResourceNotFoundException(sprintf(
                'Only admin users are allowed to remove images [%s]',
                $hashId
            ));
        }

        if (!$image->delete()) {
            throw new \M\Exception\RuntimeErrorException(sprintf(
                'Failed to remove image with id [%s]',
                $image->getId()
            ));
        }

        echo json_encode(1);
    }
}