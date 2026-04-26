<?php
/** @var \Kirby\Cms\Page $page */
/** @var \Kirby\Cms\Site $site */
$current = $page->id();

// Portrait de Proust : image associée à la page d'accueil, utilisée
// comme décor fixe à droite sur toutes les pages sauf la home (où le
// portrait est déjà intégré dans le hero split-screen).
$pagePortrait = $page->isHomePage() ? null : (
    page('home')?->images()->template('photo')->first()
    ?? page('home')?->images()->first()
);
?><!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $page->isHomePage() ? 'En Plein Proust' : $page->title() . ' — En Plein Proust' ?></title>
<meta name="description" content="<?= $page->metaDescription()->or('Lecture & écoute collective en 24h sans interruption d\'À la recherche du temps perdu de Marcel Proust, aux Ateliers Mommen à Bruxelles.')->escape() ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Chau+Philomene+One&family=Inter:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&display=swap">

<?php
$cssPath = kirby()->root('index') . '/assets/css/main.css';
$cssVer = file_exists($cssPath) ? filemtime($cssPath) : '1';
?>
<link rel="stylesheet" href="<?= url('assets/css/main.css') ?>?v=<?= $cssVer ?>">

<meta property="og:title" content="En Plein Proust">
<meta property="og:description" content="Lecture en 24h d'À la recherche du temps perdu, aux Ateliers Mommen à Bruxelles.">
<meta property="og:type" content="website">
</head>
<body data-page="<?= $current ?>">

<header class="site-header">
  <div class="container site-header__inner">
    <a href="<?= url() ?>" class="site-logo">
      EN PLEIN <span>PROUST</span>
    </a>
    <button class="site-nav__toggle" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="site-nav">
      <span class="site-nav__toggle-bar"></span>
      <span class="site-nav__toggle-bar"></span>
      <span class="site-nav__toggle-bar"></span>
    </button>
    <nav id="site-nav" class="site-nav" aria-label="Navigation principale">
      <?php foreach ($site->children()->listed() as $item): ?>
        <a href="<?= $item->url() ?>" class="<?= $item->isOpen() ? 'is-active' : '' ?>"><?= $item->title()->escape() ?></a>
      <?php endforeach ?>
    </nav>
  </div>
</header>
<button class="site-nav__backdrop" aria-hidden="true" tabindex="-1"></button>

<?php if ($pagePortrait): ?>
<div class="page-portrait" aria-hidden="true">
  <img src="<?= $pagePortrait->url() ?>" alt="" loading="eager">
</div>
<?php endif ?>

<main class="<?= $pagePortrait ? 'has-page-portrait' : '' ?>">
