<?php namespace App\Core\Ajax;

use \M\App\Response;

/**
 * Error
 *
 * A universal response for ajax errors
 *
 * @package App\Core\Ajax
 */
class Error extends Response
{
	/* -- CONSTRUCTOR -- */

	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param int $code
	 */
	public function __construct($message = null, $code = Response::STATUS_SERVER_ERROR)
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
			'success'   => false,
			'code'      => $this->getStatusCode(),
			'message'   => $this->getMessage(),
		]);
	}
}
