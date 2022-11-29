<?php namespace App\Core\Ajax;

use \M\App\Response;

/**
 * Success
 *
 * A universal response for ajax success without data
 *
 * @package App\Core\Ajax
 */
class Success extends Response
{
	/* -- CONSTRUCTOR -- */
	
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param int $code
	 */
	public function __construct($message = null, $code = Response::STATUS_OK)
    {
        $this->setFormat(static::FORMAT_JSON);
		$this->setStatusCode($code);
		$this->setMessage($message);
	}

	/* -- PUBLIC SCOPE -- */
	
	/**
	 * Fetch
	 * 
	 * @return string
	 */
	public function fetch()
    {
        return $this->_getFromArray([
            'success'   => true,
            'code'      => $this->getStatusCode(),
            'message'   => $this->getMessage(),
        ]);
	}
}
