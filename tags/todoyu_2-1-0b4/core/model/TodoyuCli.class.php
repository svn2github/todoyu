<?php
/****************************************************************************
* todoyu is published under the BSD License:
* http://www.opensource.org/licenses/bsd-license.php
*
* Copyright (c) 2011, snowflake productions GmbH, Switzerland
* All rights reserved.
*
* This script is part of the todoyu project.
* The todoyu project is free software; you can redistribute it and/or modify
* it under the terms of the BSD License.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the BSD License
* for more details.
*
* This copyright notice MUST APPEAR in all copies of the script.
*****************************************************************************/

/**
 * Command line interface
 *
 * @package		Todoyu
 * @subpackage	Core
 */
class TodoyuCli {

	/**
	 * Variables which are set in a HTTP request
	 * Check them to prevent calls over HTTP in browser
	 *
	 * @var	Array
	 */
	private static $httpVars = array(
		'HTTP_USER_AGENT',
		'HTTP_HOST',
		'SERVER_NAME',
		'REMOTE_ADDR',
		'REMOTE_PORT',
		'SERVER_PROTOCOL'
	);



	/**
	 * Change current work directory to main directory to prevent path problems
	 */
	public static function init() {
		chdir(PATH);

			// Predefine URL constants
		if( ! defined('SERVER_URL') ) {
			$url	= parse_url('http://' . str_replace('http://', '', Todoyu::$CONFIG['SYSTEM']['todoyuURL']));

			define('PATH_WEB_OVERRIDE', $url['path']);

			define('SERVER_URL', 'http://' . $url['host']);

			define('TODOYU_URL', SERVER_URL . $url['path']);
		}
	}



	/**
	 * Check whether the current request is an HTTP request
	 *
	 * @return	Boolean
	 */
	public static function isHttpCall() {
		foreach(self::$httpVars as $httpVarKey) {
			if( array_key_exists($httpVarKey, $_SERVER) ) {
				return true;
			}
		}

		return false;
	}



	/**
	 * Assert the current request is a shell request (not HTTP)
	 *
	 */
	public static function assertShell() {
		if( self::isHttpCall() ) {
			die("Executing this script in the browser is not allowed! Cronjob or command line are required\n");
		}
	}



	/**
	 * Set CLI mode constant
	 *
	 */
	public static function setCliMode() {
		if( ! defined('TODOYU_CLI') ) {
			define('TODOYU_CLI', true);
		}
	}



	/**
	 * Check whether mode is CLI
	 *
	 * @return	Boolean
	 */
	public static function isCliMode() {
		return TODOYU_CLI === true;
	}

}

?>