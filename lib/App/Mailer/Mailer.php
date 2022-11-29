<?php namespace App\Mailer;

use M\App\Application;
use M\Debug\Environment;
use M\Exception\RuntimeErrorException;
use M\Mail\Interfaces\Mailer as MailerInterface;
use M\Mail\Mail;
use M\Mail\MailerSmtp;
use M\Mail\MailHelper;
use M\Mail\MailLogger;
use M\Object\StaticClass;
use M\Uri\Uri;

class Mailer extends StaticClass
{
    /* -- PUBLIC -- */

    /**
     * Get a base mail, which can be used throughout the application
     *
     * @param string $context
     *      If you provide a new context, it needs a database table for storage.
     *      To do so, duplicate one of the existing ones like log_mail_user_register,
     *      and change the name to the new context. Syntax: log_mail_{context}
     * @return Mail
     */
    public static function getBaseMail(string $context): Mail
    {
        $mail = new Mail();
        $mail->setContext($context);
        $mail->setMailer(Mailer::getMailer());
        // Turn this on if you want to have mail logs
        //$mail->getMailer()->setLogger(new MailLogger());
        $mail->setFrom(
            MailHelper::getRecipientStringFormat(name(), Application::getIdentity()->getEmailByType('from')->getEmail())
        );
        return $mail;
    }

    /**
     * Get mailer
     *
     * @return MailerInterface
     */
    public static function getMailer()
    {
        // If mailtrap is activated
        // Mailtrap won't apply its css when sending mails locally,
        // so we will use our own mailer, with debug options, so that
        // we'll be able to see the css on development
        if (Application::getConfig()->get('mail/mailtrap/active')) {
            return self::getMailtrapMailer();
        }

        return new \M\Mail\Mailer();
    }

    /**
     * @return MailerInterface
     * @throws RuntimeErrorException
     */
    protected static function getMailtrapMailer(): MailerInterface
    {
        $uri        = new Uri('smtp://smtp.mailtrap.io:587');
        $config     = Application::getConfig();
        $username   = $config->get('mail/mailtrap/username');
        $password   = $config->get('mail/mailtrap/password');
        if ( ! $username || ! $password) {
            throw new RuntimeErrorException(
                'Cannot setup MailTrap mailer, missing credentials!'
            );
        }
        $uri->setUsername($username);
        $uri->setPassword($password);
        return new MailerSmtp($uri);
    }
}
