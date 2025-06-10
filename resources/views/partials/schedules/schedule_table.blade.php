{{-- Schedule table --}}
<div class="bg-white shadow-xl rounded-2xl overflow-hidden max-w-full max-h-[600px] overflow-y-auto text-sm font-sans">
    <table class="min-w-full border-separate border-spacing-0 text-sm">
        <thead class="bg-slate-800 text-gray-100 sticky top-0 z-10 shadow">
            <tr>
                <th class="px-4 py-3 border border-gray-700 text-left text-sm">Teacher</th>
                <th class="px-4 py-3 border border-gray-700 text-left text-sm">Room</th>
                <th class="px-4 py-3 border border-gray-700 text-left text-sm">Date</th>
                @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                    @php
                        $startTime = \Carbon\Carbon::createFromFormat('H:i', $time);
                        $endTime = $startTime->copy()->addMinutes(50);
                    @endphp
                    <th class="px-4 py-3 border border-gray-700 text-center whitespace-nowrap text-xs ">
                        {{ $startTime->format('H:i') }}<br>to<br>{{ $endTime->format('H:i') }}
                    </th>
                @endforeach
                @role('admin')
                    <th class="px-4 py-3 border border-gray-700 text-center text-sm">Actions</th>
                @endrole
            </tr>
        </thead>
        {{-- Table body --}}
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

            {{-- Loop through each room that has schedules --}}
            @foreach($rooms as $room)
                @php
                    // Get the schedules for the current room
                    $currentRoomSchedules = $schedulesByRoom[$room->roomname] ?? collect();
                @endphp

                {{-- Loop through each teacher-date group within the current room that has schedules --}}
                {{-- This loop will only run if $currentRoomSchedules is not empty --}}
                @foreach($currentRoomSchedules as $teacherDateKey => $group)
                    <tr class="hover:bg-slate-50 align-top transition text-xs">
                        <td class="px-4 py-3 border border-gray-200 font-medium text-sm">
                            @php
                                $firstScheduleInGroup = $group->first();
                            @endphp
                            @if($firstScheduleInGroup && $firstScheduleInGroup->teacher)
                                <a href="#" onclick="event.preventDefault(); showTeacherStudents({{ $firstScheduleInGroup->teacher->id }}, '{{ $firstScheduleInGroup->schedule_date }}')"
                                    class="text-blue-600 hover:underline">
                                    {{ $firstScheduleInGroup->teacher->name ?? 'N/A' }}
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-3 border border-gray-200 font-bold">{{ $room->roomname ?? 'N/A' }}</td>
                        <td class="px-4 py-3 border border-gray-200 font-bold">
                            {{ $firstScheduleInGroup->schedule_date ? \Carbon\Carbon::parse($firstScheduleInGroup->schedule_date)->format('Y-m-d') : 'N/A' }}
                        </td>

                        @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                            @php
                                $slotColumn = $timeSlots[$time] ?? null;
                                // Filter schedules in the current group that are for this specific time slot
                                $scheduledStudentsForSlot = $group->filter(fn($schedule) => $slotColumn && $schedule->{$slotColumn});
                            @endphp
                            <td class="px-1 py-2 border border-gray-200 align-top">
                                @if($scheduledStudentsForSlot->isNotEmpty())
                                    @foreach($scheduledStudentsForSlot as $schedule)
                                        @php
                                            $status = $schedule->status ?? 'N/A';
                                            $isAbsent = in_array($status, ['N/A', 'absent GRP', 'absent MTM']);
                                            $bgColor = $isAbsent ? 'bg-red-100' : 'bg-green-100';
                                            $textColor = $isAbsent ? 'text-red-700' : 'text-green-700';
                                        @endphp
                                        <div class="{{ $bgColor }} rounded-lg mb-1 p-2 shadow-sm">
                                            <strong>{{ $schedule->student->name ?? 'N/A' }}</strong><br>
                                            <span class="text-xs text-gray-600">{{ optional($schedule->room)->roomname ?? 'N/A' }}</span><br>
                                            <span class="text-xs {{ $textColor }}">({{ $status }})</span>
                                            @role('admin')
                                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this schedule for {{ $schedule->student->name ?? '' }} at {{ $time }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-1 text-xs">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endrole
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Form to add new schedule if the slot is empty but the row exists --}}
                                    <form class="schedule-form" method="POST" action="{{ route('schedules.store') }}">
                                        @csrf
                                        <input type="hidden" name="schedule_date" value="{{ \Carbon\Carbon::parse($firstScheduleInGroup->schedule_date)->format('Y-m-d') }}">
                                        <input type="hidden" name="schedule_time" value="{{ $time }}">
                                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                                        <input type="hidden" name="teacher_id" value="{{ $firstScheduleInGroup->teacher->id ?? '' }}">
                                        
                                        <div class="flex flex-col gap-1">
                                            <select name="student_id" class="block w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="">Select Student</option>
                                                @foreach($students as $student)
                                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                            <select name="subject_id" class="block w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="">Select Subject</option>
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->subjectname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                @endif
                            </td>
                        @endforeach

                         @role('admin')
                        <td class="px-4 py-3 border border-gray-100 text-center">
                            <button onclick="confirmDeleteByRoomAndDate({{ $schedule->room_id }}, '{{ $schedule->schedule_date }}')"
                                class="bg-red-500 hover:bg-transparent px-5 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-red-500 hover:border-red-500 text-white hover:text-red-500 rounded-xl transition ease-in duration-100">
                                Delete All
                            </button>
                        </td>
                        @endrole 
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<div class="flex justify-between items-center mt-4 mb-2 gap-4 flex-wrap">

      @role('admin')
      <div class="flex justify-start">
        <a href=" {{route('schedules.available')}} " class="w-full md:w-auto bg-gray-900 hover:bg-transparent px-6 py-2 text-xs font-medium tracking-wider border-2 border-gray-500
        hover:border-gray-500 text-white hover:text-gray-900 rounded-xl transition duration-150 ease-in">
            Schedules for {{ \Carbon\Carbon::today()->format('F d, Y') }}
        </a>
    </div>
    <div class="flex justify-between">
        <a href=" {{route('schedules.input')}} " class="w-full md:w-auto bg-gray-900 hover:bg-transparent px-6 py-2 text-xs font-medium tracking-wider border-2 border-gray-500
        hover:border-gray-500 text-white hover:text-gray-900 rounded-xl transition duration-150 ease-in">
            Input Schedules
        </a>
    </div>
    @endrole

    {{-- <div class="flex justify-end">
        {{ $rooms->links('vendor.pagination.tailwind') }} {{-- Assuming rooms is paginated --}}
    </div> 
</div>