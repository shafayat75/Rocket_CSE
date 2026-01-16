document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("photoInput");
  const img = document.getElementById("previewImg");

  if (!input || !img) return;

  input.addEventListener("change", () => {
    const file = input.files && input.files[0];
    if (!file) return;

    if (!file.type.startsWith("image/")) {
      alert("Please select an image file.");
      input.value = "";
      img.style.display = "none";
      img.removeAttribute("src");
      return;
    }

    const url = URL.createObjectURL(file);
    img.src = url;
    img.style.display = "block";
    img.onload = () => URL.revokeObjectURL(url);
  });
});
