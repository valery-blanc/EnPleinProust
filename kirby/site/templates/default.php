<?php snippet('header') ?>

<section class="section">
  <div class="container">
    <h1 class="display display--xl reveal" style="margin-bottom:var(--s-4);"><?= $page->title()->escape() ?></h1>

    <?php if ($page->intro()->isNotEmpty()): ?>
      <p class="lead serif-italic reveal" style="font-size:1.3rem;max-width:60ch;margin-bottom:var(--s-5);">
        <?= $page->intro()->kt() ?>
      </p>
    <?php endif ?>

    <div class="prose reveal">
      <?= $page->blocks()->toBlocks() ?>
    </div>
  </div>
</section>

<?php snippet('footer') ?>
