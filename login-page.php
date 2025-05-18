<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
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

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
  <main class="bg-white rounded-xl max-w-md w-full p-8 drop-shadow-md">
    <h1 class="text-lg font-bold text-center text-gray-800 mb-2">Conquer Group Admin Panel</h1>
    <h2 class="text-sm font-semibold text-center text-gray-700 mb-6">Sign in your account</h2>

    <!-- Message Box -->
    <div id="loginMessage" class="hidden mb-4 p-3 text-sm rounded-lg"></div>

    <!-- Login Form -->
    <form id="loginForm">
      <label class="block text-xs font-semibold text-gray-700 mb-1" for="username">Username</label>
      <input class="w-full rounded-lg border border-gray-200 px-4 py-3 text-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 mb-5"
        id="username" name="username" placeholder="Enter username" type="text" required />

      <label class="block text-xs font-semibold text-gray-700 mb-1" for="password">Password</label>
      <input class="w-full rounded-lg border border-gray-200 px-4 py-3 text-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 mb-5"
        id="password" name="password" placeholder="Enter your password" type="password" required />

      <button type="submit"
        class="mt-4 w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg py-3 transition duration-200">
        Sign in
      </button>
    </form>

    <p class="mt-4 text-xs text-gray-500 text-center">
      Don't have an account?
      <a class="text-blue-700 hover:underline" href="register-page">Sign up</a>
    </p>
  </main>

  <script>
    const form = document.getElementById("loginForm");
    const message = document.getElementById("loginMessage");

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(form);

      fetch("login.php", {
        method: "POST",
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          message.classList.remove("hidden");
          if (data.success) {
            message.className = "mb-4 p-3 text-sm text-green-700 bg-green-100 rounded-lg";
            message.textContent = data.message;
            setTimeout(() => {
              window.location.href = "index"; // Redirect after login
            }, 1000);
          } else {
            message.className = "mb-4 p-3 text-sm text-red-700 bg-red-100 rounded-lg";
            message.textContent = data.message;
          }
        })
        .catch(() => {
          message.classList.remove("hidden");
          message.className = "mb-4 p-3 text-sm text-red-700 bg-red-100 rounded-lg";
          message.textContent = "An error occurred. Please try again.";
        });
    });
  </script>
</body>

</html>
