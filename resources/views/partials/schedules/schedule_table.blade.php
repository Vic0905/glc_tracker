<!-- Schedules Table -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden max-w-full max-h-[600px] overflow-y-auto text-sm font-sans">
    <table class="min-w-full border-separate border-spacing-0 text-sm">
        <!-- Table Header -->
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

            @foreach($groupedSchedules as $group)
                <tr class="hover:bg-slate-50 align-top transition text-xs">
                    <td class="px-4 py-3 border border-gray-200 font-medium text-sm">
                        <a href="#" onclick="event.preventDefault(); showTeacherStudents({{ $group->first()->teacher->user->id }}, '{{ $group->first()->schedule_date }}')" 
                           class="text-blue-600 hover:underline">
                            {{ $group->first()->teacher->name ?? 'N/A' }}
                        </a>
                    </td>
                    <td class="px-4 py-3 border border-gray-200 font-bold">{{ $group->first()->room->roomname ?? 'N/A' }}</td>
                    <td class="px-4 py-3 border border-gray-200 font-bold">{{ $group->first()->schedule_date ?? 'N/A' }}</td>

                    @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                        @php
                            $slotKey = $timeSlots[$time] ?? null;
                            $scheduledStudents = $group->filter(fn($schedule) => $slotKey && $schedule->{$slotKey});
                        @endphp
                        <td class="px-1 py-2 border border-gray-200 align-top">
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
                                        <span class="text-xs text-gray-600">{{ optional($schedule->studentRoom)->roomname ?? 'N/A' }}</span><br>
                                        <span class="text-xs {{ $textColor }}">({{ $status }})</span>
                                    </div>
                                @endforeach
                            @else
                                <span class="text-gray-900 text-xs bold">---</span>
                            @endif
                        </td>
                    @endforeach

                    @role('admin')
                        <td class="px-4 py-3 border border-gray-100 text-center">
                            <button onclick="confirmDeleteByRoomAndDate({{ $schedule->room_id }}, '{{ $schedule->schedule_date }}')"
                                class="bg-red-500 hover:bg-transparent px-5 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider 
                                        border-2 border-red-500 hover:border-red-500 text-white hover:text-red-500 rounded-xl transition ease-in duration-100">
                                 Delete
                            </button>
                        </td>
                    @endrole
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="flex justify-between items-center mt-4 mb-2 gap-4 flex-wrap">

      @role('admin')  
      <!-- Button -->
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

    <!-- Pagination -->
    <div class="flex justify-end">
        {{ $schedules->links('vendor.pagination.tailwind') }}
    </div>
</div>


