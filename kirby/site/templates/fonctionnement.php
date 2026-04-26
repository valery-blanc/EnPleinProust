<?php snippet('header') ?>

<section class="section">
  <div class="container">
    <p class="eyebrow reveal">Comment ça marche</p>
    <h1 class="display display--xl reveal" style="margin-bottom:var(--s-5);">Le <span class="accent">fonctionnement</span></h1>

    <?php if ($page->intro()->isNotEmpty()): ?>
      <p class="lead serif-italic reveal" style="font-size:1.4rem;max-width:60ch;margin-bottom:var(--s-5);">
        <?= $page->intro()->kt() ?>
      </p>
    <?php endif ?>

    <div class="prose reveal">
      <?php if ($page->blocks()->isNotEmpty()): ?>
        <?= $page->blocks()->toBlocks() ?>
      <?php else: ?>
        <h2>Une lecture collective en 24 heures</h2>
        <p>Depuis 2019, des dizaines de personnes se relaient pendant 24 heures sans interruption pour lire à voix haute un tome de <em>À la recherche du temps perdu</em>. Aux Ateliers Mommen, à Bruxelles. Tout le monde ne lit pas forcément, certain·es viennent juste pour écouter.</p>

        <h2>Le déroulé</h2>
        <p>Le livre est divisé en sections d'environ <strong>10 minutes de lecture</strong>. Chaque lecteur·ice assure au minimum <strong>deux passages</strong>, espacés d'au moins 45 minutes. Il n'est pas nécessaire d'être présent·e tout l'événement : l'expérience d'écoute et de lecture prend tout son sens dans la durée, mais chacun·e module sa présence.</p>

        <p>Les inscriptions se font par <a href="<?= url('inscription') ?>">le formulaire en ligne</a>. Vous indiquez vos préférences en termes de créneaux d'1h (2 minimum, 4 maximum) ; nous vous transmettons ensuite l'ordre de passage exact par email.</p>

        <h2>L'édition à utiliser</h2>
        <p>Munissez-vous de la <strong>dernière édition Folio classique 2022</strong> (édition révisée et augmentée). Notre partenaire la <a href="https://editionsmeteores.com/librairie/" target="_blank" rel="noopener">Librairie Météores</a> tient quelques exemplaires.</p>

        <h2>Le bar, l'auberge espagnole, l'espace douillet</h2>
        <p>Le bar reste ouvert pendant les 24 heures. Une <em>auberge espagnole</em> permet à chacun·e de garnir la table de collations (thé et café gratuits, soupe attendue). Si vous lisez la nuit, prenez votre couverture, votre coussin, tout ce dont vous avez besoin pour passer de longues heures dans cet espace douillet.</p>

        <blockquote>
          La nuit, les personnages du livre semblent tournoyer dans la pièce à nos côtés. — Nathalie
        </blockquote>

        <h2>Pourquoi le faire ?</h2>
        <p>Lire Proust à voix haute, c'est ressentir ce flux, cette musicalité du texte dans son corps, ressentir un souffle qui s'étiole et se recharge. Une cordée bien soudée, une succession de voix toutes singulières, qui apportent au texte une dimension qu'on ne perçoit pas seul·e dans son coin.</p>
      <?php endif ?>
    </div>

    <div class="reveal" style="margin-top:var(--s-6);text-align:center;">
      <a href="<?= url('inscription') ?>" class="btn">S'inscrire pour 2027</a>
    </div>
  </div>
</section>

<?php snippet('footer') ?>
