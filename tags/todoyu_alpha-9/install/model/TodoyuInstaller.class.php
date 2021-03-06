<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 snowflake productions gmbh
*  All rights reserved
*
*  This script is part of the todoyu project.
*  The todoyu project is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License, version 2,
*  (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html) as published by
*  the Free Software Foundation;
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Installer
 *
 * @package		Todoyu
 * @subpackage	Installer
 */
class TodoyuInstaller {

	/**
	 * Available steps
	 *
	 * @var	Array
	 */
	private static $steps = array('welcome', 'servercheck', 'dbconnection', 'importstatic', 'config', 'setadminpassword', 'finish');

	/**
	 * Get current step
	 *
	 * @return	Integer
	 */
	public static function getStep() {
		return intval($_SESSION['todoyuinstaller']['step']);
	}



	/**
	 * Set current step
	 *
	 * @param	Integer		$step
	 */
	public static function setStep($step) {
		$_SESSION['todoyuinstaller']['step'] = intval($step);
	}



	/**
	 * Display output for current step
	 *
	 */
	public static function displayStep() {
		$stepNr	= self::getStep();
		$step	= self::$steps[$stepNr];

		switch($step) {
			case 'welcome';
				self::displayWelcome();
				break;

			case 'servercheck':
				self::displayServercheck();
				break;

			case 'dbconnection':
				self::displayDbConnection();
				break;

			case 'importstatic':
				self::displayImportStatic();
				break;

			case 'config':
				self::displayConfig();
				break;

			case 'setadminpassword':
				self::displayAdminPassword();
				break;

			case 'finish':
				self::displayFinish();
				break;
		}

	}



	/**
	 * Process current step data
	 *
	 * @param	Array		$data
	 */
	public static function processStep($data) {
		$cmd	= $data['command'];

		switch($cmd) {
			case 'start':
				self::setStep(1);
				break;

			case 'servercheck':
				self::setStep(2);
				break;

			case 'dbconnection':
				$_SESSION['todoyuinstaller']['db'] = $data;
				try {
					self::checkDbConnection($data);
					self::setStep(3);
					self::saveDbConfigInFile();
				} catch(Exception $e) {
				}
				break;

			case 'importstatic':
				self::importStaticData();
				self::setStep(4);
				break;

			case 'config':
				self::updateConfig($data);
				self::setStep(5);
				break;

			case 'setadminpassword':
				self::updateAdminPassword($data['password']);
				self::setStep(6);
				break;

			case 'finish':
				self::finish();
				self::setStep(0);
				break;
		}

	}



	/**
	 * Save database configuration file with submitted data
	 *
	 */
	private static function saveDbConfigInFile() {
		$data	= array(
			'db'	=> $_SESSION['todoyuinstaller']['db']
		);
		$tmpl	= 'install/view/db.php.tmpl';

		$config	= render($tmpl, $data);
		$code	= '<?php' . $config . '?>';
		$file	= PATH . '/config/db.php';

		file_put_contents($file, $code);
	}



	/**
	 * Check if database connection data is valid
	 *
	 * @param	Array		$data
	 * @return	Bool
	 * @throws	Exception
	 */
	private static function checkDbConnection($data) {
		$conn	= @mysql_connect($data['server'], $data['username'], $data['password']);

		if( $conn === false ) {
			throw new Exception('Cannot connect to the database server "' . $data['server'] . '"');
		}

		$db = mysql_select_db($data['database'], $conn);

		if( $db === false ) {
			throw new Exception('Cannot select database "' . $data['database'] . '"');
		}

		return true;
	}



	/**
	 * Import static data sql files
	 *
	 */
	private static function importStaticData() {
			// Structure
		$fileStructure	= PATH . '/install/db/db_structure.sql';
		$structure		= file_get_contents($fileStructure);
		$structureParts	= explode(';', $structure);

		foreach($structureParts as $structurePart) {
			if( trim($structurePart) !== '' ) {
				Todoyu::db()->query($structurePart);
			}
		}

			// Data
		$fileData		= PATH . '/install/db/db_data.sql';
		$data			= file_get_contents($fileData);
//		$splitPattern	= "/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*[^'|^\\\']$)/";
//		$dataParts		= preg_split($splitPattern, $data);
		$dataParts		= explode(';', $data);

		// preg_split causes fatal error on windows systems. Bug?

		foreach($dataParts as $dataPart) {
			if( trim($dataPart) !== '' ) {
				Todoyu::db()->query($dataPart);
			}
		}
	}


