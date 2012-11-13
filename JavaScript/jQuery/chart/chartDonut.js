/*

  JAVASCRIPT

    libs necesarias:
      - excanvas.js
      - jquery.flot.min.js
      - jquery.flot.resize.min.js
      - jquery.flot.pie.min.js

  HTML
     <!-- START DONUT CHART -->
        <div class="box">
          <div class="box-header well" data-original-title>
            <h2><i class="icon-list-alt"></i> Donut</h2>
            <div class="box-icon">
              <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
              <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
              <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
            </div>
          </div>
          <div class="box-content">
             <div id="donutchart" style="height: 300px;">
          </div>
        </div>
      </div> <!-- END DONUT CHART -->

 */

// CONFIGURACION
$(function(){
  var data = [
    { label: "Internet Explorer",  data: 12},
    { label: "Mobile",  data: 27},
    { label: "Safari",  data: 85},
    { label: "Opera",  data: 64},
    { label: "Firefox",  data: 90},
    { label: "Chrome",  data: 112}
    ];

  if($("#donutchart").length)
  {
    $.plot($("#donutchart"), data,
    {
        series: {
            pie: {
                innerRadius: 0.5,
                show: true
            }
        },
        legend: {
          show: false
        }
    });
  }
});