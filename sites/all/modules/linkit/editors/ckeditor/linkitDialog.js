// $Id: linkitDialog.js,v 1.4.2.1 2010/10/22 23:26:57 anon Exp $

/**
 * @file Linkit ckeditor dialog helper
 */
var LinkitDialog = {
  init : function() {
    //Get CKEDITOR
    CKEDITOR = dialogArguments.opener.CKEDITOR;
    //Get the current instance name
    var name = dialogArguments.editorname;
    //Get the editor instance
    editor = CKEDITOR.instances[name];
    //Get the selected element
    var element = null;
    element = this._getSelection();
    var selection = editor.getSelection();

    // If we have selected an element, grab that elemes attributes
    if(element) {
      // Set values from selection (not href)
      $('fieldset input[type=text]').each(function() {
        // element.getAttribute doent seems to like first arg to be empty.
        $(this).val(element.getAttribute($(this).attr('name')));
      });
      // Anchor isnt really an attribute, and we have to find it in the URL to inster it into the textfield.
      $('#edit-anchor').val(linkit_helper.seek_for_anchor(element.getAttribute('href')));

      // href is set here
      if(element.getAttribute('href').length > 0) {
			  linkit_helper.search_styled_link(element.getAttribute('href'));
			} 
    } else if(selection.getNative().isCollapsed) {
      // Show help text when there is no selection element
      linkit_helper.show_no_selection_text();
    }
  },

  insertLink : function() {   
    // Get the params from the form
    var params = this._getParams();  
    
    //If no href, just colse this window
    if(params.href == "") {
      window.close();
    } 
    // Ok, we have a href, lets make a link of it and insert it
    else {      
      CKEDITOR.tools.callFunction(editor._.linkitFnNum, params, editor);   
      window.close();
    }
  },
  
  _getParams : function () {
    // Regexp to find the "path"
    var matches = $('#edit-link').val().match(/\[path:(.*)\]/i);
    href = (matches == null) ? $('#edit-link').val() : matches[1];
    
    // Add anchor if we have any and make sure there is no "#" before adding the anchor
    var anchor = $('#edit-anchor').val().replace(/#/g,'');
    if(anchor.length > 0) {
      href = href.concat('#' + anchor);
    }

    var link_text_matches = $('#edit-link').val().match(/(.*)\[path:.*\]/i);
    link_text = (link_text_matches == null) ? $('#edit-link').val() : link_text_matches[1].replace(/^\s+|\s+$/g, '');

    var params = { 'href' : href , 'link_text' : link_text };
    
    $("fieldset fieldset input[id!='edit-anchor']").each(function() {
      if($(this).val() != "") {
        params[$(this).attr('name')] = $(this).val();
      }
    });

    return params;
  },

  _getSelection : function () {
    selection = editor.getSelection();
    ranges = selection.getRanges();
    element = '';
    
    if (ranges.length == 1) {
      var rangeRoot = ranges[0].getCommonAncestor(true);
      element = rangeRoot.getAscendant('a', true);
    }

    return element;
  }
};

$(document).ready(function() {
  var CKEDITOR, editor;

  LinkitDialog.init();

  $('#edit-link').keydown(function(ev) {
    if (ev.keyCode == 13) {
      // Prevent browsers from firing the click event on the first submit
      // button when enter is used to select from the autocomplete list.
      return false;
    }
  });
  
  $('#edit-insert').click(function() {
    LinkitDialog.insertLink();
    return false;
  });

  $('#edit-cancel').click(function() {
    window.close();
    return false;
  });
});