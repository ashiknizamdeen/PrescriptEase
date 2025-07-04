document.addEventListener("DOMContentLoaded", function () {
  // File upload preview
  const fileInputs = document.querySelectorAll('input[type="file"]');
  fileInputs.forEach((input) => {
    input.addEventListener("change", function (e) {
      const files = e.target.files;
      const preview = document.getElementById("imagePreview");

      if (preview) {
        preview.innerHTML = "";

        for (let i = 0; i < Math.min(files.length, 5); i++) {
          const file = files[i];
          if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
              const img = document.createElement("img");
              img.src = e.target.result;
              img.style.maxWidth = "150px";
              img.style.margin = "5px";
              img.style.border = "1px solid #ddd";
              preview.appendChild(img);
            };
            reader.readAsDataURL(file);
          }
        }
      }
    });
  });

  const deleteButtons = document.querySelectorAll(".btn-delete");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      if (!confirm("Are you sure you want to delete this item?")) {
        e.preventDefault();
      }
    });
  });

  const quotationForm = document.getElementById("quotationForm");
  if (quotationForm) {
    quotationForm.addEventListener("input", function (e) {
      if (e.target.name === "quantity[]" || e.target.name === "unit_price[]") {
        calculateTotal();
      }
    });
  }

  function calculateTotal() {
    const quantities = document.querySelectorAll('input[name="quantity[]"]');
    const unitPrices = document.querySelectorAll('input[name="unit_price[]"]');
    let total = 0;

    for (let i = 0; i < quantities.length; i++) {
      const qty = parseFloat(quantities[i].value) || 0;
      const price = parseFloat(unitPrices[i].value) || 0;
      total += qty * price;
    }

    const totalDisplay = document.getElementById("totalAmount");
    if (totalDisplay) {
      totalDisplay.textContent = "$" + total.toFixed(2);
    }
  }

  const menuToggle = document.querySelector(".menu-toggle");
  const navMenu = document.querySelector(".nav-menu");

  if (menuToggle && navMenu) {
    menuToggle.addEventListener("click", function () {
      navMenu.classList.toggle("active");
    });
  }
});
