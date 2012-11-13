/*
  JAVASCRIPT

    Plugins necesarios:
      - jquery.form.js
 */

$(function(){
  upload_multiple.init({form: '#formImgs', inputfile: '#fimagenes', bar: '.bar', percent: '.percent'});
});

var upload_multiple = (function ($) {

  var config = {},
      module = {},
      parent,
      uniqid = 0;

  // Inicializa el plugin
  function initialize (conf) {
    if (typeof conf === "object") {
      setConfig(conf);
    }
    inputFileOnChange();
  }

  // Asignamos la configuracion
  function setConfig (conf) {
    if (typeof conf === "object") {
      config = conf;
      console.log(conf);
    } else {
      console.log("El parametro debe ser tipo Object i.e. {form: '#formImgs', inputfile: '#fimagenes', bar: '.bar', percent: '.percent'}");
    }
  }

  // Asigna el evento onChange al o los input-file especificados en el config
  function inputFileOnChange () {
    $(config.inputfile).on('change', $('body'), function(event) {
      parent = $(this).parent();
      submitForm();
    });
  }

  function submitForm () {
    var html_progress_bar = '<div class="progress progress-striped active" style="margin-bottom: 9px; width: 30%;" id="progress-bar"><div class="bar" style="width: 0%"></div></div><span class="help-block percent">0%</span>';
    // parent.children().css({"display":"none"}); // Oculta el input-file original
    $(html_progress_bar).appendTo(parent); // Agrega el html del progress-bar
    ajaxForm();
    $(config.form).submit(); // Realiza el envio del formulario
  }

  // Inicializa el plugin ajaxForm para asignar el evento al formulario
  function ajaxForm () {
    var bar = $(config.bar),
    percent = $(config.percent);
    // var status = $(config.status);

    $(config.form).ajaxForm({
      beforeSend: function () {
          // status.empty();
          var percentVal = '0%';
          bar.width(percentVal)
          percent.html(percentVal);
      },
      uploadProgress: function (event, position, total, percentComplete) {
          var percentVal = percentComplete + '%';
          bar.width(percentVal)
          percent.html(percentVal);
          // console.log(percentVal, position, total);
      },
      success: function (response, statusText, xhr, wrap) {
        console.log(response);
        if (response.status === 1) {
          // HACER ALGO ...
        }
      },
      dataType: 'json'
    });
  }

  module.init         = initialize;
  module.setConfig    = setConfig;
  // module.deleteThumb = deleteThumb;

  return module;

})(jQuery);