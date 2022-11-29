<?php namespace App\Env;

use M\Exception\RuntimeErrorException;
use M\Session\Ns;

/**
 * App
 *
 * Singleton representing the app as a whole, centralizing functionality that
 * is unique to a request.
 *
 * @author Tim
 */
class App
{
    /* -- PROPERTIES -- */

    /**
     * Is CRUD mode enabled or disabled?
     *
     * @var bool
     */
    private $crud;

    /**
     * Active session namespace
     *
     * @var Ns
     */
    private $ns;

    /**
     * Singleton instance
     *
     * @var App
     */
    private static $instance;

    /* -- INITIALIZATION -- */

    /**
     * Get the active singleton instance
     *
     * @return App
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            // Construct a new instance
            static::$instance = new static;

            // Load the session
            static::$instance->ns = new Ns('app', TRUE);
        }

        return static::$instance;
    }

    /* -- PUBLIC SCOPE -- */

    /**
     * Are CRUD operations allowed?
     *
     * NOTE: we only use CRUD for create, update and delete. Read access is
     * a separate resource for now.
     *
     * @return bool
     */
    public function isCrudAllowed(): bool
    {
        // Cache
        if (!is_null($this->crud)) {
            return $this->crud;
        }

        // For now, no additional logic tied to the user, the app or any active
        // state exists. As such, crud is allowed!
        $this->crud = true;
        return true;
    }

    /**
     * Get the current active app
     *
     * @return string
     * @throws \M\Exception\RuntimeErrorException
     */
    public function app()
    {
        return strtolower(\M\Controller\Dispatcher::getInstance()->getApp());
    }

    /**
     * Return the base resource path
     *
     * @return string
     */
    public function resourceBasepath()
    {
        return 'src/' . $this->app();
    }

    /**
     * Theme path
     *
     * @param null $path
     * @return string
     */
    public function resourcePath($path = null)
    {
        $output = $this->resourceBasepath();

        if ($path) {
            $output .= '/' . trim($path, '\/');
        }

        return $output;
    }

    /**
     * Get the correct Css link for this host
     */
    public function getRevPath($location, $name)
    {
        // We need to get the absolute location of the manifest
        $manifestPath = (new \M\Fs\Local\Directory('public/' . $this->resourcePath( '/rev-manifest.json')))->getPath();

        if (is_file($manifestPath)) {
            $manifest = json_decode(
                file_get_contents($manifestPath),
                true
            );
        }

        // Return versioned file
        if (!isset($manifest[$location . '/' . $name])) {
            throw new RuntimeErrorException('Could not find build file for application.css');
        }

        return href($this->resourcePath( $manifest[$location . '/' . $name]), false);
    }

    /* -- PRIVATE / PROTECTED SCOPE -- */

    /**
     * Constructor
     */
    private
    function __construct()
    {
    }
}