<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Schedules') }}
            <span class="text-gray-500 text-sm mr-8">({{ $schedules->total() }} schedules)</span>
        </h2>
    </x-slot>

<div class="flex flex-wrap md:flex-nowrap justify-center items-center p-5 space-x-4 w-full">
    <!-- Search Input (Centered on Mobile) -->
    <div class="flex flex-col items-center w-full">
        <form action="{{ route('schedules.available') }}" method="GET" class="flex flex-col md:flex-row items-center gap-2 w-full max-w-md">
            <div class="relative w-full text-gray-800 uppercase font-bold">
                <input type="text" name="teacher_name" value="{{ request('teacher_name') }}" placeholder="Search by teacher name"
                    class="block w-full px-4 py-3 pl-10 text-gray-800 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out"/>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 18a7 7 0 100-14 7 7 0 000 14zM21 21l-4.35-4.35" />
                    </svg>
                </div>
            </div>
            <button class="bg-gray-900 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-gray-200 hover:border-gray-200 text-gray-100 hover:text-gray-900 rounded-lg transition ease-in duration-100"
                type="submit">
                Generate
            </button>
        </form>
    </div>
             
    <!-- Add Schedule Button (Centered on Mobile) -->
    <div class="flex justify-center w-full mt-3">
        <a href="{{ route('schedules.index') }}" 
        class="bg-gray-900 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-gray-200 hover:border-gray-200 text-gray-100 hover:text-gray-900 rounded-lg transition ease-in duration-100">
            Back to Schedules
        </a>
    </div>  
</div>
            
<div class="py-2">
    <div class="max-w-10xl mx-auto sm:px-6 lg:px-8 ">
        <div class="overflow-x-auto"></div>
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <!--  Schedules Table -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden max-w-full max-h-[600px] overflow-y-auto text-sm font-sans">
                <table class="min-w-full border-separate border-spacing-0 text-sm">
                    <thead class="text-gray-900 sticky top-0 z-10 shadow">
                        <!-- New row showing the date above -->
                        <tr>
                            <th colspan="13" class=" text-gray-100 px-4 py-2 text-center text-xl font-semibold border border-gray-600 bg-slate-900">
                                Schedules for {{ \Carbon\Carbon::today()->format('F d, Y') }}
                            </th>
                        </tr>
                        {{-- Header --}}
                        <tr>
                            <th class=" bg-gray-100 px-3 py-1 border border-gray-200 text-left text-sm">Teacher</th>
                            <th class=" bg-gray-100 px-3 py-1 border border-gray-200 text-left text-sm">Room</th>

                            @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                                @php
                                    $startTime = \Carbon\Carbon::createFromFormat('H:i', $time);
                                    $endTime = $startTime->copy()->addMinutes(50);
                                @endphp
                                <th class="bg-gray-100 text-gray-900 px-3 py-1 border border-gray-200 text-center whitespace-nowrap text-sm ">
                                    {{ $startTime->format('H:i') }}<br>to<br>{{ $endTime->format('H:i') }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $timeSlots = [
                                '08:00' => 'time_8_00_8_50',
                                '09:00' => 'time_9_00_9_50',
                                '10:00' => 'time_10_00_10_50',
                                '11:00' => 'time_11_00_11_50',
                                '12:00' => 'time_12_00_12_50',
                                '13:00' => 'time_13_00_13_50',
                                '14:00' => 'time_14_00_14_50',
                                '15:00' => 'time_15_00_15_50',
                                '16:00' => 'time_16_00_16_50',
                                '17:00' => 'time_17_00_17_50',
                            ];
                        @endphp

                        @foreach($groupedSchedules as $group)
                            <tr class="hover:bg-slate-50 align-top transition text-xs">
                                <td class="px-4 py-3 border border-gray-200 font-medium">
                                    <a href="#" onclick="event.preventDefault(); showTeacherStudents({{ $group->first()->teacher->user->id }}, '{{ $group->first()->schedule_date }}')" 
                                    class="text-blue-600 hover:underline">
                                        {{ $group->first()->teacher->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 border border-gray-200 font-bold">{{ $group->first()->room->roomname ?? 'N/A' }}</td>
                            

                                @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                                    @php
                                        $slotKey = $timeSlots[$time] ?? null;
                                        $scheduledStudents = $group->filter(fn($schedule) => $slotKey && $schedule->{$slotKey});
                                    @endphp
                                    <td class="px-1 py-1 border border-gray-200 align-top">
                                        @if($scheduledStudents->isNotEmpty())
                                            @foreach($scheduledStudents as $schedule)
                                                @php
                                                    $status = $schedule->status ?? 'N/A';
                                                    $isAbsent = in_array($status, ['N/A', 'absent GRP', 'absent MTM']);
                                                    $bgColor = $isAbsent ? 'bg-red-100' : 'bg-green-100';
                                                    $textColor = $isAbsent ? 'text-red-700' : 'text-green-700';
                                                @endphp
                                                <div class="{{ $bgColor }} rounded-lg mb-1 p-2 shadow-sm">
                                                    <strong>{{ $schedule->student->name ?? 'N/A' }}</strong><br>
                                                    <span class="text-xs {{ $textColor }}">({{ $status }})</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 text-xs italic">---</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="teacherStudentsModalContainer"></div>
            </div>
        </div>
    </div>
</div>

    <script>
        // Function to show the teacher's students modal 
        function showTeacherStudents(teacherId, scheduleDate) {
        fetch(`/teachers/${teacherId}/students/${scheduleDate}`)
            .then(response => response.text()) // Fetch as HTML
            .then(html => {
                document.getElementById('teacherStudentsModalContainer').innerHTML = html;
                document.getElementById('teacherStudentsModal').classList.remove('hidden');
                attachStatusChangeListeners(); // Attach event listeners for status change
            })
            .catch(error => {
                console.error('Error loading students:', error);
                alert('Error loading students. Please check the console.');
            });
        }

        function closeTeacherStudentsModal() {
            document.getElementById('teacherStudentsModal').classList.add('hidden');
        }


        // Add Event Listeners to Status Select Dropdowns
        function attachStatusChangeListeners() {
            document.querySelectorAll('.status-select').forEach(select => {
                select.addEventListener('change', function () {
                    let studentId = this.dataset.studentId;
                    let newStatus = this.value;

                    updateStudentStatus(studentId, newStatus);
                });
            });
        }
    </script>

</x-app-layout>
