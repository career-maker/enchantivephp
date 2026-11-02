<?php
$page = [
  'title' => 'Page not found | Enchantive Asia',
  'desc' => 'The page you are looking for could not be found.',
  'nav' => 'none',
  'status' => 404,
  'og' => 'assets/images/hero-koh-phangan-coast.webp',
];
require __DIR__ . '/includes/header.php';
?>
<section class="hero hero--inner notfound">
  <div class="hero__slides"><img class="hero__slide is-active" src="assets/images/coastal-road-aerial.webp" alt="" width="1440" height="681" fetchpriority="high"></div>
  <div class="container hero__inner notfound__inner">
    <p class="notfound__code" aria-hidden="true">404</p>
    <h1 class="h-display hero__title">This Journey Has Taken a Wrong Turn</h1>
    <p class="hero__sub">The page you are looking for has moved, or never existed. Let us point you back to somewhere worth going.</p>
    <div class="hero__actions">
      <a class="btn btn--glass" href="./">Back to Home</a>
      <a class="btn btn--glass" href="services">Explore Services</a>
      <a class="btn btn--glass" href="contact">Contact Us</a>
    </div>
    <nav class="notfound__links" aria-label="Popular pages">
      <span class="notfound__links-label">Popular</span>
      <a href="destinations">Destinations</a>
      <a href="leisure">Leisure</a>
      <a href="mice">MICE</a>
      <a href="celebrations-events">Celebrations</a>
      <a href="luxe-experiences">Luxe Experiences</a>
      <a href="gallery">Gallery</a>
    </nav>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
