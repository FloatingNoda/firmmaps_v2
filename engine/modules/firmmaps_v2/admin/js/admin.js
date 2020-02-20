$(document).ready(function() {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var tab_name = e.target.toString();
        firmmaps_load(tab_name.substring(tab_name.indexOf('#')+1));
      })
      firmmaps_load("general");
});
function firmmaps_load(tab_name, list=1){
    $("#list_count").hide();
    if (tab_name=="general") {
      $("#list_count").show();
      var add="&show_by="+$("#show_by").val()+"&list="+list;
    }
    $.ajax({
        url: "engine/modules/firmmaps_v2/admin/pages/"+tab_name+".php?mod=firmmaps"+add,
        cache: false,
        data: "DATALIFEENGINE=1",
        success: function(html){
          $(".panel-content .tab-content #content").html(html);
        }
      });
}
$("#list_count").change(function(){
  firmmaps_load("general")
});
function listchange(list){
  firmmaps_load("general",list)
}