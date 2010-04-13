<?php
/****************************************************************************
* todoyu is published under the BSD License:
* http://www.opensource.org/licenses/bsd-license.php
*
* Copyright (c) 2010, snowflake productions gmbh
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
 * Main file for todoyu installer
 *
 * @package		Todoyu
 * @subpackage	Installer
 */

 	// Change current work directory to main directory to prevent path problems
chdir( dirname(dirname(__FILE__)) );

	// Load normal global.php file
require_once('core/inc/global.php');
	// Load installer config
include_once('install/config/steps.php');
include_once('install/config/config.php');


	// Check if _ENABLE file is available (installer has finished). Redirect to login
if( ! TodoyuInstaller::isEnabled() ) {
	TodoyuInstallerManager::finishInstallerAndJumpToLogin();
	exit();
}

	// Make sure the user is logged out
TodoyuSession::remove('person');
unset($_COOKIE['todoyulogin']);
TodoyuCookieLogin::removeRemainLoginCookie();

	// Deactive extensions during installation
Todoyu::$CONFIG['WITHOUT_EXTENSIONS'] 	= true;
Todoyu::$CONFIG['NO_INIT'] 				= true;

	// Load default init script
require_once('core/inc/init.php');

	// Run the installer
TodoyuInstaller::run();

?>