<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @role('admin')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Students Count -->
                    <div class="bg-gradient-to-br from-gray-100 to-gray-300 overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6 text-gray-900 text-center">
                            <h3 class="text-lg font-bold text-gray-800">Total Students</h3>
                            <p id="studentsCount" class="text-4xl font-extrabold text-gray-900">0</p>
                        </div>
                    </div>

                    <!-- Teachers Count -->
                    <div class="bg-gradient-to-br from-gray-100 to-gray-300 overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6 text-gray-900 text-center">
                            <h3 class="text-lg font-bold text-gray-800">Total Teachers</h3>
                            <p id="teachersCount" class="text-4xl font-extrabold text-gray-900">0</p>
                        </div>
                    </div>

                    <!-- Subjects Count -->
                    <div class="bg-gradient-to-br from-gray-100 to-gray-300 overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6 text-gray-900 text-center ">
                            <h3 class="text-lg font-bold text-gray-800">Total Subjects</h3>
                            <p id="subjectsCount" class="text-4xl font-extrabold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
                 {{-- Schedule Counts --}}
                <div class="bg-gradient-to-br from-gray-100 to-gray-300 overflow-hidden shadow-lg rounded-lg mt-6">
                    <div class="p-6 text-gray-900 text-center ">
                        <h3 class="text-lg font-bold text-gray-800">Total Schedules</h3>
                        <p id="schedulesCount" class="text-4xl font-extrabold text-gray-900">0</p>
                    </div>
                </div>
            </div>
        </div>
            
            {{-- <!-- Recent Activities -->
            <!-- Recent Activities -->
            <div class="max-w-4xl mx-auto bg-white overflow-hidden shadow-lg rounded-lg p-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h3>
                <div class="max-h-96 overflow-y-auto space-y-4">
                    <ul>
                        @foreach ($activities as $activity)
                            <li class="bg-gray-50 p-4 rounded-lg shadow-sm hover:bg-gray-100 transition duration-300 ease-in-out">
                                <span class="text-gray-600">{{ $activity->activity }}</span>
                                <span class="text-xs text-gray-400">({{ $activity->created_at->diffForHumans() }})</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <form action="{{ route('activity-logs.delete') }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="cursor-pointer transition-all bg-red-700 text-white px-6 py-2 rounded-lg border-red-400 border-b-[4px] hover:shadow-xl hover:shadow-red-300 shadow-red-300 active:shadow-none hover:bg-transparent text-sm shadow-sm font-medium tracking-wider border-2 hover:border-red-500 hover:text-red-500 ease-in duration-300">
                        Delete All Activity Logs
                    </button>
                </form>
            </div> --}}
    @endrole

    <script>
        function animateCount(elementId, targetNumber, duration = 50000) {
            let count = 0;
            const increment = Math.ceil(targetNumber / (duration / 50));
            const interval = setInterval(() => {
                count += increment;
                if (count >= targetNumber) {
                    count = targetNumber;
                    clearInterval(interval);
                }
                document.getElementById(elementId).innerText = count;
            }, 10);
        }

        document.addEventListener("DOMContentLoaded", function() {
            animateCount("studentsCount", {{ $studentsCount }});
            animateCount("teachersCount", {{ $teachersCount }});
            animateCount("subjectsCount", {{ $subjectsCount }});
            animateCount("schedulesCount", {{ $schedulesCount }});
        });
    </script>

</x-app-layout>
