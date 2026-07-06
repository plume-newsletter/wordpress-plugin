document.addEventListener('submit', function (e) {
  var form = e.target;
  if (!form.classList || !form.classList.contains('plume-signup')) return;
  e.preventDefault();
  var btn = form.querySelector('button');
  if (btn) btn.disabled = true;
  fetch(form.action, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    body: new FormData(form)
  }).then(function (r) { return r.json(); }).then(function (res) {
    var p = document.createElement('p');
    p.className = 'plume-notice plume-notice-' + (res.ok ? 'ok' : 'error');
    p.textContent = res.message || '';
    form.parentNode.insertBefore(p, form);
    if (res.ok) form.reset();
    if (btn) btn.disabled = false;
  }).catch(function () { if (btn) btn.disabled = false; form.submit(); });
});
