jQuery(document).ready(function(){

  jQuery(window).bind("media.wildfireswffile.preview", function(e, row, preview_container){
    var str = "";

    row.find("td").each(function(){
      var html = jQuery(this).html();

      if(html.indexOf("<object") >= 0) str += html.replace("/40.", "/200.");
      else str += html;
    });
    preview_container.html(str);
  });
});