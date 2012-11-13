/*

  JAVASCRIPT

    libs necesarias:
      - excanvas.js
      - jquery.flot.min.js
      - jquery.flot.resize.min.js

  HTML
     <!-- START POINTS CHART -->
     <div class="box">
      <div class="box-header well">
        <h2><i class="icon-list-alt"></i> Chart with points</h2>
        <div class="box-icon">
          <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
          <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
          <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
        </div>
      </div>
      <div class="box-content">
        <div id="pointsChart"  class="center" style="height:300px" ></div>
        <p id="hoverdata">Mouse position at (<span id="x">0</span>, <span id="y">0</span>). <span id="clickdata"></span></p>
      </div>
    </div> <!-- START POINTS CHART -->

 */

$(function(){
  if($("#pointsChart").length)
  {
    var sin = [], cos = [];

    for (var i = 0; i < 14; i += 0.5) {
      sin.push([i, Math.sin(i)/i]);
      cos.push([i, Math.cos(i)]);
    }

    var plot = $.plot($("#pointsChart"),
         [ { data: sin, label: "sin(x)/x"}, { data: cos, label: "cos(x)" } ], {
           series: {
             lines: { show: true  },
             points: { show: true }
           },
           grid: { hoverable: true, clickable: true, backgroundColor: { colors: ["#fff", "#eee"] } },
           yaxis: { min: -1.2, max: 1.2 },
           colors: ["#539F2E", "#3C67A5"]
         });

    function showTooltip(x, y, contents) {
      $('<div id="tooltip">' + contents + '</div>').css( {
        position: 'absolute',
        display: 'none',
        top: y + 5,
        left: x + 5,
        border: '1px solid #fdd',
        padding: '2px',
        'background-color': '#dfeffc',
        opacity: 0.80
      }).appendTo("body").fadeIn(200);
    }

    var previousPoint = null;
    $("#pointsChart").bind("plothover", function (event, pos, item) {
      $("#x").text(pos.x.toFixed(2));
      $("#y").text(pos.y.toFixed(2));

        if (item) {
          if (previousPoint != item.dataIndex) {
            previousPoint = item.dataIndex;

            $("#tooltip").remove();
            var x = item.datapoint[0].toFixed(2),
              y = item.datapoint[1].toFixed(2);

            showTooltip(item.pageX, item.pageY,
                  item.series.label + " of " + x + " = " + y);
          }
        }
        else {
          $("#tooltip").remove();
          previousPoint = null;
        }
    });

    $("#pointsChart").bind("plotclick", function (event, pos, item) {
      if (item) {
        $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
        plot.highlight(item.series, item.datapoint);
      }
    });
  }
});

