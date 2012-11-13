/*
  JAVASCRIPT

    Plugins necesarios:
      - fullcalendar.min.js

  CSS
    - fullcalendar.css
    - fullcalendar.print.css

  HTML
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-calendar"></i>Calendar</h2>
        <div class="box-icon">
          <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
          <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
          <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
        </div>
      </div>
      <div class="box-content">
      <div id="external-events" class="well">
        <h4>Draggable Events</h4>
        <div class="external-event badge">Default</div>
        <div class="external-event badge badge-success">Completed</div>
        <div class="external-event badge badge-warning">Warning</div>
        <div class="external-event badge badge-important">Important</div>
        <div class="external-event badge badge-info">Info</div>
        <div class="external-event badge badge-inverse">Other</div>
        <p>
        <label for="drop-remove"><input type="checkbox" id="drop-remove" /> remove after drop</label>
        </p>
        </div>

        <div id="calendar"></div>

        <div class="clearfix"></div>
      </div>
    </div>

 */


$(function(){
  $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
    editable: true,
    droppable: true, // this allows things to be dropped onto the calendar !!!
    drop: function(date, allDay) { // this function is called when something is dropped

      // retrieve the dropped element's stored Event Object
      var originalEventObject = $(this).data('eventObject');

      // we need to copy it, so that multiple events don't have a reference to the same object
      var copiedEventObject = $.extend({}, originalEventObject);

      // assign it the date that was reported
      copiedEventObject.start = date;
      copiedEventObject.allDay = allDay;

      // render the event on the calendar
      // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
      $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

      // is the "remove after drop" checkbox checked?
      if ($('#drop-remove').is(':checked')) {
        // if so, remove the element from the "Draggable Events" list
        $(this).remove();
      }
    }
  });
});