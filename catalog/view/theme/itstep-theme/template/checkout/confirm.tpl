<?= $header ?>

<div class="container">
    <div class="border-check confirm">
        <h1>Подтверждение заказа</h1>

        <table class="cart_table" cellspacing="0">
            <thead>
                <tr>
                    <td></td>
                    <td></td>
                    <td>артикул</td>
                    <td>количество</td>
                    <td>сумма</td>
                </tr>
            </thead>

            <tbody>
                <?php foreach($products as $product) { ?>
                    <tr>
                        <td><img src="<?= $product['thumb'] ?>" alt="<?= $product['name'] ?>"></td>
                        <td class="title"><a href="<?= $product['href'] ?>"><?= $product['name'] ?> <?= $product['model'] ?></a></td>
                        <td class="cart-product_article"><?= $product['article'] ?></td>
                        <td class="cart-product_price"><?= $product['quantity'] ?></td>

                        <td class="cart-product_price"><?= $product['price'] ?></td>
                    </tr>
                <?php } ?>

                <?php foreach ($totals as $total) { ?>
                    <tr class="totals">
                        <td colspan="4" style="text-align: right;"><strong><?php echo $total['title']; ?>:</strong></td>
                        <td class="cart-product_price"><?php echo $total['text']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="row"><?= $payment ?></div>
    </div>
</div>

<?= $footer ?>
