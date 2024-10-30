var CCEReferrals = {

	creatives: null,

	randomize: function _randomize() {
		creatives = this.creatives;
		var count = 0;
		creatives.forEach( function(s) {
			count++;
		});
		var creativeHit = Math.floor((Math.random() * count));
		this.displayCreative(creatives[creativeHit]);
	},

	displayCreative: function _displayCreative(theCreative) {
		theHtml = '<p><a href="'+theCreative['ccew_link']+'" target="_blank">' + theCreative['ccew_title'] + '</a></p>';
		theHtml += '</p><a href="'+theCreative['ccew_link']+'" target="_blank">' + theCreative['ccew_image'] + '</a></p>';
		theHtml += '<p>' + theCreative['ccew_description'] + '</p>';
		jQuery( '#CCER_Widget' ).html( theHtml );
	},

	init: function _init( args ) {
		if (document.getElementById('CCER_Widget')) {
			this.creatives = JSON.parse(window.atob(args.creatives));
			this.randomize();
		}
	}
};
