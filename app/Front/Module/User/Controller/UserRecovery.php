<?php namespace Front\Module\User\Controller;

use App\Mailer\Mailer;
use User\View\Mail;

class UserRecovery extends \Main\Controller\Main {
    use \User\Controller\Traits\UserRecovery {
        \User\Controller\Traits\UserRecovery::__construct as traitConstruct;
    }

    /**
     * Construct
     */
    public function __construct() {
        Mail::setMailHtmlCallable(function($html, Mail $view) {
            return \App\Mailer\View\Mail::buildHtml($html);
        });

        $this->traitConstruct();
    }

    /**
     * Get mailer used to send recovery related emails
     *
     * @return \M\Mail\Interfaces\Mailer
     */
    protected function _getMailer()
    {
        return Mailer::getMailer();
    }
}