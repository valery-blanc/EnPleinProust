<?php
$footerCopyright   = $site->footerCopyright()->or('En Plein Proust');
$footerEmail       = $site->footerEmail()->or('24hdeproust@gmail.com');
$footerTagline     = $site->footerTagline()->or('Performance gratuite · auberge espagnole · espace douillet');
$footerPartenaires = $site->footerPartenaires()->toStructure();
?>
</main>

<footer class="site-footer">
  <div class="container">
    <div class="site-footer__grid">
      <div class="site-footer__col">
        <h3>En Plein Proust</h3>
        <?php if ($site->footerAdresse()->isNotEmpty()): ?>
          <?= $site->footerAdresse()->kt() ?>
        <?php else: ?>
          <p>Lecture &amp; écoute collective en 24h sans interruption.<br>
            Aux <strong>Ateliers Mommen</strong>, 37 rue de la Charité,<br>
            1210 Saint-Josse-Ten-Noode, Bruxelles.</p>
        <?php endif ?>
      </div>
      <div class="site-footer__col">
        <h3>Contact</h3>
        <ul>
          <li><a href="mailto:<?= $footerEmail->escape() ?>"><?= $footerEmail->escape() ?></a></li>
          <li><a href="<?= url('inscription') ?>">S'inscrire</a></li>
          <li><a href="<?= url('editions') ?>">Toutes les éditions</a></li>
          <li><a href="https://www.youtube.com/watch?v=FHZyMDgpc1g" target="_blank" rel="noopener">Interview Nathalie</a></li>
        </ul>
      </div>
      <div class="site-footer__col">
        <h3>Avec le soutien de</h3>
        <div class="site-footer__partners">
          <?php if ($footerPartenaires->count() > 0): ?>
            <?php foreach ($footerPartenaires as $partner): ?>
              <span><?= $partner->nom()->escape() ?></span>
            <?php endforeach ?>
          <?php else: ?>
            <span>Commune de Saint-Josse</span>
            <span>Fédération Wallonie-Bruxelles</span>
            <span>Francophonies Bruxelles</span>
            <span>Librairie Météores</span>
          <?php endif ?>
        </div>
      </div>
    </div>
    <div class="site-footer__bottom">
      <div class="site-footer__bottom-left">
        <span>© <?= date('Y') ?> <?= $footerCopyright->escape() ?></span>
        <span class="site-footer__credit">Site réalisé par <a href="https://www.zitoon.com" target="_blank" rel="noopener">www.zitoon.com</a></span>
      </div>
      <span><?= $footerTagline->escape() ?></span>
    </div>
  </div>
</footer>

<?php
$jsMainPath = kirby()->root('index') . '/assets/js/main.js';
$jsMainVer  = file_exists($jsMainPath) ? filemtime($jsMainPath) : '1';
?>
<script src="<?= url('assets/js/main.js') ?>?v=<?= $jsMainVer ?>" defer></script>
<?php if ($page->intendedTemplate()->name() === 'inscription'):
  $jsInsPath = kirby()->root('index') . '/assets/js/inscription.js';
  $jsInsVer  = file_exists($jsInsPath) ? filemtime($jsInsPath) : '1';
?>
<script src="<?= url('assets/js/inscription.js') ?>?v=<?= $jsInsVer ?>" defer></script>
<?php endif ?>
</body>
</html>
