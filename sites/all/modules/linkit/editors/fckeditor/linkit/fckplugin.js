/* $Id: fckplugin.js,v 1.1.2.1 2011/01/23 22:11:30 anon Exp $ */

if(typeof Drupal != 'undefined') {
  var basePath =  Drupal.settings.basePath;
  var path = Drupal.settings.linkit.url.wysiwyg_fckeditor;
  var modulePath = Drupal.settings.linkit.modulepath;
} else {
  var basePath =  linkit_basePath;
  var path = basePath + linkit_url_fckeditor;
  var modulePath = linkit_modulePath;
}

FCKCommands.RegisterCommand( 'linkit', new FCKDialogCommand( 'linkit', '&nbsp;', path, 580, 320 ) ) ;

var oLinkitItem = new FCKToolbarButton( 'linkit', 'Linkit');
oLinkitItem.IconPath = basePath + modulePath + '/editors/fckeditor/linkit/linkit.png';
FCKToolbarItems.RegisterItem( 'linkit', oLinkitItem );