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

$CONFIG['LOG'] = array(
	'active'	=> array('FILE', 'DB', 'FIREBUG'),
	'level'		=> 0,
	'MODES'		=> array()
);

$CONFIG['LOG']['MODES']['DB'] = array(
	'funcRef'	=> 'TodoyuLoggerDb::log',
	'table'		=> 'log'
);

$CONFIG['LOG']['MODES']['FILE'] = array(
	'funcRef'	=> 'TodoyuLoggerFile::log',
	'file'		=> PATH_CACHE . '/log/todoyu.log'
);

$CONFIG['LOG']['MODES']['FIREBUG'] = array(
	'funcRef'	=> 'TodoyuLoggerFirePhp::log'
);

?>