<aside id="sidebar"
    class="fixed md:static top-0 left-0 z-30 h-screen w-64 bg-white border-r border-gray-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

    <div class="flex flex-col h-full justify-between">
        <div>
            <!-- Sidebar Header with Close Button -->
            <div class="flex items-center justify-between px-4 py-6">
                <span class="inline-block font-extrabold text-xl text-gray-900">Conquer Panel</span>
                <!-- Close Button for Mobile -->
                <button id="closeSidebar" class="md:hidden text-gray-600 text-2xl focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mt-6">
                <!-- Main Section -->
                <ul>
                    <li>
                        <div class="flex items-center px-4 py-3 bg-blue-600 rounded-r-lg text-white" href="#">
                            <i class="fas fa-th-large"></i>
                            <span class="ml-3 text-sm">Dashboard</span>
                        </div>
                    </li>
                </ul>

                <!-- Other Navigation -->
                <ul class="mt-6 text-gray-500 text-sm">
                    <li><a class="block px-4 py-2 hover:bg-gray-100 rounded-r-lg" href="index">Dashboard</a></li>
                    <li><a class="block px-4 py-2 hover:bg-gray-100 rounded-r-lg" href="#">Enquiries</a></li>
                </ul>

                <!-- Property Section -->
                <ul class="mt-6">
                    <li>
                        <div class="flex items-center px-4 py-3 bg-blue-600 rounded-r-lg text-white" href="#">
                            <i class="fas fa-building"></i>
                            <span class="ml-3 text-sm">Property Management</span>
                        </div>
                    </li>
                </ul>
                <ul class="mt-6 text-gray-500 text-sm">
                    <li><a class="block px-4 py-2 hover:bg-gray-100 rounded-r-lg" href="property-list">Property List</a></li>
                    <li><a class="block px-4 py-2 hover:bg-gray-100 rounded-r-lg" href="add-property">Add
                            Property</a></li>
                            <li><a class="block px-4 py-2 hover:bg-gray-100 rounded-r-lg" href="#">Edit Property</a></li>
                    <li><a class="block px-4 py-2 hover:bg-gray-100 rounded-r-lg" href="property-edit">Delete Property</a></li>
                </ul>
            </nav>
        </div>
    </div>
</aside>