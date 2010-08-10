// $Id: linkitDialog.js,v 1.2 2010/06/19 12:58:34 anon Exp $

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

    // If we have selected an element, grab that elemes attributes
    if(element) {
      // Set values from selection (not href)
      $('fieldset input[type=text]').each(function() {
        // element.getAttribute doent seems to like first arg to be empty.
        $(this).val(element.getAttribute($(this).attr('name')));
      });
      
      //href is set here
      if(element.getAttribute('href').length > 0) {
			  $('#edit-link').val(linkit_search_styled_link(element.getAttribute('href')));
			} else {
			  $('#edit-link').val(element.getAttribute('href'));
			}
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
   
    var params = { 'href' : href };
    
    $('fieldset fieldset input').each(function() {
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