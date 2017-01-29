<?php echo $header; ?>

<div class="container homepage">
    <?php echo $content_top; ?>

    <?php echo $content_bottom; ?>
</div>

<script>
    $('.latests').owlCarousel({
        items: 5,
        dots: false,
        nav: true,
        navText: ['<i class="fa fa-angle-left fa-5x" aria-hidden="true"></i>', '<i class="fa fa-angle-right fa-5x" aria-hidden="true"></i>'],
    });

    $('.specials').owlCarousel({
        items: 5,
        dots: false,
        nav: true,
        navText: ['<i class="fa fa-angle-left fa-5x" aria-hidden="true"></i>', '<i class="fa fa-angle-right fa-5x" aria-hidden="true"></i>'],
    });

    $('.viewed').owlCarousel({
        items: 5,
        dots: false,
        nav: true,
        navText: ['<i class="fa fa-angle-left fa-5x" aria-hidden="true"></i>', '<i class="fa fa-angle-right fa-5x" aria-hidden="true"></i>'],
    });
</script>


<?php echo $footer; ?>