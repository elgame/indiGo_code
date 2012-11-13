/*

  JAVASCRIPT

    libs necesarias:
      - excanvas.js
      - jquery.flot.min.js
      - jquery.flot.resize.min.js

  HTML
     <!-- START FLOT CHART -->
      <div class="box">
        <div class="box-header well">
          <h2><i class="icon-list-alt"></i> Flot</h2>
          <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
          </div>
        </div>
        <div class="box-content">
          <div id="flotchart" class="center" style="height:300px"></div>
        </div>
      </div> <!-- END FLOT CHART -->


 */

$(function(){
  if($("#flotchart").length)
  {
    var d1 = [];
    for (var i = 0; i < Math.PI * 2; i += 0.25)
      d1.push([i, Math.sin(i)]);

    var d2 = [];
    for (var i = 0; i < Math.PI * 2; i += 0.25)
      d2.push([i, Math.cos(i)]);

    var d3 = [];
    for (var i = 0; i < Math.PI * 2; i += 0.1)
      d3.push([i, Math.tan(i)]);

    $.plot($("#flotchart"), [
      { label: "sin(x)",  data: d1},
      { label: "cos(x)",  data: d2},
      { label: "tan(x)",  data: d3}
    ], {
      series: {
        lines: { show: true },
        points: { show: true }
      },
      xaxis: {
        ticks: [0, [Math.PI/2, "\u03c0/2"], [Math.PI, "\u03c0"], [Math.PI * 3/2, "3\u03c0/2"], [Math.PI * 2, "2\u03c0"]]
      },
      yaxis: {
        ticks: 10,
        min: -2,
        max: 2
      },
      grid: {
        backgroundColor: { colors: ["#fff", "#eee"] }
      }
    });
  }
});

