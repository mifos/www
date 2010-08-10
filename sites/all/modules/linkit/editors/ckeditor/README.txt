; $Id: README.txt,v 1.2 2010/04/03 01:25:59 anon Exp $

##############################################
## ONLY if you use ckeditor WITHOUT wysiwyg ##
##############################################

Installation:

Do the following steps to add Linkit button to the CKEditor toolbar:

   1. Open /drupal/modules/ckeditor/ckeditor.config.js

   2. Add button to the toolbar. The button name is: Linkit
      For example if you have a toolbar with an array of buttons defined as follows:

      ['Link','Unlink','Anchor']

      simply add the button somewhere in the array:

      ['Linkit','Link','Unlink','Anchor']

      (remember about single quotes).

    3. Scroll down to the end of the file, right before "};" insert:
      
      // Linkit plugin.
      config.extraPlugins += (config.extraPlugins ? ',Linkit' : 'Linkit' );
      CKEDITOR.plugins.addExternal('Linkit', Drupal.settings.basePath + 'sites/all/modules/linkit/editors/ckeditor/');