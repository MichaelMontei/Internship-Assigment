<?php namespace App\Core\Ajax;

use \M\App\Response;
use M\Time\Date;
use M\Util\Number;

/**
 * Data
 *
 * A universal response for sending data in response to an ajax request
 *
 * @package App\Core\Ajax
 */
class Data extends Response
{
    /* -- PROPERTIES -- */

	/**
     * Data array
	 *
	 * @var array
	 */
	private $data;

	/* -- CONSTRUCTOR -- */

	/**
	 * Data constructor.
	 *
	 * @param array $data
	 * @param int $code
	 */
	public function __construct(array $data = [], $code = Response::STATUS_OK)
    {
        $this->setFormat(static::FORMAT_JSON);
		$this->setStatusCode($code);
		$this->data = $data;
	}

	/* -- PUBLIC SCOPE -- */
	
	/**
	 * Get Response Data
	 * 
	 * @return array
	 */
	public function getData()
    {
		return $this->data;
	}

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
			'data'      => $this->getData(),
		]);
	}
	
	/**
	 * Get Number
	 * 
	 * Will provide an array for the provided number, containing the number
	 * itself and as a formatted string. Note that we run the provided
	 * number through {@link \M\Util\Number} to provide validation.
	 * 
	 * @param float $number
	 * @return array
	 */
	public static function getNumber($number)
    {
		// Construct the number
		$number = new Number($number);
		
		// Return an output array containing:
		return [
			// The number itself
			'number'    => $number->getNumber(),
			// And the number as formatted string
			'formatted' => $number->toString(),
        ];
	}
	
	/**
	 * Get Number As Currency
	 * 
	 * Will provide an array for the provided number, containing the number
	 * itself and a currency formatted string. Note that we run the provided
	 * number through {@link \M\Util\Number} to provide validation.
	 * 
	 * @param float $number
	 * @return array
	 */
	public static function getNumberAsCurrency($number)
    {
		// Construct the number
		$number = new Number($number);
		
		// Return an output array containing:
		return [
			// The number itself
			'number'    => $number->getNumber(),
			// And the number as currency formatted string
			'formatted' => $number->toCurrencyString('EUR'),
        ];
	}
	
	/**
	 * Get Number As Percent
	 * 
	 * Will provide an array for the provided number, containing the number
	 * itself and the same number formatted as percent. Note that we run the provided
	 * number through {@link \M\Util\Number} to provide validation.
	 * 
	 * @param float $number
	 * @return array
	 */
	public static function getNumberAsPercent($number)
    {
		// Construct the number
		$number = new Number($number);
		
		// Return an output array containing:
		return [
			// The number itself
			'number'    => $number->getNumber(),
			// And the number as a percent string
			'formatted' => $number->toPercentString(),
        ];
	}

	/**
	 * Get Date Formatted
	 *
	 * @param Date $date
	 * @return array
	 */
	public static function getDateFormatted(Date $date)
    {
		return [
			'iso8601'    => $date->getIso8601(),
			'formatted'  => $date->toString('dd/MM/yyyy'),
        ];
	}
}
