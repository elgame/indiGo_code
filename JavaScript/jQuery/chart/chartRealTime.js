/*

  JAVASCRIPT

    libs necesarias:
      - excanvas.js
      - jquery.flot.min.js
      - jquery.flot.resize.min.js

  HTML
    <!-- START REAL TIME CHART -->
    <div class="box span4">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-list-alt"></i> Realtime</h2>
        <div class="box-icon">
          <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
          <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
          <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
        </div>
      </div>
      <div class="box-content">
         <div id="realtimechart" style="height:190px;"></div>
         <p>You can update a chart periodically to get a real-time effect by using a timer to insert the new data in the plot and redraw it.</p>
         <p>Time between updates: <input id="updateInterval" type="text" value="" style="text-align: right; width:5em"> milliseconds</p>
      </div>
    </div> <!-- END REAL TIME CHART -->


 */

$(function(){
   // we use an inline data source in the example, usually data would
  // be fetched from a server
  var data = [], totalPoints = 300;
  function getRandomData() {
    if (data.length > 0)
      data = data.slice(1);

    // do a random walk
    while (data.length < totalPoints) {
      var prev = data.length > 0 ? data[data.length - 1] : 50;
      var y = prev + Math.random() * 10 - 5;
      if (y < 0)
        y = 0;
      if (y > 100)
        y = 100;
      data.push(y);
    }

    // zip the generated y values with the x values
    var res = [];
    for (var i = 0; i < data.length; ++i)
      res.push([i, data[i]])
    return res;
  }

  // setup control widget
  var updateInterval = 30;
  $("#updateInterval").val(updateInterval).change(function () {
    var v = $(this).val();
    if (v && !isNaN(+v)) {
      updateInterval = +v;
      if (updateInterval < 1)
        updateInterval = 1;
      if (updateInterval > 2000)
        updateInterval = 2000;
      $(this).val("" + updateInterval);
    }
  });

  //realtime chart
  if($("#realtimechart").length)
  {
    var options = {
      series: { shadowSize: 1 }, // drawing is faster without shadows
      yaxis: { min: 0, max: 100 },
      xaxis: { show: false }
    };
    var plot = $.plot($("#realtimechart"), [ getRandomData() ], options);
    function update() {
      plot.setData([ getRandomData() ]);
      // since the axes don't change, we don't need to call plot.setupGrid()
      plot.draw();

      setTimeout(update, updateInterval);
    }

    update();
  }
});