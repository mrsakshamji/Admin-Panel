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
    <title>Add Property</title>
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

<body class="bg-white text-gray-900 overflow-x-hidden">
    <div class="flex">
        <?php require 'components/sidebar.php'; ?>
        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <?php require 'components/header.php'; ?>
            <div class="min-h-screen flex flex-col p-4 md:p-6 lg:p-8 bg-gray-100">
                <!-- Breadcrumb -->
                <div class="bg-white rounded-md px-4 py-3 mb-6 text-xs md:text-sm text-[#64748b] select-none max-w-full overflow-x-auto whitespace-nowrap">
                    <span>Property</span>
                    <span class="mx-1">/</span>
                    <a href="add-property" class="text-[#1e40af] font-semibold">Add Property</a>
                </div>

                <!-- Main container -->
                <div class="bg-white rounded-md shadow-sm p-4 md:p-6 lg:p-8 flex-grow">
                    <h2 class="font-semibold text-base md:text-lg mb-6 select-none text-[#0f172a]">Add Property</h2>

                    <form id="property-form" class="space-y-6 text-sm md:text-base text-[#475569]" method="post" action="property-add.php" enctype="multipart/form-data">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Property Type -->
        <div>
            <label for="property-type" class="block mb-1 font-semibold">Property Type</label>
            <select id="property-type" name="property_type" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1e40af]">
                <option value="">Select Property Type</option>
                <option value="apartments">Apartment</option>
                <option value="villas">Villa</option>
                <option value="townhouses">Townhouse</option>
            </select>
        </div>

        <!-- Property Title -->
        <div>
            <label for="property-title" class="block mb-1 font-semibold">Property Title</label>
            <input id="property-title" name="property_title" type="text" placeholder="E.g., 2BHK Apartment in Downtown" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1e40af]" />
        </div>

        <!-- Property Price -->
        <div>
            <label for="property-price" class="block mb-1 font-semibold">Property Price</label>
            <div class="flex items-center border border-gray-300 rounded-md focus-within:ring-2 focus-within:ring-[#1e40af]">
                <span class="px-3 text-gray-600">$</span>
                <input id="property-price" name="property_price" type="number" min="0" step="0.01" placeholder="Enter amount" required
                    class="w-full border-none rounded-r-md px-3 py-2 focus:outline-none" />
            </div>
        </div>

        <!-- Property Alt Text -->
        <div>
            <label for="property-alt" class="block mb-1 font-semibold">Property Alt Text</label>
            <input id="property-alt" name="property_alt" type="text" placeholder="E.g., Front view of the property" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1e40af]" />
        </div>

        <!-- Location -->
        <div>
            <label for="location" class="block mb-1 font-semibold">Location</label>
            <input id="location" name="location" type="text" placeholder="E.g., Downtown" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1e40af]" />
        </div>

        <!-- Logo Alt Text -->
        <div>
            <label for="logo-alt" class="block mb-1 font-semibold">Logo Alt Text</label>
            <input id="logo-alt" name="logo_alt" type="text" placeholder="E.g., Company logo with blue colors" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1e40af]" />
        </div>
    </div>

    <!-- Property Front Image Upload -->
    <div>
        <label class="block mb-1 font-semibold">Property Front Image (Thumbnail)</label>
        <label for="property-front-image-upload"
            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-md cursor-pointer text-gray-400 text-center">
            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
            <span class="text-xs text-gray-700 font-medium">Upload one image showing the front view of the property.</span>
            <input id="property-front-image-upload" name="property_front_image_upload" type="file" accept="image/*" required class="hidden" />
        </label>
        <p id="property-front-image-info" class="mt-1 text-sm text-gray-600">No image selected.</p>
    </div>

    <!-- Logo Upload -->
    <div>
        <label class="block mb-1 font-semibold">Logo</label>
        <label for="logo-upload"
            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-md cursor-pointer text-gray-400 text-center">
            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
            <span class="text-xs text-gray-700 font-medium">Upload your logo image (one file only).</span>
            <input id="logo-upload" name="logo_upload" type="file" accept="image/*" required class="hidden" />
        </label>
        <p id="logo-image-info" class="mt-1 text-sm text-gray-600">No image selected.</p>
    </div>

    <!-- Submit Buttons -->
    <div class="pt-4">
        <button id="submit-btn" type="submit"
            class="bg-[#3730a3] text-white font-semibold px-6 py-2 rounded-md hover:bg-[#2c238a] focus:outline-none focus:ring-2 focus:ring-[#3730a3] focus:ring-offset-1">
            Submit
        </button>
        <div id="form-message" class="mt-2 text-sm text-red-600"></div>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>

    <?php require 'components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const frontImageInput = document.getElementById('property-front-image-upload');
            const frontImageInfo = document.getElementById('property-front-image-info');

            frontImageInput.addEventListener('change', () => {
                const file = frontImageInput.files[0];
                frontImageInfo.textContent = file ? `Selected image: ${file.name}` : 'No image selected.';
            });

            const logoInput = document.getElementById('logo-upload');
            const logoInfo = document.getElementById('logo-image-info');

            logoInput.addEventListener('change', () => {
                const file = logoInput.files[0];
                logoInfo.textContent = file ? `Selected image: ${file.name}` : 'No image selected.';
            });

            const form = document.getElementById('property-form');
            const messageDiv = document.getElementById('form-message');
            const submitBtn = document.getElementById('submit-btn');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                submitBtn.disabled = true;
                messageDiv.style.color = 'black';
                messageDiv.textContent = "Submitting...";

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            messageDiv.style.color = 'green';
                            messageDiv.textContent = data.message;
                            form.reset();
                            document.getElementById('property-front-image-info').textContent = 'No image selected.';
                            document.getElementById('logo-image-info').textContent = 'No image selected.';
                        } else {
                            messageDiv.style.color = 'red';
                            messageDiv.textContent = data.message || 'An error occurred.';
                        }
                    })
                    .catch(() => {
                        messageDiv.style.color = 'red';
                        messageDiv.textContent = 'An unexpected error occurred.';
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                    });
            });
        });
    </script>

    <script src="assets/script.js"></script>
</body>

</html>
