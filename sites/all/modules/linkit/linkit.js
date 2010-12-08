/* $Id: linkit.js,v 1.4.2.1 2010/10/22 22:52:21 anon Exp $ */

/*
 * Linkit javascript lib 
 */
var linkit_helper = {
  /*
   * Makes an AJAX requst when a link is about to be edited with Linkit
   */
  search_styled_link : function(string) {
    $('#edit-link-wrapper input').hide();
    $('#edit-link-wrapper label').after($('<span></span>').addClass('throbber').html('<strong>' + Drupal.t('Loading path...') + '</strong>'));
    // DO AJAX!
    var result = $.get(Drupal.settings.linkit.ajaxcall, { string: string } , function(data) {
      if(data) {
        $('#edit-link').val(data);
        $('#edit-link-wrapper .throbber').remove();
        $('#edit-link-wrapper input').show();
      } else {
        $('#edit-link').val(string);
        $('#edit-link-wrapper .throbber').remove();
        $('#edit-link-wrapper input').show();
      }
    });
  }, 

  /*
   * Show helper text
   * If there is no selection, the link text will be the result title.
   */
  show_no_selection_text : function() {
    var info_text = Drupal.t('<em class="notice">Notice: No selection element was found, your link text will appear as the item title you are linking to.</em>');
    $('#edit-link-wrapper').prepend(info_text);    
  },
  /*
   * IMCE integration
   */
  openFileBrowser : function () {
    window.open(Drupal.settings.basePath + 'imce?app=Linkit|url@edit-link', '', 'width=760,height=560,resizable=1');
  },
  
  /*
   * See if the link contains a #anchor
   */
  seek_for_anchor : function(href) {
    var matches = href.match(/internal:.*(#.*)/i);
    anchor = (matches == null) ? '' : matches[1].substring(1);
    return anchor;
  }
}

Drupal.behaviors.linkit_imce = function(context) {
  $('#linkit-imce').click(function() {
    linkit_helper.openFileBrowser();
    return false;
  });
}

