/****************************************************************************
* todoyu is published under the BSD License:
* http://www.opensource.org/licenses/bsd-license.php
*
* Copyright (c) 2010, snowflake productions GmbH, Switzerland
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
 * Todoyu main container. All other JS containers are (sub-)nodes
 * of this container
 */
var Todoyu = {

	name: 		'Todoyu',

	copyright: 	'snowflake productions GmbH, Zurich/Switzerland',
	
	logLevel:	0,

	/**
	 * Container for extensions
	 */
	Ext: 		{},


	/**
	 * Initialize todoyu object
	 */
	init: function() {
		this.AjaxResponders.init();
		this.Ui.fixAnchorPosition();
		this.Ui.observeBody();
		this.initExtensions();
	},



	/**
	 * Initialize all extensions
	 * Call the init() function of all extensions in their main container if it exists
	 */
	initExtensions: function() {
		$H(this.Ext).each(function(pair){
			if( typeof(pair.value.init) === 'function' ) {
				pair.value.init();
			}
		});
	},



	/**
	 * Build request url with extension and controller
	 *
	 * @param	{String}		ext
	 * @param	{String}		controller
	 */
	getUrl: function(ext, controller) {
		var url = 'index.php?ext=' + ext;

		if(controller)	{
			url = url + '&controller=' + controller;
		}

		return url;
	},



	/**
	 * Redirect to an onther page
	 *
	 * @param	{String}	ext
	 * @param	{String}	controller
	 * @param	{Hash}		params
	 * @param	{String}	hash
	 */
	goTo: function(ext, controller, params, hash) {
		var url =  this.getUrl(ext, controller);

		if( typeof params === 'object' ) {
			url += '&' + Object.toQueryString(params);
		}	

		if( Object.isString(hash) ) {
			this.goToHashURL(url, hash);
		} else {
			location.href = url;
		}
	},



	/**
	 * Go to an URL with a hash
	 * If the URL itself is identical, just scroll to the element
	 *
	 * @param	{String}	url
	 * @param	{String}	hash
	 */
	goToHashURL: function(url, hash) {
		var searchPart	= url.substr(url.indexOf('?'));
		
		if( location.search === searchPart && Todoyu.exists(hash) ) {
			if( $(hash).getHeight() > 0 ) {
				$(hash).scrollToElement();
				return;
			}			
		}

			// Fallback
		location.href =  url + '#' + hash;
	},



	/**
	 * Send AJAX request
	 *
	 * @param	{String}		url
	 * @param	{Hash}			options
	 */
	send: function(url, options) {
		options = Todoyu.Ui._getDefaultOptions(options);

		return new Ajax.Request(url, options);
	},



	/**
	 * Check if an element exists
	 *
	 * @param	{Element|String}		element		Element or its ID
	 */
	exists: function(element) {
		if( typeof element === 'object' ) {
			element = element.id;
		}

		return document.getElementById(element) !== null;
	},



	/**
	 * Get current area
	 */
	getArea: function() {
		return document.body.id.split('-').last();
	},
	
	

	/**
	 * Show error notification
	 * 
	 * @param	{String}		message
	 * @param	{Number}		countdown
	 */
	notifyError: function(message, countdown) {
		Todoyu.Notification.notifyError(message, countdown);
	},



	/**
	 * Show info notification
	 * 
	 * @param	{String}		message
	 * @param	{Number}		countdown
	 */
	notifyInfo: function(message, countdown) {
		Todoyu.Notification.notifyInfo(message, countdown);
	},



	/**
	 * Show success notification
	 * 
	 * @param	{String}		message
	 * @param	{Number}		countdown
	 */
	notifySuccess: function(message, countdown) {
		Todoyu.Notification.notifySuccess(message, countdown);
	},



	/**
	 * Call a user function in string format with given arguments
	 * @example	Todoyu.calluserFunction('Todoyu.notifySuccess', 'This is a message', 5);
	 * 
	 * @param	{String}		functionName
	 * @param	{String}		args
	 */
	callUserFunction: function(functionName /*, args */) {
		var args 	= $A(arguments).slice(1);
		var func	= this.getFunctionFromString(functionName);
		var context	= this.getFunctionFromString(functionName.split('.').slice(0,-1).join('.'));

		return func.apply(context, args);
	},



	/**
	 * Call a function reference, if it's one. Otherwise just ignore the call
	 * The first argument is the function, all other arguments will be handed down to this function
	 * The debug output is just for deveopment
	 * 
	 * @param	{Function}	functionReference	Function
	 * @param	{Object}		context				Context which is this in function
	 */
	callIfExists: function(functionReference, context /*, args */) {
		var args = $A(arguments).slice(2);
		
		if( typeof functionReference === 'function' ) {
			functionReference.apply(context, args);
		} else {
			//Todoyu.log('Todoyu.callIfExists() was executed with a non-function. This can be an error (not sure). Params: ' + Object.inspect(args), 1);
		}
	},



	/**
	 * Get a function reference from a function string
	 * Ex: 'Todoyu.Ext.project.edit'
	 * 
	 * @param	{String}		functionName
	 */
	getFunctionFromString: function(functionName, bind) {
		var namespaces 	= functionName.split(".");
		var func 		= namespaces.pop();
		var context		= window;
		
		for(var i = 0; i < namespaces.length; i++) {
			context = context[namespaces[i]];
			
			if( context === undefined ) {
				alert("Function: " + functionName + " not found!");
			}
		}

		var funcRef = context[func];

		if( bind ) {
			funcRef = funcRef.bind(context);
		}

		return funcRef;
	},



	/**
	 * Todoyu log. Check level and if console exists
	 * 
	 * @param	{Object}		element
	 * @param	{Number}		level
	 * @param	{String}		title
	 */
	log: function(element, level, title) {
		if( level === undefined || (Object.isNumber(level) && level >= this.logLevel) ) {
			if( window.console !== undefined ) {
				if( title !== undefined ) {
					window.console.log('Log: ' + title);
				}
				window.console.log(element);
			}
		}
	}
};