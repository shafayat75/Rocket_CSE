// Handles choose button and file display
const chooseBtn = document.getElementById('chooseBtn');
const input     = document.getElementById('video');
const chosen    = document.getElementById('fileChosen');

if (chooseBtn && input && chosen) {
  chooseBtn.addEventListener('click', () => input.click());

  input.addEventListener('change', () => {
    if (input.files && input.files[0]) {
      chosen.textContent = input.files[0].name + ' (' + Math.round(input.files[0].size/1024) + ' KB)';
    } else {
      chosen.textContent = 'No file selected';
    }
  });
}
