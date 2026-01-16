// Toggle subject "Other" field
const subjectSelect = document.getElementById('subject_select');
const subjectOther  = document.getElementById('subject_other');
if (subjectSelect && subjectOther) {
  subjectSelect.addEventListener('change', () => {
    const show = subjectSelect.value === 'Other';
    subjectOther.style.display = show ? 'inline-block' : 'none';
    subjectOther.required = show;
    if (!show) subjectOther.value = '';
  });
}

// Toggle duration "Custom" field
const durationSelect = document.getElementById('duration_select');
const durationOther  = document.getElementById('duration_other');
if (durationSelect && durationOther) {
  durationSelect.addEventListener('change', () => {
    const show = durationSelect.value === 'custom';
    durationOther.style.display = show ? 'inline-block' : 'none';
    durationOther.required = show;
    if (!show) durationOther.value = '';
  });
}

// File chooser
const chooseBtn = document.getElementById('chooseBtn');
const quizFile  = document.getElementById('quiz_file');
const chosen    = document.getElementById('chosenName');
if (chooseBtn && quizFile && chosen) {
  chooseBtn.addEventListener('click', () => quizFile.click());
  quizFile.addEventListener('change', () => {
    chosen.textContent = (quizFile.files && quizFile.files[0]) ? quizFile.files[0].name : 'No file selected';
  });
}

