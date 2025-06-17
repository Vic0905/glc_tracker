<!-- Edit Student Modal -->
<div id="editStudentModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 w-full max-w-lg mx-4 transition-all">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800" id="editModalTitle">Edit Student</h2>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-red-500 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Form -->
        <form id="editStudentForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PATCH')

            <!-- Student Name -->
            <div>
                <label for="modalName" class="block text-sm font-medium text-gray-700 mb-1">Student Name</label>
                <input
                    type="text"
                    name="name" 
                    id="modalName"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    required
                >
            </div>

            <!-- English Name -->
            <div>
                <label for="modalEnglishName" class="block text-sm font-medium text-gray-700 mb-1">English Name</label>
                <input
                    type="text"
                    name="english_name"
                    id="modalEnglishName"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    required
                >
            </div>

            <!-- Course -->
            <div>
                <label for="modalCourse" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                <input
                    type="text"
                    name="course"
                    id="modalCourse"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    required
                >
            </div>

            <!-- Level -->
            <div>
                <label for="modalLevel" class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                <input
                    type="text"
                    name="level" 
                    id="modalLevel"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    required
                >
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4">
                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="bg-gray-900 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-gray-200 hover:border-gray-200 text-gray-100 hover:text-gray-900 rounded-lg transition ease-in duration-100"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-blue-500 hover:border-gray-100 text-gray-100 hover:text-blue-900 rounded-lg transition ease-in duration-100"
                >
                    Update Student
                </button>
            </div>
        </form>
    </div>
</div>
