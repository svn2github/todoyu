Todoyu.Autocompleter = Class.create(Ajax.Autocompleter, {
	onComplete: function(response) {
			// If a custom onComplete defined
		if( this.options.onCompleteCustom ) {
			var funResult = Todoyu.callUserFunction(this.options.onCompleteCustom, window, response, this);
				// If the custom function returns an object, override response
			if( typeof(funResult) === 'object' ) {
				response = funResult;
			}
		}
		
		if( response.getTodoyuHeader('acElements') == 0 ) {
			this.onEmptyResult(response);
		}
		
			// Call default ac handler
		this.updateChoices(response.responseText);
	},
	
	onEmptyResult: function(response) {
		new Effect.Highlight(this.element, {
			'startcolor': '#ff0000',
			'endcolor': '#ffffff',
			'duration': 2.0
		});
		
		if( ! this.options.onCompleteCustom ) {
			Todoyu.notifyInfo('[LLL:form.ac.noResults]');
		}
	}
});