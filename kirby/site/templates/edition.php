<?php snippet('header') ?>

<?php
$cover = $page->couverture()->toFile() ?? $page->images()->template('photo')->first();
$dateStart = $page->dateDebut()->toDate('d/m/Y');
$dateEnd = $page->dateFin()->toDate('d/m/Y');
$year = $page->dateDebut()->toDate('Y');
$videos = $page->videos()->toStructure();
$temoignages = $page->temoignages()->toStructure();
$liens = $page->liens()->toStructure();
$gallery = $page->images()->template('photo');
$audios = $page->files()->template('audio');
?>

<section class="edition-header">
  <div class="container">
    <p class="eyebrow"><a href="<?= page('editions')->url() ?>">← Toutes les éditions</a></p>

    <p class="edition-header__year"><?= $year ?></p>
    <h1 class="edition-header__title"><?= $page->titreEdition()->or($page->tomeTitre())->escape() ?></h1>
    <p class="serif-italic muted" style="font-size:1.3rem;margin:0 0 var(--s-4);">
      Tome <?= $page->tomeNumero() ?> — <?= $page->tomeTitre()->escape() ?>
    </p>
    <div class="edition-header__meta">
      <?php if ($dateStart): ?>
        <div>Dates<strong><?= esc($dateStart) ?><?php if ($dateEnd && $dateEnd !== $dateStart): ?> — <?= esc($dateEnd) ?><?php endif ?></strong></div>
      <?php endif ?>
      <?php if ($page->lieu()->isNotEmpty()): ?>
        <div>Lieu<strong><?= $page->lieu()->escape() ?></strong></div>
      <?php endif ?>
      <?php if ($page->organisateurices()->isNotEmpty()): ?>
        <div>Avec<strong><?= esc(implode(' · ', $page->organisateurices()->split(','))) ?></strong></div>
      <?php endif ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container" style="display:grid;grid-template-columns:<?= $cover ? '1fr 2fr' : '1fr' ?>;gap:var(--s-5);align-items:start;">
    <?php if ($cover): ?>
      <img src="<?= $cover->url() ?>" alt="<?= $cover->alt()->or($page->title())->escape() ?>" style="aspect-ratio:3/4;object-fit:cover;">
    <?php endif ?>
    <div class="prose" style="margin:0;">
      <?php if ($page->description()->isNotEmpty()): ?>
        <?= $page->description()->kt() ?>
      <?php endif ?>
    </div>
  </div>
</section>

<?php if ($temoignages && $temoignages->count() > 0): ?>
<section class="section">
  <div class="container">
    <h2 class="section-title reveal">Témoignages</h2>
    <div class="prose">
      <?php foreach ($temoignages as $t): ?>
        <div class="temoignage reveal">
          <div class="temoignage__texte"><?= $t->texte()->kt() ?></div>
          <span class="temoignage__auteur">
            <?= $t->auteur()->escape() ?><?php if ($t->date()->isNotEmpty()): ?> · <?= $t->date()->toDate('d.m.Y') ?><?php endif ?>
          </span>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>
<?php endif ?>

<?php if ($gallery && $gallery->count() > 0): ?>
<section class="section">
  <div class="container">
    <h2 class="section-title reveal">Galerie</h2>
    <div class="gallery">
      <?php foreach ($gallery as $img): ?>
        <img src="<?= $img->url() ?>" alt="<?= $img->alt()->escape() ?>" loading="lazy">
      <?php endforeach ?>
    </div>
  </div>
</section>
<?php endif ?>

<?php if ($videos && $videos->count() > 0): ?>
<section class="section">
  <div class="container">
    <h2 class="section-title reveal">Vidéos</h2>
    <?php foreach ($videos as $v): ?>
      <div class="reveal" style="margin-bottom:var(--s-4);">
        <div style="aspect-ratio:16/9;">
          <?= video($v->url(), [], ['style' => 'width:100%;height:100%;border:none;']) ?>
        </div>
        <p class="muted" style="margin-top:var(--s-1);"><?= $v->titre()->escape() ?></p>
      </div>
    <?php endforeach ?>
  </div>
</section>
<?php endif ?>

<?php if ($audios && $audios->count() > 0): ?>
<section class="section">
  <div class="container">
    <h2 class="section-title reveal">Enregistrements</h2>
    <ul class="audio-list">
      <?php foreach ($audios as $a): ?>
        <li>
          <strong><?= $a->titre()->or($a->filename())->escape() ?></strong>
          <?php if ($a->duree()->isNotEmpty()): ?> <span class="muted">· <?= $a->duree()->escape() ?></span><?php endif ?>
          <audio controls src="<?= $a->url() ?>"></audio>
        </li>
      <?php endforeach ?>
    </ul>
  </div>
</section>
<?php endif ?>

<?php if ($liens && $liens->count() > 0): ?>
<section class="section">
  <div class="container">
    <h2 class="section-title reveal">Liens</h2>
    <ul class="prose" style="list-style:none;padding:0;">
      <?php foreach ($liens as $l): ?>
        <li><a href="<?= $l->url() ?>" target="_blank" rel="noopener" style="color:var(--c-accent);">→ <?= $l->titre()->escape() ?></a></li>
      <?php endforeach ?>
    </ul>
  </div>
</section>
<?php endif ?>

<?php snippet('footer') ?>
