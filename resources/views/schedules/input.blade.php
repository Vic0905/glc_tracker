<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Schedule') }}
        
        </h2>
    </x-slot>

            <div class="flex flex-wrap md:flex-nowrap justify-center items-center p-5 space-x-4 w-full">
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
                        <button class="bg-gray-900 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-gray-200 hover:border-gray-200 text-gray-100 hover:text-gray-900 rounded-lg transition ease-in duration-100"
                            type="submit">
                            Generate
                        </button>
                    </form>
                </div>
             
                <!-- Add Schedule Button (Centered on Mobile) -->
                <div class="flex justify-center w-full">
                    <a href="{{ route('schedules.index') }}" 
                    class="bg-gray-900 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-gray-200 hover:border-gray-200 text-gray-100 hover:text-gray-900 rounded-lg transition ease-in duration-100">
                        Back to Schedules
                    </a>
                </div>      
            </div>

            @include('partials.schedules.schedule_input')


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

// // Function to show teacher students (assuming this is defined elsewhere)
// function showTeacherStudents(teacherId, scheduleDate) {
//     // Implement logic to show a modal or redirect with teacher's students
//     alert(`Showing students for Teacher ID: ${teacherId} on Date: ${scheduleDate}`);
  
// }

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
