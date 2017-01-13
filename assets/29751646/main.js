'use strict';
$(function() {
    var menuTO = {};

    $('#top-menu .root > li').hover(function() {
	if ($(this).find('.sub').get().length == 0)
	    return;
	var id = $(this).find('a:first').html();
	clearTimeout(menuTO[id]);
	$(this).find('.sub').slideDown(200);
    }, function() {
	if ($(this).find('.sub').get().length == 0)
	    return;
	var id = $(this).find('a:first').html(),
		_this = $(this);
	menuTO[id] = setTimeout(function() {
	    _this.find('.sub').slideUp(200);
	}, 400);
    });
});