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
 * General AJAX helper functions
 * @namespace	Todoyu.Ajax
 */
Todoyu.Ajax = {

	/**
	 * Check if a no access header has been sent.
	 * Cancel execution and show error message if so
	 *
	 * @function	checkNoAccessHeader
	 * @param		{Ajax.Response}		response
	 */
	checkNoAccessHeader: function(response) {
		if( response.hasNoAccess() ) {
				// Delete onComplete handler to prevent processing an empty response
			delete response.request.options.onComplete;
			var missingRight = response.getTodoyuHeader('noAccess-right');
			Todoyu.notifyError('[LLL:core.noAccess.errorMessage] (' + missingRight + ')');
		}
	},



	/**
	 * Check whether not logged in header was sent
	 *
	 * @param	{Ajax.Response}		response
	 */
	checkNotLoggedInHeader: function(response) {
		if( response.isNotLoggedIn() ) {
				// Delete onComplete handler to prevent processing an empty response
			delete response.request.options.onComplete;
			Todoyu.notifyError('[LLL:core.notLoggedIn.errorMessage]', 0);
		}
	},



	/**
	 * Check if a php error header has been sent
	 * Cancel execution and show error message if so
	 *
	 * @function	checkPhpErrorHeader
	 * @param		{Ajax.Response}		response
	 */
	checkPhpErrorHeader: function(response) {
		if( response.hasPhpError() ) {
			delete response.request.options.onComplete;
			Todoyu.notifyError(response.getPhpError(), 0);
			Todoyu.log(response.getPhpError());
		}
	}

};