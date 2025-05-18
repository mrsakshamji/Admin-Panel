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
    <title>Conquer Dashboard</title>
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
        <?php require'components/sidebar.php'; ?>
        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <?php require'components/header.php'; ?>
            <main class="p-4 md:p-6 bg-gray-50 flex-1">
                <div class="mb-6">
                    <h1 class="text-2xl font-extrabold mb-1">Dashboard</h1>
                    <p class="text-sm text-gray-500">Welcome to Conquer Property Admin Panel</p>
                </div>
                <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                    <a href="index"> <button
                            class="bg-gray-200 text-blue-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-300">Refresh</button></a>
                </div>

                <!-- Total Properties -->
                <section class="bg-[#FF6347] text-white p-6 rounded-lg mb-8 relative">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="Image/building.png" class="w-16 h-16" alt="House icon" />
                            <div>
                                <h2 class="text-lg font-extrabold">Total Properties</h2>
                            </div>
                        </div>
                        <div id="propertyCount" class="text-4xl font-extrabold mt-4 sm:mt-0">Loading...</div>
                    </div>
                </section>
                <script>
                    fetch('get_properties_count.php')
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('propertyCount').textContent = Number(data).toLocaleString();
                        })
                        .catch(error => {
                            console.error('Error fetching property count:', error);
                            document.getElementById('propertyCount').textContent = 'Error';
                        });
                </script>


                <!-- Overview of Properties -->
                <section class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <article class="bg-white rounded-lg p-6 shadow flex items-center justify-between">
                        <div>
                            <h3 id="countApartment" class="text-3xl font-extrabold">Loading...</h3>
                            <p class="font-semibold">Total Apartment</p>
                        </div>
                    </article>
                    <article id="countVilla" class="bg-white rounded-lg p-6 shadow flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-extrabold">Loading...</h3>
                            <p class="font-semibold">Total Villa</p>
                        </div>
                    </article>
                    <article id="countTownhouse"
                        class="bg-white rounded-lg p-6 shadow flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-extrabold">Loading...</h3>
                            <p class="font-semibold">Total Townhouse</p>
                        </div>
                    </article>
                </section>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        fetch("get_property_counts.php")
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById("countApartment").textContent = data.apartments;
                                document.querySelector("#countVilla h3").textContent = data.villas;
                                document.querySelector("#countTownhouse h3").textContent = data.townhouses;
                            })
                            .catch(error => {
                                console.error("Error fetching property counts:", error);
                            });
                    });
                </script>

            </main>
        </div>
    </div>
    <?php require'components/footer.php'; ?>
    <script src="assets/script.js"></script>
</body>

</html>