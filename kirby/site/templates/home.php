<?php snippet('header') ?>

<?php
$portrait = $page->images()->template('photo')->first() ?? $page->images()->first();
$tomeNumero = $page->tomeNumero()->or(6);
$tomeTitre = $page->tomeTitre()->or('Albertine disparue');
$edition = $page->edition()->or(2027);
?>

<section class="hero">
  <div class="hero__content">
    <p class="hero__eyebrow"><?= $page->eyebrow()->or('Lecture & écoute collective en 24h sans interruption') ?></p>
    <h1 class="display display--xxl hero__title">
      <span class="ligne">EN PLEIN</span>
      <span class="ligne ligne--accent">PROUST</span>
    </h1>
    <p class="hero__sub">
      Tome <?= $tomeNumero ?> — <em><?= $tomeTitre->escape() ?></em><br>
      Édition <?= $edition ?><?php if ($page->dates()->isNotEmpty()): ?> · <?= $page->dates()->escape() ?><?php endif ?>
    </p>
    <div class="hero__meta">
      <div>Lieu<strong>Ateliers Mommen, Bruxelles</strong></div>
      <div>Format<strong>24h non-stop · gratuit</strong></div>
    </div>
    <div class="hero__cta">
      <a href="<?= url('inscription') ?>" class="btn"><?= $page->ctaInscription()->or('S\'inscrire comme lecteurice') ?></a>
      <a href="<?= url('fonctionnement') ?>" class="btn btn--ghost">Comment ça marche</a>
    </div>
  </div>
  <div class="hero__portrait">
    <?php if ($portrait): ?>
      <img src="<?= $portrait->url() ?>" alt="Portrait de Marcel Proust">
    <?php else: ?>
      <div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--c-text-faint);font-family:var(--f-serif);font-style:italic;padding:2rem;text-align:center;">
        Portrait de Proust à uploader<br>via le Panel
      </div>
    <?php endif ?>
  </div>
</section>

<?php if ($page->intro()->isNotEmpty()): ?>
<section class="section">
  <div class="container">
    <div class="manifeste reveal">
      <?= $page->intro()->kt() ?>
      <?php if ($page->signature()->isNotEmpty()): ?>
        <span class="signature"><?= $page->signature()->escape() ?></span>
      <?php endif ?>
    </div>
  </div>
</section>
<?php endif ?>

<?php
$editionsPage = page('editions');
$editionsList = $editionsPage ? $editionsPage->children()->listed()->sortBy('dateDebut', 'desc')->limit(4) : null;
?>

<?php if ($editionsList && $editionsList->count() > 0): ?>
<section class="section">
  <div class="container">
    <h2 class="section-title reveal">Toutes les <span class="section-title__accent">éditions</span></h2>
    <div class="editions-grid">
      <?php foreach ($editionsList as $edition): ?>
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
        </a>
      <?php endforeach ?>
    </div>
    <p style="margin-top:var(--s-4);">
      <a href="<?= url('editions') ?>" class="btn btn--ghost">Voir le détail</a>
    </p>
  </div>
</section>
<?php endif ?>

<?php snippet('footer') ?>
