<?php namespace App\Mailer\Parser;

use App\Mailer\Parser\Inky\Inky;

/**
 * InkyParser
 *
 * Parses inky syntax to HTML + add CSS to inline styles
 */
class InkyParser
{
    /* -- PROPERTIES -- */

    /**
     * @var string
     */
    private $html;


    /* -- CONSTRUCTOR -- */

    /**
     * InkyParser constructor.
     *
     * @param $html
     */
    public function __construct($html)
    {
        $this->html = $html;
    }


    /* -- PUBLIC -- */

    /**
     * @return string
     */
    public function parse() {
        // Convert Inky to HTML
        return (new Inky())->releaseTheKraken($this->html);

//        // CSS to inline styles
//        $emogrifier = new Emogrifier($html);
//        $emogrifier->disableInvisibleNodeRemoval();
//        $emogrifier->disableInlineStyleAttributesParsing();
//
//        $filesystem = new Filesystem(new Local(public_path()));
//
//        $emogrifier->setCss($filesystem->read(get_theme_asset('css', 'mail.css')));
//
//        return $emogrifier->emogrify();
    }
}
