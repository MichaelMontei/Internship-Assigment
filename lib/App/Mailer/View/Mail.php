<?php namespace App\Mailer\View;

use M\Html\CssToInline;
use M\View\View;
use App\Mailer\Parser\InkyParser;

/**
 * Class Mail
 *
 * @package App\Mailer\View
 */
abstract class Mail extends View
{
    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->_setVariable('title', $title);
        return $this;
    }

	/**
	 * Get HTML
	 *
	 * @return string
	 */
	public function getHtml()
    {
		return static::buildHtml(parent::getHtml());
	}

    /**
     * @param $html
     * @return string
     */
	public static function buildHtml($html) {
        $html = (new InkyParser($html))->parse();

        // Apply mail css
        $css = file_get_contents('public/src/shared/dist/mail.css');

        $styler = new CssToInline($html, $css);
        return $styler->convert();
    }
}
