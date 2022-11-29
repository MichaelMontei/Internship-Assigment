<?php
/**
 * App
 *
 * @package Admin
 * @package App
 */

namespace Front\Config;

use App\Mailer\View\MailWrap;
use M\View\View;
use Front\View\PageWrap;

/**
 * App
 *
 * @package Main
 * @package App
 */
class App extends \Config\App
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct([
            'user' => [
                // The class of the user-object that is used in the application
                // NOTE: this class needs to implement \User\Model\Interfaces\User
                'class' => '\App\User\User',
                // The base path of the user-related stuff
                // The user-package will use this path for redirects, e.g. user/profile, user/recovery...
                'basepath' => 'user',
                // The path where the user is redirected to after LOGIN
                // NOTE: the basepath is NOT taken into account
                'path-login-redirect' => '',
                // The path where the user is redirected to after LOGOUT
                // NOTE: the basepath is NOT taken into account
                'path-logout-redirect' => '',
                // The error-messages used by the user-package
                // NOTE: the user-package will handle these strings as translatable
                'errors' => [
                    'login-failed' => 'Login failed. Please try again.',
                    'invalid-pass' => 'The confirmed password did not match. Please try again.',
                    'min-characters' => 'Your password should contain at least @count characters.',
                    'account-not-found' => 'Your account could not be found. Please try again.',
                    'wrong-password' => 'Incorrect password. Please note that passwords are case sensitive. As ' .
                        'such, please ensure the "caps lock" button on your keyboard is inactive.',
                    'email-existing' => 'There is already a user with this email address.'
                ],
                // The email-subjects used by the user-package
                // NOTE: the user-package will handle these strings as translatable
                'subjects' => [
                    'password-recovery' => 'Reset your password',
                    'password-recovery-completed' => 'Your password has been reset'
                ],
                // The page-titles & -descriptions used by the user-package
                // NOTE: the user-package will handle these strings as translatable
                'pages' => [
                    'login-title' => strtr('Welcome to @name - Login', ['@name' => name()]),
                    'login-description' => 'This page allows you to log in with your email address and password.',
                    'register-title' => 'Register',
                    'register-description' => 'This page allows you to create a new account.',
                    'register-ok-title' => 'Registration was successful',
                    'register-ok-description' => 'Registration completed. Please check your mailbox for an activation link.',
                    'recovery-title' => 'Forgot your password?',
                    'recovery-description' => 'This page allows you to create a new password by entering your email address.',
                    'change-title' => 'Change password',
                    'change-description' => 'This page allows you to change your password.',
                    'profile-title' => 'My account',
                    'profile-description' => 'This page allows you to change your account details.',
                ],
                // Password-related settings
                'password' => [
                    'min-characters' => 6
                ],
                'mail-css-path' => 'src/shared/custom/css/mail.css',
            ],
        ]);
    }

    /**
     * Get wrap
     *
     * @return View
     */
    public function getWrap($pageTitle = '', $pageDescription = '')
    {
        // Add the page wrap
        $wrap = (new PageWrap())
            ->setPageTitle($pageTitle)
            ->setPageDescription($pageDescription);

        return $wrap;
    }

    /**
     * @return MailWrap
     */
    public function getMailWrap()
    {
        return (new MailWrap());
    }
}