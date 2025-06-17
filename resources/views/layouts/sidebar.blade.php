<aside class="fixed top-0 left-0 h-screen w-10 z-50 bg-gray-100 text-gray-900 shadow-lg flex flex-col">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-center p-4">
        <a href="{{ route('dashboard') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-auto" viewBox="0 0 100 100" fill="none">
                <!-- White background -->
                <rect width="100" height="100" rx="16" fill="white"/>
                <!-- Blue text -->
                <text x="50%" y="55%" text-anchor="middle" fill="#2563EB" font-size="42" font-weight="bold" font-family="Arial, sans-serif" dy=".3em">
                    GLC
                </text>
            </svg>
        </a>
    </div>
    <!-- Navigation Links -->
   <nav class="mt-6 flex-1">
        <ul class="space-y-1">
            @role('admin')
                @php
                    $links = [
                        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => '📊'],
                        ['route' => 'students.index', 'label' => 'Students', 'icon' => '🎓'],
                        ['route' => 'subjects.index', 'label' => 'Subjects', 'icon' => '📚'],
                        ['route' => 'rooms.index', 'label' => 'Rooms', 'icon' => '🏫'],
                        ['route' => 'teachers.index', 'label' => 'Teachers', 'icon' => '👨‍🏫'],
                        ['route' => 'schedules.index', 'label' => 'Schedules', 'icon' => '📅'],
                    ];
                @endphp

                @foreach ($links as $link)
                    <li class="relative">
                        <a href="{{ route($link['route']) }}"
                           class="group flex items-center justify-center px-2 py-3 rounded-lg transition-all
                           {{ request()->routeIs($link['route']) ? 'bg-gray-800 text-white shadow-md' : 'hover:bg-gray-100' }}">
                            <span>{{ $link['icon'] }}</span>
                            <span class="absolute left-full top-1/2 -translate-y-1/2 ml-2 bg-gray-900 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity z-50 shadow-md">
                                {{ $link['label'] }}
                            </span>
                        </a>
                    </li>
                @endforeach
            @endrole

            @role('teacher')
                <li class="relative">
                    <a href="{{ route('schedules.index') }}"
                       class="group flex items-center justify-center px-4 py-3 rounded-lg transition-all
                       {{ request()->routeIs('schedules.index') ? 'bg-gray-800 text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <span>📅</span>
                        <span class="absolute left-full top-1/2 -translate-y-1/2 ml-2 bg-gray-900 text-white text-sm rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity z-50 shadow-md">
                            My Schedules
                        </span>
                    </a>
                </li>
            @endrole
        </ul>
    </nav>

   <!-- Dropdown for Profile & Logout -->
<div class="relative group p-4">
    <!-- Trigger Button -->
    <button class="flex items-center justify-center w-full p-3 rounded-lg hover:bg-gray-100 transition">
        <span>👤</span>
        <!-- Tooltip -->
        <span class="absolute left-full top-1/2 -translate-y-1/2 ml-2 bg-gray-900 text-white text-sm rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity z-50 shadow-md">
            Account
        </span>
    </button>

    <!-- Dropdown Content (shown on hover) -->
    <div class="absolute left-full bottom-4 ml-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 group-hover:opacity-100 group-hover:pointer-events-auto pointer-events-none transition-opacity z-50">
            <div class="py-2 text-sm text-gray-700">
                        <!-- Username Display -->
                <div class="px-4 py-2 font-semibold border-b bg-gray-900 text-white flex items-center space-x-2">
                    <!-- User Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9.953 9.953 0 0112 15c2.485 0 4.747.91 6.879 2.404M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    <!-- Username -->
                    {{ Auth::user()->name }}
                </div>

            <!-- Profile Link -->
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
                {{ __('Profile') }}
            </a>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</div>



</aside>
