<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedules') }}
        </h2>
    </x-slot>
        
            
{{-- this is the code to call the buttons in the partial --}}
@include('partials.schedules.schedule_controls')

{{-- this is the code to call the schedule table in the partial --}}
@include('partials.schedules.schedule_table') 


{{-- this is the code to show the teacher's modal from the partial directory --}}
<div id="teacherStudentsModalContainer"></div>


{{-- code to call the modal delete from the partial --}}
@include('partials.schedules.delete_modal')

{{-- code to call the room delete from the partial --}}
@include('partials.schedules.room_delete_modal')




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

// // Function to Send PATCH Request
// function updateStudentStatus(studentId, selectedStatus) {
//     fetch(`/schedules/${studentId}/status`, { // Ensure route matches web.php
//         method: "PATCH",
//         headers: {
//             "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
//             "Content-Type": "application/json"
//         },
//         body: JSON.stringify({
//             status: selectedStatus
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         console.log("Updated successfully:", data);
//     })
//     .catch(error => console.error("Error:", error));
// }

// // function to close the teacher's students modal 
// function closeTeacherStudentsModal() {
//     document.getElementById('teacherStudentsModal').classList.add('hidden');
// }



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

