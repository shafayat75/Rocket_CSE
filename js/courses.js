document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal');
  const addCourseBtn = document.getElementById('addCourseBtn');
  const closeModalBtn = document.getElementById('closeModal');
  const courseForm = document.getElementById('courseForm');
  const coursesTableBody = document.querySelector('#coursesTable tbody');
  const formTitle = document.getElementById('formTitle');
  const submitBtn = document.getElementById('submitBtn');

  let editId = null;

  function openModal(edit = false) {
    modal.style.display = 'block';
    if (edit) {
      formTitle.textContent = 'Edit Course';
      submitBtn.textContent = 'Update Course';
    } else {
      formTitle.textContent = 'Add Course';
      submitBtn.textContent = 'Add Course';
      courseForm.reset();
      editId = null;
      document.getElementById('courseId').value = '';
    }
  }

  function closeModal() {
    modal.style.display = 'none';
  }

  closeModalBtn.onclick = closeModal;
  window.onclick = e => {
    if (e.target == modal) closeModal();
  };

  addCourseBtn.addEventListener('click', () => openModal(false));

  // Fetch courses from server and render table
  function fetchCourses() {
    fetch('courses.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: new URLSearchParams({ action: 'fetch' })
    })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        renderTable(res.data);
      } else {
        alert('Failed to fetch courses: ' + (res.message || 'Unknown error'));
      }
    })
    .catch(error => {
      console.error('Fetch error:', error);
      alert('Network error fetching courses');
    });
  }

  // Render courses in table
  function renderTable(courses) {
    coursesTableBody.innerHTML = '';
    if (courses.length === 0) {
      coursesTableBody.innerHTML = `<tr><td colspan="4" style="text-align:center;">No courses added yet.</td></tr>`;
      return;
    }
    courses.forEach((course, index) => {
      const tr = document.createElement('tr');

      tr.innerHTML = `
        <td>${index + 1}</td>
        <td>${course.course_name}</td>
        <td>${course.course_code}</td>
        <td>
          <button class="edit" data-id="${course.id}" data-name="${course.course_name}" data-code="${course.course_code}">Edit</button>
          <button class="delete" data-id="${course.id}">Delete</button>
        </td>
      `;
      coursesTableBody.appendChild(tr);
    });

    // Add event listeners for edit and delete buttons
    document.querySelectorAll('button.edit').forEach(btn => {
      btn.onclick = () => {
        editId = btn.dataset.id;
        document.getElementById('courseName').value = btn.dataset.name;
        document.getElementById('courseCode').value = btn.dataset.code;
        document.getElementById('courseId').value = editId;
        openModal(true);
      };
    });

    document.querySelectorAll('button.delete').forEach(btn => {
      btn.onclick = () => {
        if (confirm('Are you sure you want to delete this course?')) {
          deleteCourse(btn.dataset.id);
        }
      };
    });
  }

  // Add or update course
  courseForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const courseName = document.getElementById('courseName').value.trim();
    const courseCode = document.getElementById('courseCode').value.trim();
    const id = document.getElementById('courseId').value;

    const action = id ? 'edit' : 'add';

    const data = new URLSearchParams({
      action,
      course_name: courseName,
      course_code: courseCode,
    });
    if (id) data.append('id', id);

    fetch('courses.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: data
    })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        alert(res.message);
        fetchCourses();
        closeModal();
      } else {
        alert(res.message);
      }
    })
    .catch(error => {
      console.error('Fetch error:', error);
      alert('Network error submitting form');
    });
  });

  // Delete course
  function deleteCourse(id) {
    fetch('courses.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: new URLSearchParams({ action: 'delete', id })
    })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        alert(res.message);
        fetchCourses();
      } else {
        alert(res.message);
      }
    })
    .catch(error => {
      console.error('Fetch error:', error);
      alert('Network error deleting course');
    });
  }

  // Initial fetch
  fetchCourses();
});