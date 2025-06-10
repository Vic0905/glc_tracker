<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Schedule') }}
        
        </h2>
    </x-slot>

            <div class="flex flex-wrap md:flex-nowrap justify-center items-center mt-2 p-5 space-x-4 w-full">
                <!-- Search Input (Centered on Mobile) -->
                <div class="flex flex-col items-center w-full">
                    <form action="{{ route('schedules.input') }}" method="GET" class="flex flex-col md:flex-row items-center gap-2 w-full max-w-md">
                        <div class="relative w-full text-gray-800 uppercase font-bold">
                            <input type="text" name="teacher_name" value="{{ request('teacher_name') }}" placeholder="Search by teacher name"
                                class="block w-full px-4 py-3 pl-10 text-gray-800 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out"/>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 18a7 7 0 100-14 7 7 0 000 14zM21 21l-4.35-4.35" />
                                </svg>
                            </div>
                        </div>
                        <button class="bg-gray-900 hover:bg-transparent px-6 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-gray-500 hover:border-gray-500 text-gray-100 hover:text-gray-900 rounded-xl transition ease-in duration-150"
                            type="submit">
                            Generate
                        </button>
                    </form>
                </div>
             
                <!-- Add Schedule Button (Centered on Mobile) -->
                <div class="flex justify-center w-full mt-3">
                    <a href="{{ route('schedules.index') }}" 
                    class="flex justify-center gap-2 items-center mx-auto shadow-xl text-md bg-gray-50 backdrop-blur-md lg:font-semibold isolation-auto border-gray-50 before:absolute before:w-full before:transition-all before:duration-500 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-gray-900 hover:text-gray-50 before:-z-10 before:aspect-square before:hover:scale-150 before:hover:duration-500 relative z-10 px-4 py-2 overflow-hidden border-2 rounded-full group">
                        Back to Schedules
                        <svg class="w-8 h-8 justify-end group-hover:rotate-90 group-hover:bg-gray-50 text-gray-50 ease-linear duration-300 rounded-full border border-gray-700 group-hover:border-none p-2 rotate-45"
                            viewBox="0 0 16 19" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                                class="fill-gray-800 group-hover:fill-gray-800"></path>
                        </svg>
                    </a>
                </div>  
            </div>
 
     <div class="bg-white shadow-xl rounded-2xl overflow-hidden max-w-full max-h-[700px] overflow-y-auto text-sm font-sans">
    <table class="min-w-full border-separate border-spacing-0 text-sm">
        <thead class="bg-slate-800 text-gray-100 sticky top-0 z-10 shadow">
            <tr>
                <th class="px-4 py-3 border border-gray-700 text-left text-sm">Teacher</th>
                <th class="px-4 py-3 border border-gray-700 text-left text-sm">Room</th>
                @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                    @php
                        $startTime = \Carbon\Carbon::createFromFormat('H:i', $time);
                        $endTime = $startTime->copy()->addMinutes(50);
                    @endphp
                    <th class="px-4 py-3 border border-gray-700 text-center whitespace-nowrap text-xs">
                        {{ $startTime->format('H:i') }}<br>to<br>{{ $endTime->format('H:i') }}
                    </th>
                @endforeach
                {{-- @role('admin')
                    <th class="px-4 py-3 border border-gray-700 text-center text-sm">Actions</th>
                @endrole --}}
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
            
            @foreach ($rooms as $room)
                @php
                    $groups = $schedulesByRoom[$room->roomname] ?? collect([]);
                    $groupedByTeacherAndDate = $groups->groupBy(function ($schedule) {
                        return $schedule->teacher_id . '_' . $schedule->schedule_date;
                    });
                @endphp

                @if ($groupedByTeacherAndDate->isEmpty())
                    <tr>
                        <td class="px-4 py-3 border text-sm text-gray-500"> 
                            <select name="teacher_id" class="teacher-select block w-full appearance-none text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-xl p-3 pr-10 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" data-room-id="{{ $room->id }}">
                                <option value="" selected class="text-gray-400">Choose a Teacher</option>
                                @foreach($teachers->sortBy('name') as $teacher)
                                    <option value="{{ $teacher->user_id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-3 border font-bold">{{ $room->roomname }}</td>
                        @foreach ($timeSlots as $time => $slotKey)
                            <td class="px-1 py-2 border text-center text-xs text-gray-500">
                                <form class="schedule-form" data-room-id="{{ $room->id }}" data-time-slot="{{ $time }}" data-slot-key="{{ $slotKey }}">
                                    @csrf
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <input type="hidden" name="schedule_time" value="{{ $time }}">
                                    <input type="hidden" name="{{ $slotKey }}" value="1">
                                    <input type="hidden" name="schedule_date" value="{{ now()->format('Y-m-d') }}">
                                    
                                    {{-- THIS IS THE CRUCIAL ADDITION for empty rows --}}
                                    <input type="hidden" name="teacher_id" value=""> 
                                    
                                    <select name="student_id" class="block w-full text-xs py-1 px-2 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-1" required>
                                        <option value="" selected>Select Student</option>
                                        @foreach($students->sortBy('name') as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select>

                                    <select name="subject_id" class="block w-full text-xs py-1 px-2 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="" selected>Select Subject</option>
                                        @foreach($subjects->sortBy('subjectname') as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subjectname }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        @endforeach
                        {{-- @role('admin')
                            <td class="px-4 py-3 border text-center text-xs text-gray-500">---</td>
                        @endrole --}}
                    </tr>
                @else
                    @foreach ($groupedByTeacherAndDate as $group)
                        <tr class="hover:bg-slate-50 align-top transition text-xs">
                            <td class="px-4 py-3 border font-medium text-sm">
                                    {{ $group->first()->teacher->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 border font-bold">{{ $room->roomname }}</td>

                            @foreach ($timeSlots as $time => $slotKey)
                                @php
                                    $scheduledStudents = $group->filter(fn($schedule) => $schedule->{$slotKey});
                                @endphp
                                <td class="px-1 py-2 border align-top">
                                    @if($scheduledStudents->isNotEmpty())
                                        @foreach($scheduledStudents as $schedule)
                                        <div class="schedule-item">
                                            <div class="text-xs text-gray-600">{{ $schedule->student->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-600">{{ optional($schedule->subject)->subjectname ?? 'N/A' }}</div>
                                            <button onclick="deleteSchedule({{ $schedule->id }})" class="text-red-500 text-xs hover:underline">Delete</button>
                                        </div>
                                        @endforeach
                                    @else
                                        <form class="schedule-form" data-room-id="{{ $room->id }}" data-time-slot="{{ $time }}" data-slot-key="{{ $slotKey }}">
                                            @csrf
                                            {{-- This hidden input is already present here --}}
                                            <input type="hidden" name="teacher_id" value="{{ $group->first()->teacher_id }}">
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <input type="hidden" name="schedule_time" value="{{ $time }}">
                                            <input type="hidden" name="{{ $slotKey }}" value="1">
                                            <input type="hidden" name="schedule_date" value="{{ $group->first()->schedule_date }}">
                                            
                                            <select name="student_id" class="block w-full text-xs py-1 px-2 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-1" required>
                                                <option value="" selected>Select Student</option>
                                                @foreach($students->sortBy('name') as $student)
                                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endforeach
                                            </select>

                                            <select name="subject_id" class="block w-full text-xs py-1 px-2 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                <option value="" selected>Select Subject</option>
                                                @foreach($subjects->sortBy('subjectname') as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->subjectname }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @endif
                                </td>
                            @endforeach
                            {{-- @role('admin')
                                <td class="px-4 py-3 border text-center">
                                    <button onclick="confirmDeleteByRoomAndDate({{ $group->first()->room_id }}, '{{ $group->first()->schedule_date }}')"
                                        class="bg-red-500 hover:bg-transparent px-5 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider 
                                            border-2 border-red-500 hover:border-red-500 text-white hover:text-red-500 rounded-xl transition ease-in duration-100">
                                        Delete All
                                    </button>
                                </td>
                            @endrole --}}
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-end text-xs mt-4">
        {{ $rooms->links() }}
    </div>
</div>
<div id="teacherStudentsModalContainer"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submissions when dropdowns change
    document.querySelectorAll('.schedule-form select').forEach(select => {
        select.addEventListener('change', function() {
            const form = this.closest('form');
            const studentSelect = form.querySelector('select[name="student_id"]');
            const subjectSelect = form.querySelector('select[name="subject_id"]');
            
            const row = this.closest('tr');
            const teacherSelect = row.querySelector('.teacher-select'); // This exists only for empty rows
            let teacherId = null; // Initialize as null

            // Get teacher_id from hidden input for existing teacher rows, or from select for new rows
            const teacherIdInput = form.querySelector('input[name="teacher_id"]');
            if (teacherIdInput) {
                teacherId = teacherIdInput.value;
            } else if (teacherSelect) { // Fallback for rows with the teacher dropdown
                teacherId = teacherSelect.value;
            }

            // TEMP: Add console logs to see the values immediately
            console.log('--- Form Submission Check ---');
            console.log('Student value:', studentSelect.value);
            console.log('Subject value:', subjectSelect.value);
            console.log('Teacher ID (from hidden input or select):', teacherId);
            console.log('Is teacherIdInput present?', !!teacherIdInput);
            console.log('Is teacherSelect present?', !!teacherSelect);
            console.log('Is the submit condition met?', !!studentSelect.value && !!subjectSelect.value && !!teacherId);
            console.log('----------------------------');


            // Only submit if student, subject, AND teacher fields have values
            if (studentSelect.value && subjectSelect.value && teacherId) {
                const formData = new FormData(form);
                
                fetch("{{ route('schedules.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Server error: ' + response.statusText);
                        }).catch(() => {
                            throw new Error('Server error: ' + response.statusText);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Unknown error creating schedule'); 
                        studentSelect.value = '';
                        subjectSelect.value = '';
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    alert('An error occurred during scheduling: ' + error.message);
                    studentSelect.value = '';
                    subjectSelect.value = '';
                });
            } else {
                // TEMP: Log if the condition is not met
                console.log('Form not submitted: Missing student, subject, or teacher ID.');
            }
        });
    });

    // Handle teacher selection change (This block seems correct for empty rows)
    document.querySelectorAll('.teacher-select').forEach(select => {
        select.addEventListener('change', function() {
            const teacherId = this.value;
            const roomId = this.dataset.roomId;
            
            document.querySelectorAll(`tr .schedule-form input[name="room_id"][value="${roomId}"]`).forEach(input => {
                const form = input.closest('form');
                const teacherIdInput = form.querySelector('input[name="teacher_id"]');
                if (teacherIdInput) {
                    teacherIdInput.value = teacherId;
                }
            });
        });
    });
});

function deleteSchedule(scheduleId) {
    if (confirm('Are you sure you want to delete this schedule?')) {
        fetch(`/schedules/${scheduleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error deleting schedule');
            }
        });
    }
}

// Function to show teacher students (assuming this is defined elsewhere)
function showTeacherStudents(teacherId, scheduleDate) {
    // Implement logic to show a modal or redirect with teacher's students
    alert(`Showing students for Teacher ID: ${teacherId} on Date: ${scheduleDate}`);
  
}

// Function to confirm delete by room and date (assuming this is defined elsewhere)
function confirmDeleteByRoomAndDate(roomId, scheduleDate) {
    if (confirm('Are you sure you want to delete all schedules for this room on this date?')) {
        fetch(`/schedules/delete-by-room-date`, {
            method: 'POST', // Or DELETE if your route supports it
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ room_id: roomId, schedule_date: scheduleDate })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error deleting schedules by room and date');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred during bulk deletion.');
        });
    }
}
</script>

</x-app-layout>
