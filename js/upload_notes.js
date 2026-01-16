// Handles choose-file button, list rendering, and drag & drop
const chooseBtn = document.getElementById('chooseBtn');
const input = document.getElementById('notes');
const list = document.getElementById('fileList');
const drop = document.getElementById('dropzone');

if (chooseBtn && input) {
  chooseBtn.addEventListener('click', () => input.click());
  input.addEventListener('change', () => renderList(input.files));
}

if (drop) {
  ['dragenter','dragover'].forEach(evt => {
    drop.addEventListener(evt, e => {
      e.preventDefault(); e.stopPropagation();
      drop.classList.add('dragover');
    });
  });
  ['dragleave','drop'].forEach(evt => {
    drop.addEventListener(evt, e => {
      e.preventDefault(); e.stopPropagation();
      if (evt === 'drop') {
        const dt = e.dataTransfer;
        if (dt && dt.files && dt.files.length) {
          input.files = dt.files; // assign files to the hidden input
          renderList(input.files);
        }
      }
      drop.classList.remove('dragover');
    });
  });
}

function renderList(files) {
  if (!files || !files.length) { list.innerHTML = ''; return; }
  let html = '<strong>Selected:</strong><ul style="margin:6px 0 0 18px">';
  for (const f of files) {
    html += `<li>${escapeHtml(f.name)} <span style="color:#7a889c">(${Math.round(f.size/1024)} KB)</span></li>`;
  }
  html += '</ul>';
  list.innerHTML = html;
}

function escapeHtml(s){
  return s.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}
