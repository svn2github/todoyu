/****************************************************************************
 * todoyu is published under the BSD License:
 * http://www.opensource.org/licenses/bsd-license.php
 *
 * Copyright (c) 2012, snowflake productions GmbH, Switzerland
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
 * @module	Core
 */

/**
 * JS - validation for form-elements
 *
 * @class		FormValidator
 * @namespace	Todoyu
 */
Todoyu.FormValidator = {

	/**
	 *
	 */
	validators: {},



	/**
	 *
	 */
	form: Todoyu.Form,



	 /**
	 *
	 * @param	{String}		fieldID
	 */
	initField: function(fieldID) {
		if($(fieldID)) {
			this.initValidators(fieldID);
			this.initObserver(fieldID);
		}
	},



	/**
	 *
	 */
	addValidator: function(fieldID, validatorMethod) {
		this.validators[fieldID].validatorMethods.push(validatorMethod);
	},



	/**
	 *
	 */
	validate: function(fieldID) {
		this.validators[fieldID].hasError = false;
		this.validators[fieldID].validatorMethods.each(function(element) {
			this[element](fieldID);
		}.bind(this));
	},



	/**
	 *
	 *
	 * @param	{String}		fieldID
	 */
	initValidators:function (fieldID) {
		if ( !this.validators[fieldID] ) {
			this.validators[fieldID] = {
				validatorMethods: [],
				observer: null,
				hasError: false,
				msg: ''
			}
		}
	},



	/**
	 * Stop all validation events of object
	 *
	 * @param	{String}		fieldID
	 */
	initObserver: function(fieldID) {
		if( this.validators[fieldID].observer !== null) {
			this.validators[fieldID].observer.stop();
		}

		this.validators[fieldID].observer = $(fieldID).on('change', this.validate.bind(this, fieldID));
	},



	/**
	 *
	 * @param fieldID
	 */
	isNumeric: function(fieldID) {
		var value = $(fieldID).getValue();

		var error = this.getError(fieldID, !Todoyu.Number.isNumeric(value));

		this.form.setFieldErrorStatus($(fieldID), error);

		if( error ) {
			this.addWarningMessage(fieldID, '[LLL:core.form.field.hasError]');
		}
	},



	/**
	 *
	 * @param	{String}		fieldID
	 */
	isNotZero: function(fieldID) {
		var error = this.getError(fieldID, !(Todoyu.Number.intval($(fieldID).getValue()) > 0));

		this.form.setFieldErrorStatus($(fieldID), error);

		if( error ) {
			this.addErrorMessage(fieldID, '[LLL:core.form.field.hasError]');
		}
	},



	/**
	 *
	 * @param	{String}		fieldID
	 * @param	{Boolean}		errorFromValidation
	 */
	getError: function(fieldID, errorFromValidation) {
		var error = this.validators[fieldID].hasError;

		error = error || errorFromValidation;

		this.validators[fieldID].hasError = error;

		return error;
	},



	/**
	 *
	 * @param	{String}		fieldID
	 * @param	{String}		msg
	 */
	addErrorMessage: function(fieldID, msg) {
		this.addMessageElement(fieldID, 'errorMessage', msg);
	},



	/**
	 *
	 * @param	{String}		fieldID
	 * @param	{String}		msg
	 */
	addWarningMessage: function(fieldID, msg) {
		this.addMessageElement(fieldID, 'warningMessage', msg);
	},



	/**
	 * Add Html element containing the error/warning Message
	 *
	 * @param	{String}		fieldID
	 * @param	{String}	htmlClassName
	 * @param	{msg}
	 */
	addMessageElement: function(fieldID, htmlClassName, msg) {
		var errorElement = $(fieldID).up('.fElement').down('.'+htmlClassName);

		if( errorElement ) {
			errorElement.remove();
		}

		var element = new Element('div');
		element.addClassName(htmlClassName);
		element.innerHTML = msg;

		$(fieldID).up('.fElement').down('.clear').insert({before: element});
	}
};