	private static function updateConfig($data) {
		$data	= array(
			'config'		=> $data,
			'encryptionKey'	=> self::makeEncryptionKey()
		);
		$tmpl	= 'install/view/system.php.tmpl';

		$config	= render($tmpl, $data);
		$code	= '<?php' . $config . '?>';
		$file	= PATH . '/config/system.php';

		file_put_contents($file, $code);
	}



	/**
	 * Generate
	 *
	 * @return	String
	 */
	private static function makeEncryptionKey() {
		return str_replace('=', '', base64_encode(md5(NOW . serialize($_SERVER) . session_id() . rand(1000, 30000))));
	}


	/**
	 * Update the admin password
	 *
	 * @param	String		$newPassword
	 */
	private static function updateAdminPassword($newPassword) {
		$pass	= md5($newPassword);
		$table	= 'ext_user_user';
		$where	= 'username = \'admin\'';
		$fields	= array(
			'password'	=> $pass
		);
		Todoyu::db()->doUpdate($table, $where, $fields);
	}



	/**
	 * Finish installer steps
	 * Rename ENABLE file to disable the installer
	 *
	 */
	private static function finish() {
		$old	= PATH . '/install/ENABLE';
		$new	= PATH . '/install/_ENABLE';

		rename($old, $new);

		self::setStep(0);

		header("Location: " . dirname(SERVER_URL));
		exit();
	}



	/**
	 * Display welcome screen
	 *
	 */
	private static function displayWelcome() {
		$data	= array(
			'title'	=> 'Welcome to the Todoyu installer',
			'text'	=> 'This installer checks the server compatibility, sets up the database connection, imports static data, sets a new admin password and disables the installer when finished'
		);
		$tmpl	= 'install/view/welcome.tmpl';

		echo render($tmpl, $data);
	}



	/**
	 * Display server check screen
	 *
	 */
	private static function displayServercheck() {
		$next			= true;

		if( version_compare(PHP_VERSION, '5.2.0', '>=') ) {
			$versionStatus	= 'OK';
		} else {
			$versionStatus	= 'PROBLEM';
			$next			= false;
		}

		$writable		= array('files', 'config', 'config/db.php');
		$writableStatus	= array();

		foreach($writable as $path) {
			$writableStatus[$path]	= is_writable(PATH . '/' . $path);

			if( $writableStatus[$path] === false ) {
				$next = false;
			}
		}

		$data	= array(
			'title'		=> 'Server check',
			'phpversion'=> $versionStatus . ' (Your version: ' . PHP_VERSION . ')',
			'writable'	=> $writableStatus,
			'next'		=> $next
		);
		$tmpl	= 'install/view/servercheck.tmpl';

		echo render($tmpl, $data);
	}



	/**
	 * Display database connection screen
	 *
	 */
	private static function displayDbConnection() {
		$dbData	= $_SESSION['todoyuinstaller']['db'];

		$data	= array(
			'title'		=> 'Setup Database Connection',
			'fields'	=> $dbData
		);

		if( is_array($dbData) ) {
			try {
				self::checkDbConnection($dbData);
			} catch(Exception $e) {
				$data['text'] = 'Error: ' . $e->getMessage();
			}
		}

		$tmpl	= 'install/view/dbconnection.tmpl';

		echo render($tmpl, $data);
	}



	/**
	 * Display import static screen
	 *
	 */
	private static function displayImportStatic() {
		$data	= array(
			'title'	=> 'Import static data'
		);
		$tmpl	= 'install/view/importstatic.tmpl';

		echo render($tmpl, $data);
	}


	private static function displayConfig() {
		$data	= array(
			'title'	=> 'System config'
		);
		$tmpl	= 'install/view/config.tmpl';

		echo render($tmpl, $data);
	}



	/**
	 * Display admin password change screen
	 *
	 */
	private static function displayAdminPassword() {
		$data	= array(
			'title'	=> 'Change admin password',
		);
		$tmpl	= 'install/view/adminpassword.tmpl';

		echo render($tmpl, $data);
	}



	/**
	 * Display finishing screen
	 *
	 */
	private static function displayFinish() {
		$data	= array(
			'title'	=> 'Installation finished',
		);
		$tmpl	= 'install/view/finish.tmpl';

		echo render($tmpl, $data);
	}

}


?>