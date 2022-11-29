<?php

namespace Main\View\Error;

class Error extends \M\View\View {
	
	/* -- REQUIRED -- */
	
	/**
	 * Construct
	 */
	public function __construct() {
		$this->_setTemplateFilepath('src/[app]/template/error/[name].[extension]');
	}
	
	/**
	 * Get required
	 * 
	 * @return array
	 */
	protected function _getRequired() {
		return [];
	}
}