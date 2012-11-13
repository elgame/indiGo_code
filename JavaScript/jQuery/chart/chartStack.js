/*

  JAVASCRIPT

    libs necesarias:
      - excanvas.js
      - jquery.flot.min.js
      - jquery.flot.resize.min.js
      - jquery.flot.stack.js

  HTML
     <!-- START STACK CHART -->
    <div class="box">
      <div class="box-header well">
        <h2><i class="icon-list-alt"></i> Stack Example</h2>
        <div class="box-icon">
          <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
          <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
          <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
        </div>
      </div>
      <div class="box-content">
         <div id="stackchart" class="center" style="height:300px;"></div>

        <p class="stackControls center">
          <input class="btn" type="button" value="With stacking">
          <input class="btn" type="button" value="Without stacking">
        </p>

        <p class="graphControls center">
          <input class="btn btn-primary" type="button" value="Bars">
          <input class="btn btn-primary" type="button" value="Lines">
          <input class="btn btn-primary" type="button" value="Lines with steps">
        </p>
      </div>
    </div> <!-- END STACK CHART -->

 */


$(function(){
  if($("#stackchart").length)
  {
    var d1 = [];
    for (var i = 0; i <= 10; i += 1)
    d1.push([i, parseInt(Math.random() * 30)]);

    var d2 = [];
    for (var i = 0; i <= 10; i += 1)
      d2.push([i, parseInt(Math.random() * 30)]);

    var d3 = [];
    for (var i = 0; i <= 10; i += 1)
      d3.push([i, parseInt(Math.random() * 30)]);

    var stack = 0, bars = true, lines = false, steps = false;

    function plotWithOptions() {
      $.plot($("#stackchart"), [ d1, d2, d3 ], {
        series: {
          stack: stack,
          lines: { show: lines, fill: true, steps: steps },
          bars: { show: bars, barWidth: 0.6 }
        }
      });
    }

    plotWithOptions();

    $(".stackControls input").click(function (e) {
      e.preventDefault();
      stack = $(this).val() == "With stacking" ? true : null;
      plotWithOptions();
    });
    $(".graphControls input").click(function (e) {
      e.preventDefault();
      bars = $(this).val().indexOf("Bars") != -1;
      lines = $(this).val().indexOf("Lines") != -1;
      steps = $(this).val().indexOf("steps") != -1;
      plotWithOptions();
    });
  }
});