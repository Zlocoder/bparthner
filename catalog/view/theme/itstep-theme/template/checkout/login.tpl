<?= $header ?>

<div class="container">
  <div class="border-check">
    <h1>Оформление заказа</h1>
    <div class="block-check">
      <form method="post" action="">
        <div>
          <span class="name-check">Имя, фамилия</span>
          <input type="text" name="firstname" value="<?= isset($firstname) ? $firstname : '' ?>" />

          <?php if (isset($errors['firstname'])) { ?>
            <span class="validation fail"></span>
            <span class="title"><?= $errors['firstname'] ?></span>
          <?php } else { ?>
            <span class="validation"></span>
            <span class="title"></span>
          <?php } ?>
        </div>

        <div>
          <span class="name-check">Телефон</span>
          <input type="text" name="telephone" value="<?= isset($telephone) ? $telephone : '' ?>" />

          <?php if (isset($errors['telephone'])) { ?>
            <span class="validation fail"></span>
            <span class="title"><?= $errors['telephone'] ?></span>
          <?php } else { ?>
            <span class="validation"></span>
            <span class="title"></span>
          <?php } ?>
        </div>

        <div>
          <span class="name-check">Адрес</span>
          <input type="text" name="address" value="<?= isset($address) ? $address : '' ?>" />

          <?php if (isset($errors['address'])) { ?>
            <span class="validation fail"></span>
            <span class="title"><?= $errors['address'] ?></span>
          <?php } else { ?>
            <span class="validation"></span>
            <span class="title"></span>
          <?php } ?>
        </div>

        <div>
          <span class="name-check">Способ доставки</span>
          <select name="shipping">
            <option value="">Выберите способ доставки...</option>
            <?php foreach ($shipping_methods as $key => $method) { ?>
                <?php if (isset($shipping) && $shipping == $key) { ?>
                  <option selected value="<?= $key ?>"><?= $method['title'] ?></option>
                <?php } else { ?>
                  <option value="<?= $key ?>"><?= $method['title'] ?></option>
                <?php } ?>
            <?php } ?>
          </select>

          <?php if (isset($errors['shipping'])) { ?>
            <span class="validation fail"></span>
            <span class="title"><?= $errors['shipping'] ?></span>
          <?php } else { ?>
            <span class="validation"></span>
            <span class="title"></span>
          <?php } ?>
        </div>

        <div>
          <span class="name-check">Способ оплаты</span>
          <select name="payment">
            <option value="">Выберите способ оплаты...</option>
            <?php foreach ($payment_methods as $key => $method) { ?>
                <?php if (isset($payment) && $payment == $key) { ?>
                  <option selected value="<?= $key ?>"><?= $method['title'] ?></option>
                <?php } else { ?>
                  <option value="<?= $key ?>"><?= $method['title'] ?></option>
                <?php } ?>
            <?php } ?>
          </select>

          <?php if (isset($errors['payment'])) { ?>
            <span class="validation fail"></span>
            <span class="title"><?= $errors['payment'] ?></span>
          <?php } else { ?>
            <span class="validation"></span>
            <span class="title"></span>
          <?php } ?>
        </div>

        <div>
          <span class="name-check">Коментарий</span>
          <textarea name="comment"><?= isset($comment) ? $comment : ''?></textarea>

          <?php if (isset($errors['comment'])) { ?>
            <span class="validation fail"></span>
            <span class="title"><?= $errors['comment'] ?></span>
          <?php } else { ?>
            <span class="validation"></span>
            <span class="title"></span>
          <?php } ?>
        </div>

        <input type="submit" class="check-in" value="Оформить заказ" />
      </form>
    </div>
  </div>
</div>

<?php $footer ?>
