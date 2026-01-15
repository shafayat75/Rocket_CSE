document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("modal");

  function openModal() {
    modal.style.display = "block";
  }

  function closeModal() {
    modal.style.display = "none";
    document.getElementById("courseForm").reset();
    document.getElementById("formTitle").textContent = "Add User";
    document.getElementById("courseId").value = "";
  }

  function fetchUsers() {
    const formData = new FormData();
    formData.append("action", "fetch");

    fetch("../php/student_info.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        const tbody = document.querySelector("#coursesTable tbody");
        tbody.innerHTML = "";
        if (data.status === "success") {
          data.data.forEach((user, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
              <td>${index + 1}</td>
              <td>${user.fullname}</td>
              <td>${user.email}</td>
              <td>${user.phone}</td>
              <td>${user.created_at}</td>
              <td>
                <button onclick='editUser(${JSON.stringify(user)})'>Edit</button>
                <button onclick='deleteUser(${user.id})'>Delete</button>
              </td>
            `;
            tbody.appendChild(row);
          });
        }
      });
  }

  window.editUser = function (user) {
    document.getElementById("formTitle").textContent = "Edit User";
    document.getElementById("courseId").value = user.id;
    document.getElementById("fullname").value = user.fullname;
    document.getElementById("email").value = user.email;
    document.getElementById("password").value = ""; // Keep password blank
    document.getElementById("phone").value = user.phone;
    openModal();
  };

  window.deleteUser = function (id) {
    if (confirm("Are you sure you want to delete this user?")) {
      const formData = new FormData();
      formData.append("action", "delete");
      formData.append("id", id);

      fetch("../php/student_info.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          alert(data.message);
          if (data.status === "success") {
            fetchUsers();
          }
        });
    }
  };

  document.getElementById("addstudentBtn").addEventListener("click", openModal);
  document.getElementById("closeModal").addEventListener("click", closeModal);

  document.getElementById("courseForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const id = document.getElementById("courseId").value;
    const fullname = document.getElementById("fullname").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const phone = document.getElementById("phone").value;

    const action = id ? "edit" : "add";

    const formData = new FormData();
    formData.append("action", action);
    if (id) formData.append("id", id);
    formData.append("fullname", fullname);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("phone", phone);

    fetch("../php/student_info.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        alert(data.message);
        if (data.status === "success") {
          closeModal();
          fetchUsers();
        }
      });
  });

  fetchUsers();
});
