<?php echo $header; ?>

<div class="container">
    <?php echo $content_top; ?>

    <?php echo $content_bottom; ?>
</div>

<script>
    $('.latests').owlCarousel({
        items: 5,
        dotsClass: 'dots',
        dotClass: 'dot',
        onInitialized: function () {
            $('.latests .dot').css('width', $('.latests .dots').width() / $('.latests .dot').length);
        }
    });

    $('.specials').owlCarousel({
        items: 5,
        dotsClass: 'dots',
        dotClass: 'dot',
        onInitialized: function () {
            $('.specials .dot').css('width', $('.specials .dots').width() / $('.specials .dot').length);
        }
    });

    $('.viewed').owlCarousel({
        items: 5,
        dotsClass: 'dots',
        dotClass: 'dot',
        onInitialized: function () {
            $('.viewed .dot').css('width', $('.viewed .dots').width() / $('.viewed .dot').length);
        }
    });
</script>


<?php echo $footer; ?>