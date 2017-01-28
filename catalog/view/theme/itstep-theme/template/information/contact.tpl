<?php echo $header; ?>

<div class="container">
  <!-- breadcrumbs begin -->
  <div class="way">
    <?php foreach ($breadcrumbs as $i => $breadcrumb) { ?>

    <span><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></span>
    <? if ($i < count($breadcrumbs) - 1) { ?>
    <i class="fa fa-angle-right" aria-hidden="true"></i>
    <? } ?>
    <?php } ?>
  </div>
  <!-- breadcrumbs end -->

    <div id="content" style="text-align: center;">
      <h1><?php echo $heading_title; ?></h1>

      <h3><?php echo $text_location; ?></h3>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <?php if ($image) { ?>
              <div class="col-sm-3"><img src="<?php echo $image; ?>" alt="<?php echo $store; ?>" title="<?php echo $store; ?>" class="img-thumbnail" /></div>
            <?php } ?>

            <div class="col-sm-3"><strong><?php echo $store; ?></strong><br />
              <address>
              <?php echo $address; ?>
              </address>
              <?php if ($geocode) { ?>
              <a href="https://maps.google.com/maps?q=<?php echo urlencode($geocode); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15" target="_blank" class="btn btn-info"><i class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
              <?php } ?>
            </div>

            <div class="col-sm-3"><strong><?php echo $text_telephone; ?></strong><br>
              <?php echo $telephone; ?><br />
              <br />
              <?php if ($fax) { ?>
              <strong><?php echo $text_fax; ?></strong><br>
              <?php echo $fax; ?>
              <?php } ?>
            </div>

            <div class="col-sm-3">
              <?php if ($open) { ?>
              <strong><?php echo $text_open; ?></strong><br />
              <?php echo $open; ?><br />
              <br />
              <?php } ?>
              <?php if ($comment) { ?>
              <strong><?php echo $text_comment; ?></strong><br />
              <?php echo $comment; ?>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <?php if ($locations) { ?>
        <h3><?php echo $text_store; ?></h3>

        <div class="panel-group" id="accordion">
          <?php foreach ($locations as $location) { ?>
            <div class="panel panel-default">
              <div class="panel-heading">
              <h4 class="panel-title"><a href="#collapse-location<?php echo $location['location_id']; ?>" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><?php echo $location['name']; ?> <i class="fa fa-caret-down"></i></a></h4>
            </div>

              <div class="panel-collapse collapse" id="collapse-location<?php echo $location['location_id']; ?>">
              <div class="panel-body">
                <div class="row">
                  <?php if ($location['image']) { ?>
                    <div class="col-sm-3"><img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>" title="<?php echo $location['name']; ?>" class="img-thumbnail" /></div>
                  <?php } ?>

                  <div class="col-sm-3"><strong><?php echo $location['name']; ?></strong><br />
                    <address>
                    <?php echo $location['address']; ?>
                    </address>
                    <?php if ($location['geocode']) { ?>
                    <a href="https://maps.google.com/maps?q=<?php echo urlencode($location['geocode']); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15" target="_blank" class="btn btn-info"><i class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
                    <?php } ?>
                  </div>

                  <div class="col-sm-3"> <strong><?php echo $text_telephone; ?></strong><br>
                    <?php echo $location['telephone']; ?><br />
                    <br />
                    <?php if ($location['fax']) { ?>
                    <strong><?php echo $text_fax; ?></strong><br>
                    <?php echo $location['fax']; ?>
                    <?php } ?>
                  </div>

                  <div class="col-sm-3">
                    <?php if ($location['open']) { ?>
                    <strong><?php echo $text_open; ?></strong><br />
                    <?php echo $location['open']; ?><br />
                    <br />
                    <?php } ?>
                    <?php if ($location['comment']) { ?>
                    <strong><?php echo $text_comment; ?></strong><br />
                    <?php echo $location['comment']; ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
      </div>
      <?php } ?>

      <div class="block-check">
        <form method="post" style="text-align: left;">
          <div>
            <span class="name-check">Имя</span>
            <input type="text" name="name" value="<?php echo $name; ?>" />
            <span class="validation <?= $error_name ? 'fail' : '' ?>"></span>
            <span class="title"><?= $error_name ? $error_name : '' ?></span>
          </div>

          <div>
            <span class="name-check">Email</span>
            <input type="text" name="email" value="<?php echo $email; ?>" />
            <span class="validation <?= $error_email ? 'fail' : '' ?>"></span>
            <span class="title"><?= $error_email ? $error_email : '' ?></span>
          </div>

          <div>
            <span class="name-check">Сообщение</span>
            <textarea name="enquiry"><?php echo $enquiry; ?></textarea>
            <span class="validation <?= $error_enquiry ? 'fail' : '' ?>"></span>
            <span class="title"><?= $error_enquiry ? $error_enquiry : '' ?></span>
          </div>

          <?php echo $captcha; ?>

          <input type="submit" class="check-in" value="Отправить">
        </form>
      </div>
    </div>
</div>
<?php echo $footer; ?>
