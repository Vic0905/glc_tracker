{{-- Schedule table --}}
<div class="bg-white shadow-xl rounded-2xl overflow-hidden max-w-full max-h-[600px] overflow-y-auto text-sm font-sans">
    <table class="min-w-full border-separate border-spacing-0 text-sm">
        <thead class="bg-slate-100 text-gray-900 sticky top-0 z-10 shadow">
            <tr>
                <th class="px-4 py-3 border border-gray-200 text-left text-sm">Teacher</th>
                <th class="px-4 py-3 border border-gray-200 text-left text-sm">Room</th>
                <th class="px-4 py-3 border border-gray-200 text-left text-sm">Date</th>
                @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                    @php
                        $startTime = \Carbon\Carbon::createFromFormat('H:i', $time);
                        $endTime = $startTime->copy()->addMinutes(50);
                    @endphp
                    <th class="px-4 py-3 border border-gray-200 text-center whitespace-nowrap text-xs ">
                        {{ $startTime->format('H:i') }}<br>to<br>{{ $endTime->format('H:i') }}
                    </th>
                @endforeach
                @role('admin')
                    <th class="px-4 py-3 border border-gray-200 text-center text-sm">Actions</th>
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
                            <a href="#" onclick="event.preventDefault(); showTeacherStudents({{ $group->first()->teacher->user->id }}, '{{ $group->first()->schedule_date }}')" 
                                class="text-blue-600 hover:underline">
                                {{ $group->first()->teacher->name ?? 'N/A' }}
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
                                        {{-- Note: roomname is removed from here if the row already indicates the room --}}
                                        <div class="{{ $bgColor }} rounded-lg mb-1 p-2 shadow-sm border border-gray-200">
                                            <div class="flex items-center justify-between mb-1">
                                                <strong class="text-gray-800 text-xs">{{ $schedule->student->name ?? 'N/A' }}</strong>
                                                <span class="px-2 py-0.5 inline-flex text-xs leading-4 font-semibold rounded-full {{ $bgColor }} {{ $textColor }}">
                                                    {{ $status }}
                                                </span>
                                            </div>
                                            <div class="text-gray-600 text-xs flex items-center">
                                                <svg class="w-3 h-3 mr-1 text-gray-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z" clip-rule="evenodd"></path></svg>
                                                {{ optional($schedule->subject)->subjectname ?? 'N/A' }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        @endforeach
                        
                        {{-- Actions column for admin --}}
                         @role('admin')
                        <td class="px-4 py-3 border border-gray-100 text-center align-middle">
                            <a onclick="confirmDeleteByRoomAndDate({{ $schedule->room_id }}, '{{ $schedule->schedule_date }}')"
                                class="text-red-500 hover:text-red-700 text-xs cursor-pointer hover:underline">
                                Delete All
                            </a>
                        </td>
                        @endrole 
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div id="teacherStudentsModalContainer"></div>
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

