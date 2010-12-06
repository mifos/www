/* $Id: fckplugin.js,v 1.1 2010/07/04 22:25:02 anon Exp $ */

if(typeof Drupal != 'undefined') {
  var path = Drupal.settings.linkit.url.wysiwyg_fckeditor;
  var basePath =  Drupal.settings.basePath;
} else {
  var basePath =  linkit_basePath;
  var path = basePath + linkit_url_fckeditor;
}

FCKCommands.RegisterCommand( 'linkit', new FCKDialogCommand( 'linkit', '&nbsp;', path, 580, 320 ) ) ;

var oLinkitItem = new FCKToolbarButton( 'linkit', 'Linkit');
oLinkitItem.IconPath = basePath + 'sites/all/modules/linkit/editors/fckeditor/linkit/linkit.png';
FCKToolbarItems.RegisterItem( 'linkit', oLinkitItem );