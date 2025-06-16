<div id="editRoomModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4 sm:mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800" id="editModalTitle">Edit Room</h2>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="editRoomForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PATCH') {{-- Use PATCH method for updates --}}

            <div>
                <label for="modalRoomName" class="block text-sm font-medium text-gray-700">Room Name</label>
                <input
                    type="text"
                    name="roomname"
                    id="modalRoomName"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="bg-gray-900 hover:bg-transparent px-6 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-gray-200 hover:border-gray-200 text-gray-100 hover:text-gray-900 rounded-xl transition ease-in duration-100">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-transparent px-6 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-blue-500 hover:border-gray-100 text-gray-100 hover:text-blue-900 rounded-xl transition ease-in duration-100">
                    Update Room
                </button>
            </div>
        </form>
    </div>
</div>