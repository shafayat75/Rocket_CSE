document.addEventListener('DOMContentLoaded', () => {
  const inputs = document.querySelectorAll('input');
  inputs.forEach(input => {
    input.addEventListener('focus', () => {
      input.dataset.placeholder = input.placeholder;
      input.placeholder = '';
    });
    input.addEventListener('blur', () => {
      if (input.value === '') input.placeholder = input.dataset.placeholder;
    });
  });

  const form = document.getElementById("registerForm");
  form.addEventListener("submit", function(e){
    e.preventDefault();

    const fullname = form.fullname.value.trim();
    const phone = form.phone.value.trim();
    const email = form.email.value.trim();
    const password = form.password.value.trim();

    // --- All field must fill check ---
    if (!fullname || !phone || !email || !password) {
      alert("All fields must be filled!");
      return;
    }

    if (!/^[A-Za-z\s]+$/.test(fullname)) {
      alert("Name must contain only alphabetic characters!");
      return;
    }

    if (!/^[0-9]{11}$/.test(phone)) {
      alert("Phone number must contain exactly 11 digits!");
      return;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      alert("Invalid email address!");
      return;
    }

    if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/.test(password)) {
      alert("Password must be at least 8 characters, include one uppercase, one lowercase, one digit, and one special character!");
      return;
    }

    let formData = new FormData(this);

    fetch("../php/register.php", { method:"POST", body:formData })
      .then(res => res.text())
      .then(data => {
        alert(data);
        if(data.includes("Successful")){
          window.location.href = "login.html";
        }
      });
  });
});
