<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register</title>
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

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
  <main class="bg-white rounded-xl max-w-md w-full p-8 drop-shadow-md">
    <h1 class="text-lg font-bold text-center text-gray-800 mb-2">Conquer Group Admin Panel</h1>
    <h2 class="text-sm font-semibold text-center text-gray-700 mb-6">Sign up your account</h2>

    <!-- Message Box -->
    <div id="messageBox" class="hidden mb-4 p-3 text-sm rounded-lg"></div>

    <!-- Registration Form -->
    <form id="registerForm" autocomplete="on">
      <!-- Username -->
      <label for="username" class="block text-xs font-semibold text-gray-700 mb-1">Username</label>
      <input id="username" name="username" type="text" required autocomplete="username"
        placeholder="Enter username"
        class="w-full rounded-lg border border-gray-200 px-4 py-3 text-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent mb-5" />

      <!-- Email -->
      <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
      <input id="email" name="email" type="email" required autocomplete="email"
        placeholder="hello@example.com"
        class="w-full rounded-lg border border-gray-200 px-4 py-3 text-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent mb-5" />

      <!-- Password -->
      <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">Password</label>
      <input id="password" name="password" type="password" required autocomplete="new-password"
        placeholder="Enter your password"
        class="w-full rounded-lg border border-gray-200 px-4 py-3 text-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent mb-5" />

      <!-- Submit -->
      <button type="submit"
        class="mt-6 w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg py-3 transition duration-200">
        Sign up
      </button>
    </form>

    <!-- Login Redirect -->
    <p class="mt-4 text-xs text-gray-500 text-center">
      Already have an account?
      <a href="login-page" class="text-blue-700 hover:underline">Sign in</a>
    </p>
  </main>

  <script>
    const form = document.getElementById("registerForm");
    const messageBox = document.getElementById("messageBox");

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(form);

      fetch("register.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          messageBox.classList.remove("hidden");

          if (data.success) {
            messageBox.className =
              "mb-4 p-3 text-sm text-green-700 bg-green-100 rounded-lg";
            messageBox.textContent = data.message;
            form.reset();
          } else {
            messageBox.className =
              "mb-4 p-3 text-sm text-red-700 bg-red-100 rounded-lg";
            messageBox.textContent = data.message;
          }
        })
        .catch((err) => {
          messageBox.classList.remove("hidden");
          messageBox.className =
            "mb-4 p-3 text-sm text-red-700 bg-red-100 rounded-lg";
          messageBox.textContent = "Something went wrong!";
        });
    });
  </script>
</body>

</html>
