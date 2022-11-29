<?php namespace User\Controller;

use App\User\UserMapper;

class UserRegister extends \Main\Controller\Main
{
    /**
     * Register form
     */
    public function index()
    {
        // This page is available only if the user has NOT logged in
        if (\User\Authentication::getInstance()->isAuthenticated()) {
            redirect(href('user/profile'));
        }

        $form = new \User\Form\Register(new \App\User\User());

        if ( ! $form->run()) {
            (new \User\View\Register())
                ->setForm($form)
                ->addWrap(
                    $this->_getWrap(
                        \M\App\Application::getConfig()->get('user/pages/register-title'),
                        \M\App\Application::getConfig()->get('user/pages/register-description')
                    )
                )
                ->display()
            ;
        }
    }

    /**
     * Register thank you page
     */
    public function ok()
    {
        // This page is available only if the user has NOT logged in
        if (\User\Authentication::getInstance()->isAuthenticated()) {
            redirect(href('user/profile'));
        }

        (new \User\View\RegisterOk())
            ->addWrap(
                $this->_getWrap(
                    \M\App\Application::getConfig()->get('user/pages/register-ok-title'),
                    \M\App\Application::getConfig()->get('user/pages/register-ok-description')
                )
            )
            ->display()
        ;
    }

    /**
     * Activate link through email
     */
    public function activate($userHashId, $token)
    {
        // This page is available only if the user has NOT logged in
        if (\User\Authentication::getInstance()->isAuthenticated()) {
            redirect(href('user/profile'));
        }

        $user = (new UserMapper())
            ->addFilterToken($token)
            ->getByHashIdEncrypted($userHashId)
        ;

        /* @var $user \App\User\User */
        if ( ! $user) {
            throw new \M\Exception\ResourceNotFoundException(sprintf(
                'No user found with hashId "%s" and token "%s"',
                $userHashId,
                $token
            ));
        }

        if ($user->getActive()) {
            redirect(href('user/login'));
        }

        // Set active
        $user->setActive(1);
        $user->save();

        (new \User\View\RegisterActivated())
            ->setUser($user)
            ->addWrap(
                $this->_getWrap(
                // Get title and description from the config
                    '', ''
                )
            )
            ->display()
        ;
    }
}