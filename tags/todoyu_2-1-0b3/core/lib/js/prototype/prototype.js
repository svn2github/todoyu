
/**
 *	Extend prototype
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
	 * Scroll to an element but consider the fixed header
	 *
	 * @param	{Element}	element
	 */
	scrollToElement: function(element) {
		Todoyu.Ui.scrollToElement(element);

		return element;
	}
});



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
	 */
	hasTodoyuError: function() {
		return this.getTodoyuHeader('error') == 1;
	},



	/**
	 * Check whether no access header was sent
	 */
	hasNoAccess: function() {
		return this.getTodoyuHeader('noAccess') == 1;
	},



	/**
	 * Check whether notLoggedIn header was sent
	 */
	isNotLoggedIn: function() {
		return this.getTodoyuHeader('notLoggedIn') == 1;
	},



	/**
	 * Check whether a php error header was sent
	 */
	hasPhpError: function() {
		return this.getPhpError() !== null;
	},



	/**
	 * Get the php error header
	 */
	getPhpError: function() {
		return this.getTodoyuHeader('Php-Error');
	},



	/**
	 * Get number of AC result items
	 */
	getNumAcElements: function() {
		return Todoyu.Helper.intval(this.getTodoyuHeader('acElements'));
	},



	/**
	 * Check whether the result is an empty autocompleter result
	 */
	isEmptyAcResult: function() {
		return this.getNumAcElements() === 0;
	}
});


/*
 * Orginal: http://adomas.org/javascript-mouse-wheel/
 * prototype extension by "Frank Monnerjahn" <themonnie@gmail.com>
 */
Object.extend(Event, {
	wheel: function (event){
		var delta = 0;
		if (!event) {
			event = window.event;
		}
		if( event.wheelDelta ) {
			delta = event.wheelDelta/120;
			if( window.opera ) {
				delta = -delta;
			}
		} else if (event.detail) { delta = -event.detail/3;	}
		return Math.round(delta); //Safari Round
	}
});
/*
 * enf of extension
 */



/**
 * Add round with precision parameter to number type
 */
Object.extend(Number.prototype, {
	round: function(precision) {
		var factor	= Math.pow(10, precision || 0);
		return Math.round(factor * this)/factor;
	}
});