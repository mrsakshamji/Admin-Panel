<header class="flex items-center justify-between px-4 md:px-8 py-4 border-b border-gray-200 bg-white sticky top-0 z-20">
    <div class="flex items-center space-x-4">
        <button id="sidebarToggle" class="md:hidden text-gray-600 text-2xl">
            <i class="fas fa-bars"></i>
        </button>
        <form class="hidden sm:flex items-center bg-gray-100 rounded-full px-4 py-2 w-full max-w-xs">
            <input class="bg-transparent text-sm w-full focus:outline-none" type="search" placeholder="Search Here" />
            <button class="text-blue-600 ml-2" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <div class="flex items-center space-x-3">
<a href="logout.php" class="text-red-600">Logout</a>
        <div class="flex items-center space-x-2 border-l pl-4 ml-4">
            <div class="text-right">
                <p class="text-sm font-bold">Admin</p>
            </div>
            <img class="w-10 h-10 rounded-full object-cover" src="Image/user-admin.svg" />
        </div>
    </div>
</header>