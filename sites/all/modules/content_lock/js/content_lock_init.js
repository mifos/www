
(function($) {
  window.content_lock_onleave = function  () {
    var nid = Drupal.settings.content_lock.nid;
    var random = Math.random();
    var aurl = "http:/ds.l"+Drupal.settings.basePath + 'index.php?q=ajax/content_lock/'+nid+'/canceledit&t='+random;
    $.ajax({
      url:   aurl,
      async: false,
      cache:false
    });
  }

  window.content_lock_confirm = function () {
    return Drupal.t('Be aware, if you press "OK" now, ALL your changes will be lost!');
  }

  $(document).ready(function() {
    $().onUserExit( {
      execute: content_lock_onleave,
      executeConfirm: content_lock_confirm,
      internalURLs: 'canceledit|trash/confirm|edit'
    });
  });
})(jQuery);