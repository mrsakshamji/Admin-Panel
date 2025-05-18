<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login-page");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Delete Property</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="Image/favicon.png" type="image/x-icon">
    <style>
        body {
            font-family: "Poppins", sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">
  <div class="flex flex-col lg:flex-row w-full">
    <?php require 'components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-h-screen min-w-0">
      <?php require 'components/header.php'; ?>

      <main class="bg-[#f3f4f6] px-4 sm:px-6 lg:px-8 py-6 w-full max-w-7xl mx-auto">

        <!-- Navigation -->
        <nav class="bg-white rounded-lg py-3 px-5 text-sm text-gray-600 flex flex-wrap gap-1 shadow-sm mb-6">
          <span>Property</span>
          <span class="text-gray-400">/</span>
         <a href="property-edit"> <span class="font-semibold text-[#1e2a78] cursor-pointer">Delete Property</span></a>
        </nav>

        <!-- Search Form -->
        <form id="searchForm"
          class="flex flex-col sm:flex-row gap-4 mb-6 bg-white p-4 rounded-lg shadow w-full">
          <input type="number" name="property_id" id="property_id" placeholder="Enter Property ID"
            class="border border-gray-300 rounded px-3 py-2 text-sm w-full sm:w-auto flex-1" required />
          <button type="submit"
            class="bg-[#3a4dbf] text-white font-semibold py-2 px-4 rounded hover:bg-[#1e2a78]">Search</button>
        </form>

        <!-- Result Section -->
        <section id="propertyResult" class="hidden bg-white p-6 rounded-lg shadow w-full overflow-auto"></section>

      </main>
    </div>
  </div>

  <?php require 'components/footer.php'; ?>

  <script>
    const searchForm = document.getElementById('searchForm');
    const resultSection = document.getElementById('propertyResult');

    searchForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const id = document.getElementById('property_id').value;

      fetch(`property-fetch.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            const p = data.property;
            resultSection.innerHTML = `
              <div class="mb-4">
                <h2 class="text-lg font-bold text-[#3a4dbf]">Property ID: ${p.id}</h2>
                <p class="text-sm text-gray-500">${p.title}</p>
              </div>
              <img src="${p.img}" alt="Property Image" class="w-30 max-h-64 object-cover rounded mb-4">
              <p><strong>Location:</strong> ${p.location}</p>
              <p><strong>Type:</strong> ${p.type}</p>
              <p><strong>Price: </strong>${p.price}</p>
              <div class="mt-6 flex flex-col sm:flex-row gap-4">
                <button onclick="deleteProperty(${p.id})" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
              </div>
            `;
            resultSection.classList.remove('hidden');
          } else {
            resultSection.innerHTML = `<p class="text-red-500">${data.message}</p>`;
            resultSection.classList.remove('hidden');
          }
        });
    });
  </script>
  <script>
  function deleteProperty(id) {
    if (confirm("Are you sure you want to delete this property?")) {
      fetch(`property-delete.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert(data.message);
            document.getElementById('propertyResult').classList.add('hidden');
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch(err => {
          console.error("Deletion error:", err);
          alert("An error occurred while deleting the property.");
        });
    }
  }
</script>
  <script src="assets/script.js"></script>
</body>

</html>
