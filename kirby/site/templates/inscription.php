<?php snippet('header') ?>

<?php
$creneaux = $page->creneauxList()->toStructure();
$min = $page->minCreneaux()->or(2)->toInt();
$max = $page->maxCreneaux()->or(4)->toInt();
$success = $success ?? false;
$alert = $alert ?? null;
$data = $data ?? [];
?>

<section class="section">
  <div class="container">
    <p class="eyebrow reveal">Appel à lecteurices</p>
    <h1 class="display display--xl reveal" style="margin-bottom:var(--s-5);">
      <span>S'inscrire pour</span><br>
      <span class="accent"><?= page('home')->edition()->or(2027) ?></span>
    </h1>

    <?php if ($page->intro()->isNotEmpty()): ?>
      <p class="lead serif-italic reveal" style="font-size:1.3rem;max-width:60ch;margin-bottom:var(--s-5);">
        <?= $page->intro()->kt() ?>
      </p>
    <?php endif ?>

    <?php if ($success): ?>
      <div class="form" style="text-align:center;padding:var(--s-5) 0;">
        <h2 class="display display--md accent"><?= $page->merciTitre()->or('Merci pour votre inscription')->escape() ?></h2>
        <p class="serif" style="font-size:1.2rem;max-width:50ch;margin:var(--s-3) auto;">
          <?= $page->merciTexte()->or('Votre inscription a bien été reçue.')->kt() ?>
        </p>
        <p style="margin-top:var(--s-4);">
          <a href="<?= url() ?>" class="btn btn--ghost">Retour à l'accueil</a>
        </p>
      </div>
    <?php else: ?>

    <form
      class="form"
      method="post"
      action="<?= $page->url() ?>"
      data-form-inscription
      data-min-creneaux="<?= $min ?>"
      data-max-creneaux="<?= $max ?>"
    >
      <?php if ($alert): ?>
        <div class="form__messages form__messages--err"><?= esc($alert) ?></div>
      <?php endif ?>

      <div class="form__row">
        <div class="form__field">
          <label class="form__label" for="prenom">Prénom <span class="required">*</span></label>
          <input class="form__input" type="text" id="prenom" name="prenom" value="<?= esc($data['prenom'] ?? '') ?>" required>
        </div>
        <div class="form__field">
          <label class="form__label" for="nom">Nom <span class="required">*</span></label>
          <input class="form__input" type="text" id="nom" name="nom" value="<?= esc($data['nom'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form__row">
        <div class="form__field">
          <label class="form__label" for="email">Email <span class="required">*</span></label>
          <input class="form__input" type="email" id="email" name="email" value="<?= esc($data['email'] ?? '') ?>" required>
        </div>
        <div class="form__field">
          <label class="form__label" for="telephone">Téléphone (optionnel)</label>
          <input class="form__input" type="tel" id="telephone" name="telephone" value="<?= esc($data['telephone'] ?? '') ?>">
        </div>
      </div>

      <?php if ($creneaux->count() > 0): ?>
      <div class="form__field form__field--full" style="margin-bottom:var(--s-3);">
        <label class="form__label">Créneaux préférés <span class="required">*</span> <span class="muted" style="text-transform:none;letter-spacing:0;font-size:0.85rem;">— <?= $min ?> minimum, <?= $max ?> maximum</span></label>
        <div class="form__creneaux">
          <?php foreach ($creneaux as $c): ?>
            <?php $checked = in_array($c->label()->value(), $data['creneaux'] ?? [], true) ? 'checked' : '' ?>
            <label class="form__creneau">
              <input type="checkbox" name="creneaux[]" value="<?= $c->label()->escape() ?>" <?= $checked ?>>
              <span><?= $c->label()->escape() ?></span>
            </label>
          <?php endforeach ?>
        </div>
        <p class="form__hint" data-creneaux-counter>
          <span data-creneaux-counter-text>0 sélectionné</span>
        </p>
      </div>
      <?php else: ?>
      <div class="form__field form__field--full" style="margin-bottom:var(--s-3);">
        <label class="form__label">Préférences de créneaux</label>
        <textarea class="form__textarea" name="creneauxLibre" placeholder="Indiquez vos préférences (jour, plage horaire) — entre <?= $min ?> et <?= $max ?> créneaux d'1h"><?= esc($data['creneauxLibre'] ?? '') ?></textarea>
        <p class="form__hint">Les créneaux précis seront publiés ici dès qu'ils seront fixés. En attendant, indiquez vos disponibilités.</p>
      </div>
      <?php endif ?>

      <div class="form__field form__field--full" style="margin-bottom:var(--s-3);">
        <label class="form__label" for="message">Message (optionnel)</label>
        <textarea class="form__textarea" id="message" name="message" placeholder="Première fois ? Question ? Mot pour Nathalie ?"><?= esc($data['message'] ?? '') ?></textarea>
      </div>

      <label class="form__rgpd" style="margin-bottom:var(--s-3);">
        <input type="checkbox" name="consentementRgpd" value="1" required>
        <span>J'accepte que mes informations soient utilisées par les organisateur·ices d'En Plein Proust pour la gestion des inscriptions. Je peux demander leur suppression à tout moment.</span>
      </label>

      <input type="hidden" name="website" value="" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;">

      <button type="submit" class="btn">Envoyer mon inscription</button>

      <?php if ($page->conditions()->isNotEmpty()): ?>
        <p class="muted" style="margin-top:var(--s-4);font-size:0.9rem;">
          <?= $page->conditions()->kt() ?>
        </p>
      <?php endif ?>
    </form>

    <?php endif ?>
  </div>
</section>

<?php snippet('footer') ?>
