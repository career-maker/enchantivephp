</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
<aside class="float-contact" aria-label="Quick contact">
  <a class="float-contact__btn float-contact__btn--call" href="tel:+6620282867" aria-label="Call +66 2028 2867"><svg aria-hidden="true"><use href="#i-phone"/></svg><span>Call</span></a>
  <a class="float-contact__btn float-contact__btn--mail" href="mailto:info@enchantiveasia.com" aria-label="Email info@enchantiveasia.com"><svg aria-hidden="true"><use href="#i-mail"/></svg><span>Email</span></a>
  <a class="float-contact__btn float-contact__btn--wa" href="https://wa.me/6620282867" rel="noopener" aria-label="WhatsApp +66 2028 2867"><svg aria-hidden="true"><use href="#i-whatsapp"/></svg><span>WhatsApp</span></a>
</aside>
<?php foreach (['navigation', 'forms', 'animation', 'gallery', 'carousel'] as $c): ?>
<script src="<?= asset("js/components/$c.js") ?>" defer></script>
<?php endforeach; ?>
<script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
<?php if (!empty($is404)) { ob_end_flush(); } ?>
