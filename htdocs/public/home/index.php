<?php
require_once '../../global.php';
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<!-- hero -->
<!-- ----------------------------------------------------------------------- -->
<section class="hero">
  <h1 class>
    <img src="/_assets/images/logo-pixboy.svg" alt="PixBoy" class="hero_logo" />
  </h1>
  <h2 class="hero_title">
    <a href="#create" class="hero_link">Create</a>
    <span class="hero_and"> & </span>
    <a href="#share" class="hero_link">Share</a>
    <span class="hero_sub">Game Boy pixel art</span>
  </h2>
  <div class="hero_more">
    <a href="#sections" class="hero_moreText">Continue</a>
  </div>
</section>

<!-- sections -->
<!-- ----------------------------------------------------------------------- -->
<a class="anchor" id="sections"></a>
<div class="sections">
  <a class="anchor" id="create"></a>
  <section class="section">
    <div class="section_inner">
      <h2 class="section_title">Create</h2>
      <p class="section_text">
        ... your very own Game Boy sprites with a simple online editor.
      </p>
      <img
        src="./create.png"
        alt="Game Boy sprite editor"
        class="section_img"
      />
    </div>
  </section>
  <a class="anchor" id="share"></a>
  <section class="section is-alt">
    <div class="section_inner is-alt">
      <h2 class="section_title">Share</h2>
      <p class="section_text">
        ... your work with the community and explore a public gallery.
      </p>
      <img src="./share.png" alt="A few Game Boy sprites" class="section_img" />
    </div>
  </section>
</div>

<!-- join -->
<!-- ----------------------------------------------------------------------- -->
<section class="join">
  <div class="join_cta">
    <h2 class="join_ctaText">Join now!</h2>
  </div>
  <a href="/sign-up/" class="button is-big">Sign Up</a>
</section>

<!-- info -->
<!-- ----------------------------------------------------------------------- -->
<section class="info">
  <div class="info_inner">
    <p>
      PixBoy is a platform and editor for micro pixel art in the iconic Game Boy
      style. Creativity with only 4 monochromatic shades on a 16x16 grid!
    </p>
    <p>
      Explore the works of others or give it a try yourself with our intuitive
      and simple online editor – no installation necessary!
    </p>
  </div>
</section>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'css' => ['./style.css'],
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>
