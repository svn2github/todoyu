
/**
 *	Extend element prototype
 */
Element.addMethods({

	/**
	 * Replace a class name on an element
	 *
	 * @param	{Element}	element
	 * @param	{String}	className
	 * @param	{String}	replacement
	 */
	replaceClassName: function(element, className, replacement){
		if (!(element = $(element))) {return;}
		return element.removeClassName(className).addClassName(replacement);
	},



	/**
	 * Get class names of an element
	 *
	 * @param	{Element}	element
	 */
	getClassNames: function(element) {
		return $w(element.className);
	},



	/**
	 * Scroll to an element but consider the fixed header
	 *
	 * @param	{Element}	element
	 */
	scrollToElement: function(element) {
		Todoyu.Ui.scrollToElement(element);

		return element;
	}
});


/**
 * Extend ajax response prototype
 */
Ajax.Response.addMethods({
	/**
	 * Get todoyu style http headers (prefixed by 'Todoyu-')
	 *
	 * @param	{String}		name
	 */
	getTodoyuHeader: function(name) {
		var header = this.getHeader('Todoyu-' + name);

		return header === null ? header : header.isJSON() ? header.evalJSON() : header;
	},



	/**
	 * Check whether a todoyu header was sent
	 *
	 * @param	{String}
	 */
	hasTodoyuHeader: function(name) {
		return this.getTodoyuHeader(name) !== null;
	},



	/**
	 * Check whether todoyu error was sent
	 *
	 * @return	{Boolean}
	 */
	hasTodoyuError: function() {
		return this.getTodoyuHeader('error') == 1;
	},


	/**
	 * Get todoyu error message
	 *
	 * @return	{String}
	 */
	getTodoyuErrorMessage: function() {
		return this.getTodoyuHeader('errorMessage');
	},



	/**
	 * Check whether no access header was sent
	 *
	 * @return	{Boolean}
	 */
	hasNoAccess: function() {
		return this.getTodoyuHeader('noAccess') == 1;
	},



	/**
	 * Check whether notLoggedIn header was sent
	 *
	 * @return	{Boolean}
	 */
	isNotLoggedIn: function() {
		return this.getTodoyuHeader('notLoggedIn') == 1;
	},



	/**
	 * Check whether a php error header was sent
	 *
	 * @return	{Boolean}
	 */
	hasPhpError: function() {
		return this.getPhpError() !== null;
	},



	/**
	 * Get the php error header
	 *
	 * @return	{String}
	 */
	getPhpError: function() {
		return this.getTodoyuHeader('Php-Error');
	},



	/**
	 * Get number of AC result items
	 *
	 * @return	{Number}
	 */
	getNumAcElements: function() {
		return Todoyu.Helper.intval(this.getTodoyuHeader('acElements'));
	},



	/**
	 * Check whether the result is an empty autocompleter result
	 *
	 * @return	{Boolean}
	 */
	isEmptyAcResult: function() {
		return this.getNumAcElements() === 0;
	}
});


