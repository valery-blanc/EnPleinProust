</main>

<footer class="site-footer">
  <div class="container">
    <div class="site-footer__grid">
      <div class="site-footer__col">
        <h3>En Plein Proust</h3>
        <p>Lecture & écoute collective en 24h sans interruption.<br>
          Aux <strong>Ateliers Mommen</strong>, 37 rue de la Charité,<br>
          1210 Saint-Josse-Ten-Noode, Bruxelles.</p>
      </div>
      <div class="site-footer__col">
        <h3>Contact</h3>
        <ul>
          <li><a href="mailto:24hdeproust@gmail.com">24hdeproust@gmail.com</a></li>
          <li><a href="<?= url('inscription') ?>">S'inscrire</a></li>
          <li><a href="<?= url('editions') ?>">Toutes les éditions</a></li>
          <li><a href="https://www.youtube.com/watch?v=FHZyMDgpc1g" target="_blank" rel="noopener">Interview Nathalie</a></li>
        </ul>
      </div>
      <div class="site-footer__col">
        <h3>Avec le soutien de</h3>
        <div class="site-footer__partners">
          <span>Commune de Saint-Josse</span>
          <span>Fédération Wallonie-Bruxelles</span>
          <span>Francophonies Bruxelles</span>
          <span>Librairie Météores</span>
        </div>
      </div>
    </div>
    <div class="site-footer__bottom">
      <span>© <?= date('Y') ?> En Plein Proust</span>
      <span>Performance gratuite · auberge espagnole · espace douillet</span>
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
