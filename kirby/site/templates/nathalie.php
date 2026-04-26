<?php snippet('header') ?>

<?php
$videoUrl = $page->videoUrl()->or('https://www.youtube.com/watch?v=FHZyMDgpc1g');
?>

<section class="section">
  <div class="container">
    <p class="eyebrow reveal">Interview</p>
    <h1 class="display display--xl reveal" style="margin-bottom:var(--s-5);">
      <span>Nathalie</span><br>
      <span class="accent">Vanderlinden</span>
    </h1>

    <div class="reveal" style="aspect-ratio:16/9;margin-bottom:var(--s-5);">
      <?= video($videoUrl, [], ['style' => 'width:100%;height:100%;border:none;']) ?>
    </div>

    <?php if ($page->citation()->isNotEmpty()): ?>
      <blockquote class="reveal" style="border-left:2px solid var(--c-accent);padding-left:var(--s-3);margin:var(--s-5) 0;">
        <p class="serif" style="font-size:clamp(1.4rem, 2.5vw, 2rem);font-style:italic;line-height:1.4;margin:0;">
          « <?= $page->citation()->kt() ?> »
        </p>
        <span class="muted" style="display:block;margin-top:var(--s-2);font-family:var(--f-body);font-size:0.85rem;text-transform:uppercase;letter-spacing:0.14em;">
          — <?= $page->citationAuteur()->escape() ?>
        </span>
      </blockquote>
    <?php endif ?>

    <?php if ($page->bio()->isNotEmpty()): ?>
      <div class="prose reveal">
        <?= $page->bio()->kt() ?>
      </div>
    <?php endif ?>
  </div>
</section>

<?php snippet('footer') ?>
