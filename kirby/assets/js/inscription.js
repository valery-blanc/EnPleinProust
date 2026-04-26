// Validation 2-4 créneaux pour le formulaire d'inscription
(() => {
  const form = document.querySelector('[data-form-inscription]');
  if (!form) return;

  const min = parseInt(form.dataset.minCreneaux, 10) || 2;
  const max = parseInt(form.dataset.maxCreneaux, 10) || 4;

  const checkboxes = form.querySelectorAll('input[name="creneaux[]"]');
  const counter = form.querySelector('[data-creneaux-counter]');
  const counterText = form.querySelector('[data-creneaux-counter-text]');
  const submit = form.querySelector('button[type="submit"]');

  const update = () => {
    const selected = Array.from(checkboxes).filter((cb) => cb.checked);
    const count = selected.length;

    checkboxes.forEach((cb) => {
      cb.parentElement.classList.toggle('is-selected', cb.checked);
      cb.disabled = !cb.checked && count >= max;
    });

    if (counterText) {
      counterText.textContent = `${count} sélectionné${count > 1 ? 's' : ''}`;
    }

    let valid = count >= min && count <= max;
    if (counter) {
      counter.classList.toggle('form__hint--warn', !valid);
      if (count < min) {
        counter.textContent = `Sélectionnez au moins ${min} créneau${min > 1 ? 'x' : ''} (${count}/${min})`;
      } else if (count >= max) {
        counter.textContent = `Maximum ${max} créneaux atteint`;
      } else {
        counter.textContent = `${count} créneau${count > 1 ? 'x' : ''} sélectionné${count > 1 ? 's' : ''} (${min}-${max})`;
      }
    }
    if (submit) submit.disabled = !valid;
  };

  checkboxes.forEach((cb) => cb.addEventListener('change', update));
  update();
})();
