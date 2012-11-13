/*
  JAVASCRIPT

    libs necesarias:
      - excanvas.js
      - jquery.flot.min.js
      - jquery.flot.resize.min.js
      - jquery.flot.pie.min.js

  HTML
    <!-- START PIE CHART -->
    <div class="box">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-list-alt"></i> Pie</h2>
        <div class="box-icon">
          <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
          <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
          <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
        </div>
      </div>
      <div class="box-content">
          <div id="piechart" style="height:300px"></div>
      </div>
    </div> <!-- END PIE CHART -->
*/





$(function(){
  var data = [
    { label: "Internet Explorer",  data: 12},
    { label: "Mobile",  data: 27},
    { label: "Safari",  data: 85},
    { label: "Opera",  data: 64},
    { label: "Firefox",  data: 90},
    { label: "Chrome",  data: 112}
    ];

  if($("#piechart").length)
  {
    $.plot($("#piechart"), data,
    {
      series: {
          pie: {
              show: true
          }
      },
      grid: {
          hoverable: true,
          clickable: true
      },
      legend: {
        show: false
      }
    });

    function pieHover(event, pos, obj)
    {
      if (!obj)
          return;
      percent = parseFloat(obj.series.percent).toFixed(2);
      $("#hover").html('<span style="font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+' ('+percent+'%)</span>');
    }
    $("#piechart").bind("plothover", pieHover);
  }
});