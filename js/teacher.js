document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal');
  const addBtn = document.getElementById('addTeacherBtn');
  const closeModalBtn = document.getElementById('closeModal');
  const form = document.getElementById('teacherForm');
  const tableBody = document.querySelector('#teacherTable tbody');
  const formTitle = document.getElementById('formTitle');
  const submitBtn = document.getElementById('submitBtn');

  let editId = null;

  // Open modal
  function openModal(isEdit = false) {
    modal.style.display = 'block';
    if (isEdit) {
      formTitle.textContent = 'Edit Teacher';
      submitBtn.textContent = 'Update Teacher';
    } else {
      form.reset();
      formTitle.textContent = 'Add Teacher';
      submitBtn.textContent = 'Add Teacher';
      editId = null;
    }
  }

  // Close modal
  function closeModal() {
    modal.style.display = 'none';
  }

  // Close modal on overlay click
  window.onclick = e => {
    if (e.target == modal) closeModal();
  };
  closeModalBtn.onclick = closeModal;

  // Open modal on Add button click
  addBtn.onclick = () => openModal(false);

  // Fetch all teachers
  function fetchTeachers() {
    fetch('../php/teacher.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ action: 'fetch' })
    })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          renderTable(res.data);
        } else {
          alert(res.message || 'Failed to fetch data.');
        }
      })
      .catch(err => {
        console.error('Fetch error:', err);
        alert('Network error fetching teacher data.');
      });
  }

  // Render table
  function renderTable(teachers) {
    tableBody.innerHTML = '';

    if (teachers.length === 0) {
      tableBody.innerHTML = `<tr><td colspan="5" style="text-align:center;">No teachers added yet.</td></tr>`;
      return;
    }

    teachers.forEach((teacher, index) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${index + 1}</td>
        <td>${teacher.teacher_name}</td>
        <td>${teacher.email}</td>
        <td>${teacher.password}</td>
        <td>
          <button class="edit" data-id="${teacher.id}" data-name="${teacher.teacher_name}" data-email="${teacher.email}" data-password="${teacher.password}">Edit</button>
          <button class="delete" data-id="${teacher.id}">Delete</button>
        </td>
      `;
      tableBody.appendChild(tr);
    });

    // Set up edit 
    document.querySelectorAll('button.edit').forEach(btn => {
      btn.onclick = () => {
        editId = btn.dataset.id;
        document.getElementById('teacherName').value = btn.dataset.name;
        document.getElementById('teacherEmail').value = btn.dataset.email;
        document.getElementById('teacherPassword').value = btn.dataset.password;
        document.getElementById('teacherId').value = editId;
        openModal(true);
      };
    });

    // Set up delete buttons
    document.querySelectorAll('button.delete').forEach(btn => {
      btn.onclick = () => {
        if (confirm("Are you sure you want to delete this teacher?")) {
          deleteTeacher(btn.dataset.id);
        }
      };
    });
  }

  // Delete teacher
  function deleteTeacher(id) {
    fetch('../php/teacher.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ action: 'delete', id })
    })
      .then(res => res.json())
      .then(res => {
        alert(res.message);
        if (res.status === 'success') fetchTeachers();
      })
      .catch(err => {
        console.error('Delete error:', err);
        alert('Network error deleting teacher.');
      });
  }

  // Submit form (Add or Edit)
  form.onsubmit = (e) => {
    e.preventDefault();

    const name = document.getElementById('teacherName').value.trim();
    const email = document.getElementById('teacherEmail').value.trim();
    const password = document.getElementById('teacherPassword').value.trim();
    const id = document.getElementById('teacherId').value;

    if (!name || !email || !password) {
      alert('All fields are required.');
      return;
    }

    const action = id ? 'edit' : 'add';

    const data = new URLSearchParams({
      action,
      teacher_name: name,
      email: email,
      password: password
    });

    if (id) data.append('id', id);

    fetch('../php/teacher.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: data
    })
      .then(res => res.json())
      .then(res => {
        alert(res.message);
        if (res.status === 'success') {
          fetchTeachers();
          closeModal();
        }
      })
      .catch(err => {
        console.error('Submit error:', err);
        alert('Network error submitting data.');
      });
  };

  // Initial fetch
  fetchTeachers();
});
