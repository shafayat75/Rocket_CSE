

document.getElementById("searchInput").addEventListener("keyup", function() {
  let filter = this.value.toLowerCase();
  document.querySelectorAll(".menu li a").forEach(item => {
    let text = item.textContent.toLowerCase();
    if (text.includes(filter)) {
      item.parentElement.style.display = "block";
    } else {
      item.parentElement.style.display = "none";
    }
  });
});