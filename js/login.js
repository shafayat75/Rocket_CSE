document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById("loginForm");

  // Create error message container below form
  const errorMsg = document.createElement("div");
  errorMsg.style.color = "red";
  errorMsg.style.marginTop = "10px";
  form.parentNode.appendChild(errorMsg);

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch("../php/login.php", {
      method: "POST",
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then(data => {
        console.log("Server response:", data);

        if (data.status === "success" && data.redirect) {
          // ✅ Redirect based on server response
          window.location.href = data.redirect;
        } else {
          // ❌ Show error message
          errorMsg.textContent = data.message || "Login failed.";
        }
      })
      .catch(error => {
        console.error("Fetch error:", error);
        errorMsg.textContent = "Something went wrong. Please try again.";
      });
  });
});
