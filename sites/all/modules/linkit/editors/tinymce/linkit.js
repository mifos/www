// $Id: linkit.js,v 1.6.2.1 2010/10/22 22:52:21 anon Exp $

var LinkitDialog = {
	init : function() {
		var ed = tinyMCEPopup.editor;
		// Setup browse button
		if (e = ed.dom.getParent(ed.selection.getNode(), 'A')) {
      if($(e).attr('href').length > 0) {
			 linkit_helper.search_styled_link($(e).attr('href'));
			} 
      $('#edit-title').val($(e).attr('title'));
      $('#edit-id').val($(e).attr('id'));
      $('#edit-class').val($(e).attr('class'));
      $('#edit-rel').val($(e).attr('rel'));
      $('#edit-accesskey').val($(e).attr('accesskey'));
      $('#edit-anchor').val(linkit_helper.seek_for_anchor($(e).attr('href')));
      return false;
		} else if(ed.selection.isCollapsed()) {
      // Show help text when there is no selection element
      linkit_helper.show_no_selection_text();
    }
    
	},
  
  insertLink : function() {
    var ed = tinyMCEPopup.editor, e;

    tinyMCEPopup.restoreSelection();
		e = ed.dom.getParent(ed.selection.getNode(), 'A');
    
    // Remove element if there is no href
		if ($('#edit-link').val() == "") {
			if (e) {
				tinyMCEPopup.execCommand("mceBeginUndoLevel");
				ed.dom.remove(e, 1);
				tinyMCEPopup.execCommand("mceEndUndoLevel");
				tinyMCEPopup.close();
				return;
			}
		}
    
    tinyMCEPopup.execCommand("mceBeginUndoLevel");
		
    var matches = $('#edit-link').val().match(/\[path:(.*)\]/i);
    href = (matches == null) ? $('#edit-link').val() : matches[1];
    
    // Add anchor if we have any and make sure there is no "#" before adding the anchor
    var anchor = $('#edit-anchor').val().replace(/#/g,'');
    if(anchor.length > 0) {
      href = href.concat('#' + anchor);
    }

    var link_text_matches = $('#edit-link').val().match(/(.*)\[path:.*\]/i);
    link_text = (link_text_matches == null) ? $('#edit-link').val() : link_text_matches[1].replace(/^\s+|\s+$/g, '');
    
    // Create new anchor elements
		if (e == null) {
      
      if (ed.selection.isCollapsed()) {
        tinyMCEPopup.execCommand("mceInsertContent", false, '<a href="#linkit-href#">' + link_text + '</a>');
      } else {
        tinyMCEPopup.execCommand("createlink", false, '#linkit-href#', {skip_undo : 1});
      }

			tinymce.each(ed.dom.select("a"), function(n) {
				if (ed.dom.getAttrib(n, 'href') == '#linkit-href#') {
					e = n;

					ed.dom.setAttribs(e, {
						'href'      : href,
            'title'     : $('#edit-title').val(),
            'id'        : $('#edit-id').val(),
            'class'     : $('#edit-class').val(),
            'rel'       : $('#edit-rel').val(),
            'accesskey' : $('#edit-accesskey').val()
					});
				}
			});
		} else {
			ed.dom.setAttribs(e, {
				'href'      : href,
        'title'     : $('#edit-title').val(),
        'id'        : $('#edit-id').val(),
        'class'     : $('#edit-class').val(),
        'rel'       : $('#edit-rel').val(),
        'accesskey' : $('#edit-accesskey').val()
			});
		}
    // Don't move caret if selection was image
    if(e != null) {
      if (e.childNodes.length != 1 || e.firstChild.nodeName != 'IMG') {
        ed.focus();
        ed.selection.select(e);
        ed.selection.collapse(0);
        tinyMCEPopup.storeSelection();
      }
    }

		tinyMCEPopup.execCommand("mceEndUndoLevel");
		tinyMCEPopup.close();

  }
};

tinyMCEPopup.onInit.add(LinkitDialog.init, LinkitDialog);


$(document).ready(function() {
  $('#edit-link').keydown(function(ev) {
    if (ev.keyCode == 13) {
      // Prevent browsers from firing the click event on the first submit
      // button when enter is used to select from the autocomplete list.
      return false;
    }
  });
  $('#edit-insert').click(function() {
    LinkitDialog.insertLink();
  });

  $('#edit-cancel').click(function() {
    tinyMCEPopup.close();
  });
});


