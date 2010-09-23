$(document).ready(function() {
  // create tabs (in user groups page)
  $("ul.group-tabs").tabs("div.group-panes > div");
  
  // replace search box button
  $('#block-search-0 #edit-submit').replaceWith('<input type="image" src="/sites/all/themes/mifos/images/btn_search.png" class="form-submit" />');
  $('#block-search-0 #edit-submit-1').replaceWith('<input type="image" src="/sites/all/themes/mifos/images/btn_search.png" class="form-submit" />');
  
  // add additional drop-shadow to nav items
  $('#block-superfish-1 ul.sf-menu>li.active-trail').prev().addClass('prev-shadow');
  
  // dynamically adjust padding and height on mifos download box on homepage
  if ($("#block-block-7").length && $("#block-block-1").length) {
    resize_download();
    
    // we also need to bind this function to window resize
    $(window).bind("resize", resize_download);
  };
  
  // make imagecache imagelinks open in fancybox
  $('a.imagecache-imagelink').fancybox();
  
  // move the node subtitle up to the header area
  if ($("#subtitle").length) {
    var subtitle = $("#subtitle").html();
    $("#page-title").append(subtitle);
  }
  
  // add "inner border" to images with a container class of "bordered-img"
  if($(".bordered-img").length) {
    var width = $(".bordered-img img").width();
    var height = $(".bordered-img img").height() - 20; // -10 to keep spans from overlapping
    var appended_markup = '<span class="border-top" style="width:' + width + 'px;" />';
    appended_markup += '<span class="border-right" style="height:' + height + 'px;" />';
    appended_markup += '<span class="border-left" style="height:' + height + 'px;" />';
    appended_markup += '<span class="border-bottom" style="width:' + width + 'px;" />';
    $(".bordered-img").append(appended_markup);
  }
  
  // add "inner border" to images with a container class of ".section-contributors .field-type-filefield"
  if($(".section-contributors .field-type-filefield").length) {
    $.each($(".section-contributors .field-type-filefield"), function(index, el) {
      var width = $(el).find('img').width();
      var height = $(el).find('img').height() - 20; // -10 to keep spans from overlapping
      var appended_markup = '<span class="border-top" style="width:' + width + 'px;" />';
      appended_markup += '<span class="border-right" style="height:' + height + 'px;" />';
      appended_markup += '<span class="border-left" style="height:' + height + 'px;" />';
      appended_markup += '<span class="border-bottom" style="width:' + width + 'px;" />';
      $(el).append(appended_markup);
    });
    
  }
});

// function to dynamically adjust padding and height on mifos download box on homepage
function resize_download() {
  // get the height of the teaser box (adjust for padding)
  var height = $("#block-block-7").height();
  
  var content_height = $("#block-block-1 .content").height();
  
  // calculate padding so content is in center (based on content height)
  var top_padding = (height - content_height) / 2;
  
  // set the height (minus padding) on the download box to match
  $("#block-block-1").css('height', (height - top_padding) + 'px');
  
  // set the top-padding on the download box
  $("#block-block-1").css('padding-top', top_padding + 'px');
}