<?php

namespace opensrs\domains\cookie;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class CookieUpdate extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct( $formatString, $dataObject ) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject() {
		if( !isset($this->_dataObject->data->reg_username ) ) {
			throw new Exception( "oSRS Error - reg_username is not defined." );
		}

		if( !isset($this->_dataObject->data->reg_password ) ) {
			throw new Exception( "oSRS Error - reg_password is not defined." );
		}

		if( !isset($this->_dataObject->data->domain ) ) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}

		if( !isset($this->_dataObject->data->domain_new ) ) {
			throw new Exception( "oSRS Error - domain_new is not defined." );
		}

		if( !isset($this->_dataObject->data->cookie ) ) {
			throw new Exception( "oSRS Error - cookie is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			"protocol" => "XCP",
			"action" => "update",
			"object" => "cookie",
			"cookie" => $this->_dataObject->data->cookie,
			"attributes" => array(
				"reg_username" => $this->_dataObject->data->reg_username,
				"reg_password" => $this->_dataObject->data->reg_password,
				"domain" => $this->_dataObject->data->domain,
				'domain_new' => $this->_dataObject->data->domain_new
			)
		);

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode( $cmd );
		// Send XML
		$XMLresult = $this->send_cmd( $xmlCMD );
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode( $XMLresult );

		// Results
		$this->resultFullRaw = $arrayResult;
		if( isset($arrayResult['attributes'] ) ) {
			$this->resultRaw = $arrayResult['attributes'];
		} else {
			$this->resultRaw = $arrayResult;
		}

		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}
}
