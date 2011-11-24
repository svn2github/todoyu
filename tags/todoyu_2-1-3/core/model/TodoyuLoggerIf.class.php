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
 * Interface for logger classes
 *
 * @package		Todoyu
 * @subpackage	Core
 */
interface TodoyuLoggerIf {

	/**
	 * Initialize logger with config
	 *
	 * @param	Array		$config
	 */
	public function __construct(array $config);



	/**
	 * Log a message with the logger
	 *
	 * @param	String		$message
	 * @param	Integer		$level
	 * @param	Mixed		$data
	 * @param	String		$info
	 * @param	String		$requestKey
	 */
	public function log($message, $level, $data, $info, $requestKey);

}

?>