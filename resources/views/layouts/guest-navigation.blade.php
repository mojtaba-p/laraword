<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600"/>
                    </a>
                </div>

                <form action="{{ route('search.article') }}" method="get" class="hidden sm:flex  sm:items-center sm:ml-6" >
                    <input type="text" name="q" class="border-1 border-gray-300  rounded-lg" placeholder="Search...">
                </form>

            </div>
            <div class="flex flex-row">
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex  sm:items-center sm:ml-6">
                    <a href="/login" title="login" class="px-2 pt-1 mx-2  border-b-2 border-b-indigo-500 hover:bg-gray-100 hover:shadow-md transition">Login</a>
                    <a href="/register" title="register"  class="px-2 pt-1 mx-2  border-b-2 border-b-indigo-500 hover:bg-gray-100 hover:shadow-md transition">Register</a>
                </div>

            </div>


        </div>
    </div>
</nav>
