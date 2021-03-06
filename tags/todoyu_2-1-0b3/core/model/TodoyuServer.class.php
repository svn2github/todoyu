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
 * Server informations
 *
 * @package		Todoyu
 * @subpackage	Core
 */
class TodoyuServer {

	/**
	 * Check wheter server OS is Linux
	 *
	 * @return	Boolean
	 */
	public static function isLinux() {
		return stripos(PHP_OS, 'Linux') !== false;
	}



	/**
	 * Check wheter server OS is Windows
	 *
	 * @return	Boolean
	 */
	public static function isWindows() {
		return stripos(PHP_OS, 'Win') !== false;
	}



	/**
	 * Get IP address of the server
	 *
	 * @return	String
	 */
	public static function getIP() {
		return $_SERVER['SERVER_ADDR'];
	}



	/**
	 * Get the (domain) name of the server
	 *
	 * @return	String
	 */
	public static function getDomain() {
		return $_SERVER['SERVER_NAME'];
	}



	/**
	 * Assert that the minimal requirements for todoyu are available
	 *
	 */
	public static function assertMinimalRequirements() {
		$loadedExtension	= get_loaded_extensions();
		$problems			= array();
		$requiredVersion	= '5.2.0';

			// Check php version
		if( version_compare(PHP_VERSION, $requiredVersion) === -1 ) {
			$problems[] = 'PHP version to low. You need at least ' . $requiredVersion . '. You only have ' . PHP_VERSION;
		}

			// Check required extensions for php
		$requiredExtensions	= array(
			'mbstring',
			'mysql',
			'mcrypt',
			'zip',
			'json',
			'pcre',
			'libxml',
			'SimpleXML',
			'gd'
		);

		foreach($requiredExtensions as $extension) {
			if( ! in_array($extension, $loadedExtension) ) {
				$problems[] = 'Required extension "' . $extension . '" is not installed';
			}
		}

			// Print error message of not all requiremens are met
		if( sizeof($problems) > 0 ) {
			header("Content-Type: text/plain;charset=utf-8");
			header('HTTP/1.0 503');

			echo "TODOYU ERROR\n\n";
			echo "The following minimum requirements are not met\n";
			echo "==============================================\n\n";

			foreach($problems as $problem) {
				echo ' - ' . $problem . "\n";
			}

			echo "\n\n";
			echo "todoyu doesn't run with this configuration.\n";
			echo "Please update your config or install todoyu on an other server";

				// Stop script here
			exit();
		}
	}


}

?>