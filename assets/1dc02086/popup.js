var app = app || {};
app.popup = (function($) {
    function Popup() {}
    
    Popup.prototype.html = '';
    
    Popup.prototype.getFromUrl = function(url) {
	var _this = this;
	$.getJSON(url, {}, function(d) {
	    if (!d.error) {
		_this.html = d.html;
	    }
	});
    };

    Popup.prototype.open = function(data, width, idSuffix) {
	var id = (!!idSuffix ? 'popup' : 'popup-'+idSuffix),
	    tpl = $('<div class="modal-window"></div>');
	tpl.attr('id', id).html(data).css({
	    width: width + 'px',
	    top: 200 + 'px',
	    left: '50%',
	    'margin-left': (-(width / 2))+'px',
	    'z-index': 101
	});
	$('#bg').show();
	$('body').append(tpl.clone());
    };

    Popup.prototype.close = function() {
	$('.modal-window').remove();
	$('#bg').hide();
    };

    return new Popup();
})(jQuery);