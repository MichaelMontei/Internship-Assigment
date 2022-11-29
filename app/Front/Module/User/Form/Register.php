<?php namespace Front\Module\User\Form;

use App\Acl\Gatekeeper;
use App\Mailer\Mailer;
use App\Mailer\View\MailWrap;
use App\User\User;
use App\User\UserMapper;
use M\App\Application;
use M\Form\Control\Control;
use M\Form\Control\Text;
use M\Form\Controls;
use M\Mail\MailHelper;
use Front\Module\User\View\RegisterActivationMail;
use User\Form\PasswordNew;

/**
 * Class Register
 * @package Front\Module\User\Form
 */
class Register extends PasswordNew
{

    /**
     * Add fields
     *
     * @access protected
     * @return Controls
     */
    protected function _getControls()
    {
        return new \M\Form\Controls([
            $this->_getControlEmail(),
            $this->_getControlFirstName(),
            $this->_getControlSurname(),
            $this->_getControlNewPassword(),
            $this->_getControlNewPasswordConfirmation(),
            $this->_getControlCompany(),
        ]);
    }

    /**
     * Actions
     *
     * @param array $values
     * @return bool
     */
    protected function _actions(array $values)
    {
        // Fetch the user
        $user = $this->getUser();
        /* @var $user User */

        // Set values from the form
        $user
            //  -- BASE INFO
            ->setEmail($values['email'])
            ->setFirstName($values['firstName'])
            ->setSurname($values['surname'])

            // -- COMPANY INFO
            ->setCompany($values['company'])

            // -- META INFO
            // New users that sign up themselves are base users by default. If
            // they need to be admin, an existing admin will have to promote them
            ->setRoleId(Gatekeeper::ROLE_USER_ID)
            ->setLocale(\M\Locale\Locale::getCategory(\M\Locale\Category::LANG));


        // Before letting the parent handle the user and give them a password,
        // save it already. We need the user to have a primary key, otherwise
        // it will generate a wrong bcrypt. Took me an hour to figure out why
        // I couldn't log in, so would be nice if we could prevent this.
        if (!$user->save()) {
            return false;
        }

        // Let the parent handle the password
        if (!parent::_actions($values)) {
            return false;
        }

        // The user has been created, but is not active yet. Send them an
        // activation email:
        if (!$this->sendUserActivationMail()) {
            return false;
        }

        // Get the redirect path from config:
        $this->setRedirectUriWithPath('user/register/ok');

        // We're done!
        return true;
    }

    /**
     * Get Control: "Email"
     *
     * @return Control
     */
    protected function _getControlEmail()
    {
        $control = (new \M\Form\Control\Text('email'))
            ->setMandatory(TRUE);

        // Add a validator, to make sure we get a valid email address
        $control->addValidator(
            new \M\Validator\Email(),
            \M\Locale\Strings::getInstance()->getMessage(
                \M\Locale\Strings::ERR_FIELD_INVALID_EMAIL
            )
        );

        // Add a validator, to make sure the email does NOT exist:
        $validator = new \M\Validator\NotExistingDataObjectValue([
            \M\Validator\NotExistingDataObjectValue::DATA_OBJECT_FIELD => 'email',
            \M\Validator\NotExistingDataObjectValue::DATA_OBJECT_MAPPER => (new UserMapper())
        ]);

        $control->addValidator(
            $validator,
            \M\App\Application::getConfig()->get('user/errors/email-existing')
        );

        return $control;
    }

    /**
     * Get Control: "First name"
     *
     * @return Control
     */
    protected function _getControlFirstName()
    {
        return (new Text('firstName'))->setMandatory(true);
    }

    /**
     * Get Control: "Surname"
     *
     * @return Control
     */
    protected function _getControlSurname()
    {
        return (new Text('surname'))->setMandatory(true);
    }

    /**
     * Get Control: "Company"
     *
     * @return Control
     */
    protected function _getControlCompany()
    {
        return (new Text('company'))->setMandatory(true);
    }

    /**
     * Send user activation mail
     *
     * @return bool
     */
    protected function sendUserActivationMail()
    {
        $user = $this->getUser();
        $identity = Application::getIdentity();

        // Prepare the subject, which we'll also print in the <title> of the mail header
        $subject = t(
            '[@name] Activate your account',
            [
                '@name' => $identity->getName()
            ]
        );

        // Start with the base mail
        $mail = Mailer::getBaseMail('user_register');

        // Set the user we just created as recipient, and the application as
        // reply to
        $mail->addRecipient($user->getRecipientString());
        $mail->setReplyTo(MailHelper::getRecipientStringFormat(
            $identity->getName(),
            $identity->getEmailByType('info')->getEmail()
        ));

        // Set view variables, and fire away!
        $mail->setSubject($subject);
        $mail->setBody(
            (new RegisterActivationMail())
                ->setUser($user)
                ->addWrap(
                    (new MailWrap())->setTitle($subject)
                )
                ->getHtml()
        );

        return $mail->send();
    }
}