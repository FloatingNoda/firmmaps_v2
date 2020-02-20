$(document).ready(function() {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var tab_name = e.target.toString();
        firmmaps_load(tab_name.substring(tab_name.indexOf('#')+1));
        //e.target // newly activated tab
        //e.relatedTarget // previous active tab
      })
      firmmaps_load("general");
      
});
function firmmaps_load(tab_name){
    $.ajax({
        url: "engine/modules/firmmaps_v2/admin/pages/"+tab_name+".php?mod=firmmaps",
        cache: false,
        data: "DATALIFEENGINE=1",
        success: function(html){
          $(".panel-content .tab-content #content").html(html);
        }
      });
}
