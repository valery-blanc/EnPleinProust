<?php snippet('header') ?>

<section class="section">
  <div class="container">
    <p class="eyebrow reveal">Archives 2019 — <?= date('Y') ?></p>
    <h1 class="display display--xl reveal" style="margin-bottom:var(--s-5);">Toutes les <span class="accent">éditions</span></h1>

    <?php if ($page->intro()->isNotEmpty()): ?>
      <p class="lead serif-italic reveal" style="font-size:1.4rem;max-width:60ch;margin-bottom:var(--s-6);">
        <?= $page->intro()->kt() ?>
      </p>
    <?php endif ?>

    <div class="editions-grid">
      <?php foreach ($page->children()->listed()->sortBy('dateDebut', 'desc') as $edition): ?>
        <?php
          $cover = $edition->couverture()->toFile() ?? $edition->images()->first();
          $year = $edition->dateDebut()->toDate('Y');
        ?>
        <a href="<?= $edition->url() ?>" class="edition-card reveal">
          <?php if ($cover): ?>
            <div class="edition-card__cover">
              <img src="<?= $cover->url() ?>" alt="<?= $cover->alt()->or($edition->title())->escape() ?>">
            </div>
          <?php endif ?>
          <p class="edition-card__year"><?= $year ?></p>
          <p class="edition-card__tome">Tome <?= $edition->tomeNumero() ?> · <?= $edition->tomeTitre()->escape() ?></p>
          <h3 class="edition-card__title"><?= $edition->titreEdition()->or($edition->tomeTitre())->escape() ?></h3>
          <?php if ($edition->description()->isNotEmpty()): ?>
            <p class="muted" style="font-family:var(--f-serif);font-style:italic;margin-top:var(--s-2);font-size:0.95rem;">
              <?= $edition->description()->excerpt(140) ?>
            </p>
          <?php endif ?>
        </a>
      <?php endforeach ?>
    </div>
  </div>
</section>

<?php snippet('footer') ?>
