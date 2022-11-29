<?php
/* -- ERROR REPORTING -- */

use M\App\Autoloader;
use M\Controller\Dispatcher;
use M\Crypto\CurrentFieldEncrypter;
use M\Debug\Environment;
use M\Exception\RuntimeErrorException;
use M\Locale\Category;
use M\Locale\MessageCatalog;
use M\Locale\Strings;
use M\Server\Header;
use M\Server\Request;
use M\Session\Session;
use M\Uri\Uri;
use M\Uri\UriFactory;

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
// Do not show errors by default (on production environments)
ini_set('display_errors', 1);

/* -- TIMEZONE -- */

date_default_timezone_set('Europe/Brussels');

/* -- LOADER -- */

require_once __DIR__ . '/../vendor/autoload.php';

chdir('..');
require_once 'app/helpers.php';

$loader = Autoloader::getInstance();
$loader->register();
$loader->addNamespace('Config', '/Config');
$loader->addNamespace('App', '/lib/App');
//$loader->addNamespace('Image', '/vendor/multimedium/image/src/Image');

/* -- SESSION -- */

$session = Session::getInstance();
try {
    $session->start();
} catch (RuntimeErrorException $e) {
}

include 'env.php';

/* -- REDIRECT HTTPS -- */
/** @var Uri $uri */
$uri = Request::getUri();
if ($uri->getScheme() === 'http' && (!Environment::getConfig()->getShowDumps())) {
    $uri->setScheme('https');
    redirect($uri->toString());
}

/* -- LOCALE -- */

// We'll use Open SSL for encrypting / decrypting values
CurrentFieldEncrypter::getInstance()->setEncrypterClass(
    CurrentFieldEncrypter::OPEN_SSL
);

/* @var $dispatcher Dispatcher */

/* -- LOCALE -- */

MessageCatalog::setStorageAppId($dispatcher->getApp());

// Get installed locales:
$locales = MessageCatalog::getStorage()->getInstalledLocales();
$localeCount = count($locales);

// If more than one locale is available
if ($localeCount > 1) {
    // Enable locales in the application's paths:
    // (will prepend the locale name to the URL's)
    $dispatcher->setEnableLocale(true);

    // Get the default locale. The default locale is used to set the
    // Homepage URI:
    if (!Request::getUri()->getRelativePath()) {
        $locale = \M\Client\Locale::getLanguageDefaultAndSupported();
        UriFactory::setLinkPrefix($locale);
        M\Locale\Locale::setCategory(Category::LANG, $locale);
    }

    $relativePath = Request::getUri()->getRelativePath();
    if ($relativePath) {
        $relativePathElements = explode('/', $relativePath);
        if (count($relativePathElements) && !in_array(array_shift($relativePathElements), $locales)) {
            header("HTTP/1.1 301 Moved Permanently");
            Header::redirect('en/' . Request::getUri()->getRelativePath());
        }
    }

    // [20190923] Setting this priority using category LANGUAGE will make sure that
    // we will always get a translated property, if the current one is not available
    $localesByPriorityAsc = array_reverse($locales);
    M\Locale\Locale::setCategory(Category::LANGUAGE, implode(':', $localesByPriorityAsc));
} // If only one locale can be used in the app:
elseif ($localeCount === 1) {
    // Set the default locale:
    M\Locale\Locale::setCategory(Category::LANG, $locales[0]);
}

/* @var $strings Strings */
$strings = Strings::getInstance();
$strings->setLocaleOfUntranslatedMessages('en');


// Home page, depending on the active app
if (!$dispatcher->getPath()) {
    switch ($dispatcher->getApp()) {

        case 'Main':
            $dispatcher->setPath('user/login');
            break;
        case 'Front':
            $dispatcher->setPath('home');
            break;

    }
}

$dispatcher->dispatch();