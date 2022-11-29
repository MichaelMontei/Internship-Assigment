<?php namespace Main\Module\User\Controller;

use User\Form\Profile;

/**
 * Class User
 * @package Main\Module\User\Controller
 */
class User extends \Main\Controller\Main
{
	use \User\Controller\Traits\User;
//
//    /**
//     * Profile
//     */
//	public function profile(): void
//    {
//        // This page is available only if the user has already logged in
//        if(! \User\Authentication::getInstance()->isAuthenticated()) {
//            redirect($this->_getPath('login'));
//        }
//
//        // Create the form, based on the authenticated user:
//        $form = new Profile(
//            \User\Authentication::getInstance()->getAuthUser()
//        );
//
//        $form->setRedirectUriWithPath($this->_getPath('profile-ok'));
//
//        if(! $form->run()) {
//            $view = new \User\View\Profile();
//            $view
//                ->setForm($form)
//                ->addWrap($this->_getWrap(
//                // Get title and description from the config
//                    $this->_getConfig()->get('user/pages/profile-title'),
//                    $this->_getConfig()->get('user/pages/profile-description')
//                ))
//                ->display();
//        }
//    }
}