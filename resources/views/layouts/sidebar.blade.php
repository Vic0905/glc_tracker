<aside x-data="{ open: true }" class="fixed top-0 left-0 h-screen transition-all duration-300 ease-in-out"
    :class="open ? 'w-64 bg-gray-200 text-GRAY-900 shadow-lg' : 'w-20 bg-gray-200 text-white'">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="h-10 w-auto fill-current text-gray-900" />
            <span x-show="open" class="ml-3 text-lg font-semibold transition-all">GLC</span>
        </a>
        <button @click="open = !open" class="p-2 rounded-md hover:bg-gray-300 transition">
            <svg class="w-6 h-6 transition-transform duration-300" :class="open ? 'rotate-0' : 'rotate-180'"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-6">
        <ul class="space-y-1">
            @role('admin')
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all hover:bg-gray-700 hover:shadow-md
                        {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                        <span class="w-8 text-center">📊</span>
                        <span x-show="open" class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('students.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all hover:bg-gray-700 hover:shadow-md
                        {{ request()->routeIs('students.index') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                        <span class="w-8 text-center">🎓</span>
                        <span x-show="open" class="ml-3">Students</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('subjects.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all hover:bg-gray-700 hover:shadow-md
                        {{ request()->routeIs('subjects.index') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                        <span class="w-8 text-center">📚</span>
                        <span x-show="open" class="ml-3">Subjects</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('rooms.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all hover:bg-gray-700 hover:shadow-md
                        {{ request()->routeIs('rooms.index') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                        <span class="w-8 text-center">🏫</span>
                        <span x-show="open" class="ml-3">Rooms</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('teachers.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all hover:bg-gray-700 hover:shadow-md
                        {{ request()->routeIs('teachers.index') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                        <span class="w-8 text-center">👨‍🏫</span>
                        <span x-show="open" class="ml-3">Teachers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('schedules.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all hover:bg-gray-700 hover:shadow-md
                        {{ request()->routeIs('schedules.index') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                        <span class="w-8 text-center">📅</span>
                        <span x-show="open" class="ml-3">Schedules</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all hover:bg-gray-700 hover:shadow-md
                        {{ request()->routeIs('users.index') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                        <span class="w-8 text-center">👥</span>
                        <span x-show="open" class="ml-3">Users</span>
                    </a>
                </li>
            @endrole

            @role('teacher')
                <li>
                    <a href="{{ route('schedules.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-all hover:bg-gray-700 hover:shadow-md
                        {{ request()->routeIs('schedules.index') ? 'bg-gray-700 text-white shadow-md' : '' }}">
                        <span class="w-8 text-center">📅</span>
                        <span x-show="open" class="ml-3">My Schedules</span>
                    </a>
                </li>
            @endrole
        </ul>
    </nav>
</aside>
