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
  <title>Property List</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="shortcut icon" href="Image/favicon.png" type="image/x-icon" />
  <style>
    body {
      font-family: "Poppins", sans-serif;
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-900 overflow-x-hidden">
  <div class="flex">
    <?php require 'components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-h-screen">
      <?php require 'components/header.php'; ?>

      <main class="bg-[#f3f4f6] px-6 sm:px-10 lg:px-16 py-6 w-full max-w-7xl mx-auto">

        <nav class="bg-white rounded-lg py-3 px-5 text-sm text-gray-600 flex flex-wrap gap-1 shadow-sm mb-6">
          <span>Property</span>
          <span class="text-gray-400">/</span>
          <a href="property-list">
            <span class="font-semibold text-[#1e2a78] cursor-pointer">Property List</span>
          </a>
        </nav>

        <!-- Filter Form -->
        <form id="filterForm" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 bg-white p-4 rounded-lg shadow">
          <input type="text" name="location" id="location" placeholder="Search by location"
            class="border border-gray-300 rounded px-3 py-2 text-sm w-full" />

          <select name="type" id="type" class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
            <option value="">All Types</option>
            <option value="apartments">Apartment</option>
            <option value="villas">Villa</option>
            <option value="townhouses">Townhouse</option>
          </select>

          <button type="submit"
            class="bg-[#3a4dbf] text-white font-semibold py-2 px-4 rounded hover:bg-[#1e2a78]">Filter</button>
        </form>

        <!-- Result Count -->
        <section id="resultCount" class="text-xs text-gray-600 font-normal mb-4"></section>

        <!-- Property Cards Grid -->
        <section id="propertyGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></section>

        <!-- Pagination -->
        <nav id="pagination" class="flex justify-center mt-8 gap-2"></nav>

      </main>
    </div>
  </div>

  <?php require 'components/footer.php'; ?>

  <script>
    const propertyGrid = document.getElementById('propertyGrid');
    const resultCount = document.getElementById('resultCount');
    const pagination = document.getElementById('pagination');
    const filterForm = document.getElementById('filterForm');

    let currentPage = 1;
    const itemsPerPage = 9;

    function fetchProperties(page = 1) {
      const formData = new FormData(filterForm);
      formData.append('page', page);
      formData.append('items_per_page', itemsPerPage);

      fetch('property-list-ajax.php?' + new URLSearchParams(formData).toString())
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            renderProperties(data.properties);
            renderPagination(data.total_pages, page);
            renderResultCount(data.total_results, page, data.properties.length);
          } else {
            propertyGrid.innerHTML = "<p class='col-span-full text-center text-gray-500'>No properties available.</p>";
            pagination.innerHTML = '';
            resultCount.textContent = '';
          }
        }).catch(err => {
          console.error(err);
          propertyGrid.innerHTML = "<p class='col-span-full text-center text-red-500'>Error loading properties.</p>";
          pagination.innerHTML = '';
          resultCount.textContent = '';
        });
    }

    function renderProperties(properties) {
      if (!properties.length) {
        propertyGrid.innerHTML = "<p class='col-span-full text-center text-gray-500'>No properties found.</p>";
        return;
      }
      propertyGrid.innerHTML = properties.map(row => `
        <article
          class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-200">
          <div class="relative">
            <img alt="${escapeHtml(row.alt || '')}" class="w-full h-[220px] object-cover"
              src="${escapeHtml(row.img || '')}" />
            <span
              class="absolute top-3 left-3 bg-[#cbd7ff] text-[#3a4dbf] text-xs font-semibold rounded-md px-3 py-1 flex items-center gap-1">
              <i class="fas fa-map-marker-alt text-[10px]"></i>
              ${escapeHtml(row.location || '')}
            </span>
          </div>
          <div class="p-6">
            <h3 class="font-extrabold text-lg mb-3">
              $${Number(row.price).toFixed(2)}
            </h3>
            <div class="flex items-center gap-5 text-[#3a4dbf] mb-3 text-sm font-semibold">
              <div class="flex items-center gap-1">
                <i class="fas fa-building text-lg"></i>
                <span class="pl-2 text-black font-normal">${capitalize(row.type || '')}</span>
              </div>
              ${row.logo ? `<img src="${escapeHtml(row.logo)}" alt="${escapeHtml(row.logoAlt || '')}" class="max-h-6 max-w-20 object-contain" />` : ''}
            </div>
            <p class="text-gray-400 text-xs leading-5 mb-5">
              ${escapeHtml(row.title || '')}
            </p>
            <hr class="border-gray-200 mb-3" />
          </div>
        </article>
      `).join('');
    }

    function renderResultCount(total, page, count) {
      if (total === 0) {
        resultCount.textContent = "No results found.";
      } else {
        const start = (page - 1) * itemsPerPage + 1;
        const end = start + count - 1;
        resultCount.textContent = `Showing ${start}–${end} of ${total} Results`;
      }
    }

    function renderPagination(totalPages, currentPage) {
      if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
      }

      let html = '';

      // Prev button
      html += `<button ${currentPage === 1 ? 'disabled' : ''} class="px-3 py-1 bg-[#3a4dbf] text-white rounded disabled:opacity-50" data-page="${currentPage - 1}">Prev</button>`;

      // Pages buttons (show max 5 pages)
      let startPage = Math.max(1, currentPage - 2);
      let endPage = Math.min(totalPages, currentPage + 2);
      if (currentPage <= 3) {
        endPage = Math.min(5, totalPages);
      }
      if (currentPage > totalPages - 2) {
        startPage = Math.max(1, totalPages - 4);
      }

      for (let i = startPage; i <= endPage; i++) {
        html += `<button ${i === currentPage ? 'disabled' : ''} class="px-3 py-1 rounded hover:bg-[#3a4dbf] hover:text-white ${i === currentPage ? 'bg-[#3a4dbf] text-white' : 'bg-gray-100'}" data-page="${i}">${i}</button>`;
      }

      // Next button
      html += `<button ${currentPage === totalPages ? 'disabled' : ''} class="px-3 py-1 bg-[#3a4dbf] text-white rounded disabled:opacity-50" data-page="${currentPage + 1}">Next</button>`;

      pagination.innerHTML = html;

      [...pagination.querySelectorAll('button[data-page]')].forEach(btn => {
        btn.addEventListener('click', e => {
          const page = parseInt(e.target.getAttribute('data-page'));
          if (page && page !== currentPage) {
            currentPage = page;
            fetchProperties(currentPage);
          }
        });
      });
    }

    filterForm.addEventListener('submit', e => {
      e.preventDefault();
      currentPage = 1;
      fetchProperties(currentPage);
    });

    function escapeHtml(text) {
      if (!text) return '';
      return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    function capitalize(s) {
      if (!s) return '';
      return s.charAt(0).toUpperCase() + s.slice(1);
    }

    // Initial fetch
    fetchProperties(currentPage);
  </script>
  <script src="assets/script.js"></script>
</body>

</html>
