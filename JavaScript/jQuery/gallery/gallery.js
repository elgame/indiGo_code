/*
  JAVASCRIPT

    Plugins necesarios:
      - jquery.colorbox.min.js

  CSS
    - colorbox.css

  HTML
     <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-picture"></i> Gallery</h2>
        <div class="box-icon">
          <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
          <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
          <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
        </div>
      </div>
      <div class="box-content">
        <p class="center">
          <!-- BOTON FULLSCREEN -->
          <button id="toggle-fullscreen" class="btn btn-large btn-primary visible-desktop" data-toggle="button">Toggle Fullscreen</button>
        </p>
        <br/>
         <!-- START GALLERY -->
        <ul class="thumbnails gallery">
          <?php for($i=1;$i<=24;$i++) { ?>
          <li id="image-<?php echo $i ?>" class="thumbnail">
            <a style="background:url(img/gallery/thumbs/<?php echo $i ?>.jpg)" title="Sample Image <?php echo $i ?>" href="img/gallery/<?php echo $i ?>.jpg"><img class="grayscale" src="img/gallery/thumbs/<?php echo $i ?>.jpg" alt="Sample Image <?php echo $i ?>"></a>
          </li>
          <?php } ?>
        </ul> <!-- END GALLERY -->
      </div>
    </div>

 */

$(function(){
  gallery.init(); // INICIALIZA LA GALERIA
});


// OBJETO QUE CONTIENE LAS FUNCIONES PARA LA GALERIA
// SE PUEDE MODIFICAR SEGUN LAS NECESIDADES
var gallery = (function ($) {

  var ga = {};

  function initialize () {
    controlls_animation();
    onClickDelete();
    onClickEdit();
    colorBox();
    onClickFullscreen();
  }

  // Animacion para los controles que aparecen al colocar el mouse
  // sobre alguna imagen de la galeria
  function controlls_animation () {
    $('ul.gallery li').hover(function(){
      $('img',this).fadeToggle(1000);
      $(this).find('.gallery-controls').remove();
      $(this).append('<div class="well gallery-controls">'+
                '<p><a href="#" class="gallery-edit btn"><i class="icon-edit"></i></a> <a href="#" class="gallery-delete btn"><i class="icon-remove"></i></a></p>'+
              '</div>');
      $(this).find('.gallery-controls').stop().animate({'margin-top':'-1'},400,'easeInQuint');
      },function(){
        $('img',this).fadeToggle(1000);
        $(this).find('.gallery-controls').stop().animate({'margin-top':'-30'},200,'easeInQuint',function(){
            $(this).remove();
        });
    });
  }

  // Funcion que se dispara cuando se da click en el boton de eliminar
  // que se muestra al poner el mouse sobre alguna imagen
  // Este es un ejemplo se puede modificar segun la necesidad.
  function onClickDelete () {
    $('.thumbnails').on('click','.gallery-delete',function(e){
      e.preventDefault();
      //get image id
      //alert($(this).parents('.thumbnail').attr('id'));
      $(this).parents('.thumbnail').fadeOut();
    });
  }

  // Funcion que se dispara cuando se da click en el boton de editar
  // que se muestra al poner el mouse sobre alguna imagen
  // Este es un ejemplo se puede modificar segun la necesidad.
  function onClickEdit () {
    $('.thumbnails').on('click','.gallery-edit',function(e){
      e.preventDefault();
      //get image id
      alert($(this).parents('.thumbnail').attr('id'));
    });
  }

  // Asigna el plugin ColorBox para cuando den click sobre alguna imagen
  // de la galeria la muestra en un estilo superBox.
  function colorBox () {
    $('.thumbnail a').colorbox({rel:'thumbnail a', transition:"elastic", maxWidth:"95%", maxHeight:"95%"});
  }

  // Cambia a modo normal/fullscreen la pantalla
  function onClickFullscreen () {
    $('#toggle-fullscreen').on('click', function () {
      var button = $(this), root = document.documentElement;
      if (!button.hasClass('active')) {
        $('#thumbnails').addClass('modal-fullscreen');
        if (root.webkitRequestFullScreen) {
          root.webkitRequestFullScreen(
            window.Element.ALLOW_KEYBOARD_INPUT
          );
        } else if (root.mozRequestFullScreen) {
          root.mozRequestFullScreen();
        }
      } else {
        $('#thumbnails').removeClass('modal-fullscreen');
        (document.webkitCancelFullScreen ||
          document.mozCancelFullScreen ||
          $.noop).apply(document);
      }
    });
  }

  ga.init = initialize;
  return ga;
})(jQuery);