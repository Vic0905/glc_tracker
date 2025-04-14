<!-- resources/views/partials/available_slots_modal.blade.php -->
<div id="availableSlotsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Available Rooms & Teachers</h2>
            <button onclick="closeAvailableSlotsModal()" class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
        </div>

        <div class="mb-4">
            <label for="modal-availability-date" class="block text-sm font-medium">Select Date:</label>
            <input type="date" id="modal-availability-date" class="w-full border rounded p-2 mt-1" />
        </div>

        <div class="mb-4">
            <label for="modal-availability-time" class="block text-sm font-medium">Select Time:</label>
            <select id="modal-availability-time" class="w-full border rounded p-2 mt-1">
                <option value="time_8_00_8_50">08:00 - 08:50</option>
                <option value="time_9_00_9_50">09:00 - 09:50</option>
                <option value="time_10_00_10_50">10:00 - 10:50</option>
                <option value="time_11_00_11_50">11:00 - 11:50</option>
                <option value="time_12_00_12_50">12:00 - 12:50</option>
                <option value="time_13_00_13_50">13:00 - 13:50</option>
                <option value="time_14_00_14_50">14:00 - 14:50</option>
                <option value="time_15_00_15_50">15:00 - 15:50</option>
                <option value="time_16_00_16_50">16:00 - 16:50</option>
                <option value="time_17_00_17_50">17:00 - 17:50</option>
            </select>
        </div>

        <button onclick="checkAvailability()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">Check</button>

        <div id="availableResults" class="mt-4 text-sm hidden">
            <div><strong>Rooms:</strong> <span id="availableRooms" class="text-gray-700"></span></div>
            <div class="mt-1"><strong>Teachers:</strong> <span id="availableTeachers" class="text-gray-700"></span></div>
        </div>
    </div>
</div>
