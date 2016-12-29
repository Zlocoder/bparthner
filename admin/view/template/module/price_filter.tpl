<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-price-filter" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" id="form-price-filter" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-container-selector"><?php echo $entry_container_selector; ?></label>
            <div class="col-sm-2 input-group">
              <input style="width: 250px;" type="text" name="price_filter_container_selector" value="<?php echo $container_selector; ?>" placeholder="#content .row:nth-last-of-type(2)" id="input-container-selector" class="form-control" />
              <?php if ($error_container_selector) { ?>
              <div class="text-danger"><?php echo $error_container_selector; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-paginator-selector"><?php echo $entry_paginator_selector; ?></label>
            <div class="col-sm-2 input-group">
              <input style="width: 250px;" type="text" name="price_filter_paginator_selector" value="<?php echo $paginator_selector; ?>" placeholder="#content .row:nth-last-of-type(1)" id="input-paginator-selector" class="form-control" />
              <?php if ($error_paginator_selector) { ?>
              <div class="text-danger"><?php echo $error_paginator_selector; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-line-background"><?php echo $entry_line_background; ?></label>
            <div class="col-sm-2 input-group color">
              <input type="text" name="price_filter_line_background" value="<?php echo $line_background; ?>" placeholder="#EEEEEE" id="input-line-background" class="form-control" /><span class="input-group-addon"><i style="border: 1px solid rgb(0, 0, 0); background-color: #EEEEEE;"></i></span>
              <?php if ($error_line_background) { ?>
              <div class="text-danger"><?php echo $error_line_background; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-active-background"><?php echo $entry_active_background; ?></label>
            <div class="col-sm-2 input-group color">
              <input type="text" name="price_filter_active_background" value="<?php echo $active_background; ?>" placeholder="#F6A828" id="input-active-background" class="form-control" /><span class="input-group-addon"><i style="border: 1px solid rgb(0, 0, 0); background-color: #F6A828;"></i></span>
              <?php if ($error_active_background) { ?>
              <div class="text-danger"><?php echo $error_active_background; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-line-border"><?php echo $entry_line_border; ?></label>
            <div class="col-sm-2 input-group color">
              <input type="text" name="price_filter_line_border" value="<?php echo $line_border; ?>" placeholder="#DDDDDD" id="input-line-border" class="form-control" /><span class="input-group-addon"><i style="border: 1px solid rgb(0, 0, 0); background-color: #DDDDDD;"></i></span>
              <?php if ($error_line_border) { ?>
              <div class="text-danger"><?php echo $error_line_border; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-handle-background"><?php echo $entry_handle_background; ?></label>
            <div class="col-sm-2 input-group color">
              <input type="text" name="price_filter_handle_background" value="<?php echo $handle_background; ?>" placeholder="#F6F6F6" id="input-handle-background" class="form-control" /><span class="input-group-addon"><i style="border: 1px solid rgb(0, 0, 0); background-color: #F6F6F6;"></i></span>
              <?php if ($error_handle_background) { ?>
              <div class="text-danger"><?php echo $error_handle_background; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-handle-border"><?php echo $entry_handle_border; ?></label>
            <div class="col-sm-2 input-group color">
              <input type="text" name="price_filter_handle_border" value="<?php echo $handle_border; ?>" placeholder="#CCCCCC" id="input-handle-border" class="form-control" /><span class="input-group-addon"><i style="border: 1px solid rgb(0, 0, 0); background-color: #CCCCCC"></i></span>
              <?php if ($error_handle_border) { ?>
              <div class="text-danger"><?php echo $error_handle_border; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-handle-type"><?php echo $entry_handle_type; ?></label>
            <div class="col-sm-2 input-group">
              <select name="price_filter_handle_type" id="input-handle-type" class="form-control">
                <?php if ($handle_type == 1) { ?>
                <option value="0"><?php echo $text_type_default; ?></option>
                <option value="1" selected="selected"><?php echo $text_type_round; ?></option>
                <option value="2"><?php echo $text_type_square; ?></option>
                <?php } elseif ($handle_type == 2) { ?>
                <option value="0"><?php echo $text_type_default; ?></option>
                <option value="1"><?php echo $text_type_round; ?></option>
                <option value="2" selected="selected"><?php echo $text_type_square; ?></option>
                <?php } else { ?>
                <option value="0" selected="selected"><?php echo $text_type_default; ?></option>
                <option value="1"><?php echo $text_type_round; ?></option>
                <option value="2"><?php echo $text_type_square; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-2 input-group">
              <select name="price_filter_status" id="input-status" class="form-control">
                <?php if ($price_filter_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $(function(){
    $('.color').colorpicker();
  });
</script>
<?php echo $footer; ?>