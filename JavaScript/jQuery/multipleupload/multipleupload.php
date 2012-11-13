<!-- START FORM UPLOAD IMAGENES -->
  <form action="<?php echo base_url('panel/controller/method'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal" id="formImgs">
    <fieldset>
      <legend></legend>

      <div class="control-group">
        <label class="control-label" for="name">*Imagenes</label>
        <div class="controls">
          <input type="file" name="fimagenes[]" id="fimagenes" class="input-file uniform_on" multiple>
          <span class="help-block">Seleleccione una o varias imagenes.</span>
        </div>
      </div>

    </fieldset>
  </form><!-- END FORM UPLOAD IMAGENES -->