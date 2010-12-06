/* $Id: linkit.js,v 1.1 2010/06/19 12:58:34 anon Exp $ */

/*
 * Linkit javascript lib 
 */

/*
 * Makes an AJAX requst when a link is about to be edited with Linkit
 */
function linkit_search_styled_link(string) {
	if(string.length < 1 ) {
		return false;
	}
  $('#edit-link-wrapper input').hide();
  $('#edit-link-wrapper label').after($('<span></span>').addClass('throbber').html('<strong>' + Drupal.t('Loading path...') + '</strong>'));
	// DO AJAX!
  var result = $.get(Drupal.settings.linkit.ajaxcall, { string: string } , function(data) {
    if(data) {
      $('#edit-link').val(data);
      $('#edit-link-wrapper .throbber').remove();
      $('#edit-link-wrapper input').show();
    } 
  });

}