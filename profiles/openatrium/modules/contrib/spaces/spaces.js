Drupal.behaviors.spacesMenuEditor = function(context) {
  if (jQuery().pageEditor) {
    $('form.spaces-menu-editor:not(.spaces-processed)')
      .addClass('spaces-processed')
      .pageEditor()
      .each(function() {
        var editor = $(this);
        var menu = $('a.spaces-menu-editable').parent('li').parent('ul');

        // Click handlers

        // Start
        $('input.spaces-menu-editor:not(.spaces-processed)', editor)
          .addClass('spaces-processed')
          .click(function() {
            $(editor).pageEditor('start');
            return false;
          });

        // Save
        $('input.spaces-menu-save:not(.spaces-processed)', editor)
          .addClass('spaces-processed')
          .click(function() {
            $(editor).pageEditor('end');
            var data = [];
            $('a', menu).each(function(){
              data.push($(this).attr('href'));
            });
            $('input#edit-space-menu-items').val(JSON.stringify(data));
          });

        // Cancel
        $('input.spaces-menu-cancel:not(.spaces-processed)', editor)
          .addClass('spaces-processed')
          .click(function() {
            menu.sortable('cancel');
            $(editor).pageEditor('end');
            return false;
          });

        // Start
        $(this).bind('start.pageEditor', function() {
          menu.sortable({revert: true, containment: 'parent'}).addClass('spaces-menu-editing');
          $('input.form-submit', this).show();
          $('input.spaces-menu-editor').hide();
        });

        // End
        $(this).bind('end.pageEditor', function() {
          menu.sortable('destroy').removeClass('spaces-menu-editing');
          $('input.form-submit', this).hide();
          $('input.spaces-menu-editor').show();
        });
      });
  }
};
