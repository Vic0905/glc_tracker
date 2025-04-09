<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedules') }}
        </h2>
    </x-slot>
        
            <div class="bg-gray-100 shadow-sm sm:rounded-lg p-6">

                <div class="relative">
                    @if(session('success'))
                        <div id="successMessage" 
                             class="fixed top-20 right-6 z-50 bg-green-500 text-white p-4 rounded-lg shadow-md border border-green-600 flex items-center space-x-3 transition-opacity duration-1000 ease-out opacity-100">
                
                            <!-- Icon -->
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.707-8.707a1 1 0 011.414 0L10 9.586l1.293-1.293a1 1 0 011.414 1.414l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                
                            <!-- Success Message -->
                            <span class="font-semibold">{{ session('success') }}</span>
                
                            <!-- Close Button -->
                            <button onclick="document.getElementById('successMessage').remove()" 
                                    class="ml-auto text-white hover:bg-green-600 hover:text-gray-200 rounded-full p-1 transition duration-200">
                                &times;
                            </button>
                        </div>
                
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const successMessage = document.getElementById('successMessage');
                                if (successMessage) {
                                    setTimeout(() => {
                                        successMessage.classList.add('opacity-0');
                                        setTimeout(() => successMessage.remove(), 1000);
                                    }, 3000);
                                }
                            });
                        </script>
                    @endif
                </div>
                
                
            
                
                <div class="flex flex-wrap md:flex-nowrap justify-center items-center p-5 space-x-4 w-full">

                @role('admin')
                    <!-- Search Input (Centered on Mobile) -->
                    <div class="flex flex-col items-center w-full">
                        <form action="{{ route('schedules.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-2 w-full max-w-md">
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

                    <!-- Date Selection Form (Centered on Mobile) -->
                    <div class="flex flex-col items-center w-full mt-3">
                        <form method="GET" action="{{ route('schedules.index') }}" class="flex flex-col md:flex-row items-center gap-2 w-full max-w-md text-gray-800">
                            <input type="date" id="date" name="date" value="{{ $date }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-m"/>
                            <button class="bg-gray-900 hover:bg-transparent px-6 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-gray-500 hover:border-gray-500 text-gray-100 hover:text-gray-900 rounded-xl transition ease-in duration-150"
                                type="submit">
                                Generate
                            </button>
                        </form>
                    </div>

                    <!-- Add Schedule Button (Centered on Mobile) -->
                    <div class="flex justify-center w-full mt-3">
                        <a href="{{ route('schedules.create') }}" 
                        class="flex justify-center gap-2 items-center mx-auto shadow-xl text-md bg-gray-50 backdrop-blur-md lg:font-semibold isolation-auto border-gray-50 before:absolute before:w-full before:transition-all before:duration-500 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-gray-900 hover:text-gray-50 before:-z-10 before:aspect-square before:hover:scale-150 before:hover:duration-500 relative z-10 px-4 py-2 overflow-hidden border-2 rounded-full group">
                            Add Schedule
                            <svg class="w-8 h-8 justify-end group-hover:rotate-90 group-hover:bg-gray-50 text-gray-50 ease-linear duration-300 rounded-full border border-gray-700 group-hover:border-none p-2 rotate-45"
                                viewBox="0 0 16 19" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                                    class="fill-gray-800 group-hover:fill-gray-800"></path>
                            </svg>
                        </a>
                    </div>  
                </div>
                @endrole

                @role('teacher')
                    <form action="{{ route('schedules.index') }}" method="GET" class="flex items-center space-x-4 w-full max-w-3xl">

                <!-- Search Input -->
                    <div class="relative w-full max-w-sm text-gray-800">
                        <input
                            type="text"
                            name="student_name"
                            value="{{ request('student_name') }}"
                            placeholder="Search by student name"
                            class="block w-full px-4 py-3 pl-10 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out"
                        />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 18a7 7 0 100-14 7 7 0 000 14zM21 21l-4.35-4.35" />
                            </svg>
                        </div>
                    </div>
                
                    <!-- Submit Button -->
                    <button
                        class="bg-gray-900 hover:bg-transparent px-6 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 
                              border-gray-500 hover:border-gray-500 text-gray-100 hover:text-gray-900 rounded-xl transition ease-in duration-150"
                        type="submit">
                        Search
                    </button>
                </form>
                @endrole
            </div>

        <!-- Schedules Table -->
        <div class="bg-white shadow-lg sm:rounded-lg overflow-x-auto max-w-auto rounded-lg max-w-full max-h-[500px] overflow-y-auto text-xs ">
            <table class="min-w-full border-collapse border border-gray-300 table-auto">
                <thead class="bg-gray-800 text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-5 py-2 text-left border-b">Teacher</th>
                        <th class="px-5 py-2 text-left border-b">Room</th>
                        <th class="px-10 py-2 text-left border-b w-10">Schedule Date</th>
                        @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                            @php
                                $startTime = \Carbon\Carbon::createFromFormat('H:i', $time);  // Convert start time to Carbon instance
                                $endTime = $startTime->copy()->addMinutes(50);  // Add 50 minutes to the start time
                            @endphp
                            <th class="px-5 py-2 text-left border-b">{{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}</th>
                        @endforeach

                        @role('admin')
                        <th class="px-6 py-2 text-left border-b">Actions</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                        @php
                            // Map each time slot to its corresponding field name in the database so i can check if it's scheduled or not 
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
                            <tr class="hover:bg-gray-100">
                                <td class="px-5 py-4 border-b whitespace-nowrap">
                                    <a href="#" onclick="event.preventDefault(); showTeacherStudents({{ $group->first()->teacher->user->id }}, '{{ $group->first()->schedule_date }}')" 
                                    class="text-gray-900 hover:underline">
                                        {{ $group->first()->teacher->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td class="px-5 py-4 border-b whitespace-nowrap">{{ $group->first()->room->roomname ?? 'N/A' }}</td>
                                <td class="px-5 py-4 border-b whitespace-nowrap">{{ $group->first()->schedule_date ?? 'N/A' }}</td>
                    
                                @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                                    @php
                                        $slotKey = $timeSlots[$time] ?? null;
                                        $scheduledStudents = $group->filter(fn($schedule) => $slotKey && $schedule->{$slotKey});
                                    @endphp
                    
                                    <td class="px-5 py-2 border-b relative cursor-pointer whitespace-nowrap">
                                        @if($scheduledStudents->isNotEmpty())
                                        @foreach($scheduledStudents as $schedule)
                                            @php
                                                // Define status-based colors
                                                $status = $schedule->status ?? 'N/A';
                                                $bgColor = in_array($status, ['N/A', 'absent GRP', 'absent MTM']) ? 'bg-red-100' : 'bg-green-100';
                                                $textColor = in_array($status, ['N/A', 'absent GRP', 'absent MTM']) ? 'text-red-700' : 'text-green-700';
                                            @endphp
                                    
                                            <div class="{{ $bgColor }} p-0.5 rounded mb-1 ">
                                                <strong>{{ $schedule->student->name ?? 'N/A' }}</strong><br>
                                                {{-- ({{ $schedule->subject->subjectname ?? 'N/A' }}) <br> --}}
                                                <strong>{{ optional($schedule->studentRoom)->roomname ?? 'N/A' }}</strong> <br>
                                                <span class="{{ $textColor }}">({{ $status }})</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="bg-gray-100 p-1 rounded text-gray-900">N/A</span>
                                    @endif                           
                                    </td>
                                @endforeach
                                
                        
                                @role('admin')
                                <td class="px-6 py-4 border-b border-gray-300 whitespace-nowrap">
                                    <div class="flex justify-start gap-2">
                                        <!-- Delete Button to Trigger Modal -->
                                        <button onclick="confirmDeleteByRoomAndDate({{ $schedule->room_id }}, '{{ $schedule->schedule_date }}')"
                                            class="bg-red-500 hover:bg-transparent px-5 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider 
                                                border-2 border-red-500 hover:border-red-500 text-white hover:text-red-500 rounded-xl transition ease-in duration-150">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                                @endrole    
                            </tr>
                        @endforeach
                </tbody>
            </table>           
        </div>
            <div class="mt-6 flex justify-end">
                {{ $schedules->links('vendor.pagination.tailwind') }}
            </div>         


{{-- this is the code to show the teacher's modal from the partial directory --}}
<div id="teacherStudentsModalContainer"></div>



<!-- Delete Modal for individual record in the modal delete button(for modal button delete) -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="group select-none w-[250px] flex flex-col p-4 relative items-center justify-center bg-gray-800 border border-gray-800 shadow-lg rounded-2xl">
        <div class="text-center p-3 flex-auto justify-center">
            <svg fill="currentColor" viewBox="0 0 20 20" class="group-hover:animate-bounce w-12 h-12 flex items-center text-gray-600 fill-red-500 mx-auto" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" fill-rule="evenodd"></path>
            </svg>
            <h2 class="text-xl font-bold py-4 text-gray-200">Are you sure?</h2>
            <p class="font-bold text-sm text-gray-500 px-2">
                Do you really want to continue? This process cannot be undone.
            </p>
        </div>
        <div class="p-2 mt-2 text-center flex justify-center items-center space-x-4">
            <button onclick="closeModal()" class="bg-gray-100 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider 
                                           border-2 border-gray-100 hover:border-gray-100 text-gray-900 hover:text-gray-100 rounded-xl transition ease-in duration-150">
                Cancel
            </button>
            <form id="deleteForm" action="" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider 
                                           border-2 border-red-500 hover:border-red-500 text-white hover:text-red-500 rounded-xl transition ease-in duration-150">
                    Confirm
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal that will delete all the row delete button in the page -->
<div id="roomdeleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-gray-900 p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-4 text-gray-100">Confirm Deletion</h2>
        <p class="text-gray-100">Are you sure you want to delete all schedules for this teacher and room on this date?</p>
        
        <div class="mt-6 flex justify-end gap-2">
            <button onclick="roomcloseModal()" class="bg-gray-100 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider 
                                           border-2 border-gray-100 hover:border-gray-100 text-gray-900 hover:text-gray-100 rounded-xl transition ease-in duration-300">Cancel</button>

            <button id="confirmDeleteBtn" class="bg-red-500 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider 
                                           border-2 border-red-500 hover:border-red-500 text-white hover:text-red-500 rounded-xl transition ease-in duration-300">Delete</button>
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

// Function to Send PATCH Request
function updateStudentStatus(studentId, selectedStatus) {
    fetch(`/schedules/${studentId}/status`, { // Ensure route matches web.php
        method: "PATCH",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            status: selectedStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Updated successfully:", data);
    })
    .catch(error => console.error("Error:", error));
}

// function to close the teacher's students modal 
function closeTeacherStudentsModal() {
    document.getElementById('teacherStudentsModal').classList.add('hidden');
}



    // Function to open the delete modal (duplicate removal handled)
    function openModal(id) {
        document.getElementById('deleteForm').action = '/schedules/' + id; 
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    // Function to close the delete modal to avoid duplication
    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // function to confirm the deletion of a schedule in the modal
    function confirmDelete(studentId) {
        const deleteModal = document.getElementById("deleteModal");
        const deleteForm = document.getElementById("deleteForm");

        // Set the form action dynamically
        deleteForm.action = "{{ route('schedules.destroy', '') }}/" + studentId;

        // Show the modal
        deleteModal.classList.remove("hidden");
        deleteModal.classList.add("flex");
    }

    function closeModal() {
        const deleteModal = document.getElementById("deleteModal");
        deleteModal.classList.add("hidden");
        deleteModal.classList.remove("flex");
    }


   
 // delete all schedules for a room on a specific date  
    let deleteRoomId, deleteScheduleDate;

function confirmDeleteByRoomAndDate(roomId, scheduleDate) {
    deleteRoomId = roomId;
    deleteScheduleDate = scheduleDate;
    document.getElementById('roomdeleteModal').classList.remove('hidden');
}

function roomcloseModal() {
    document.getElementById('roomdeleteModal').classList.add('hidden');
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    fetch(`/schedules/delete-room-date/${deleteRoomId}/${deleteScheduleDate}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Schedules deleted successfully.");
            location.reload(); // Refresh the page to reflect changes
        } else {
            alert("Failed to delete schedules.");
        }
        roomcloseModal();
    }).catch(error => {
        console.error("Error:", error);
        roomcloseModal();
    });
});
</script>
</x-app-layout>

