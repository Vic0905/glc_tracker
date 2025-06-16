<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students') }}
            <span class="text-sm text-gray-900">: {{$studentCount}} </span>
        </h2>
    </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div id="successMessage" class="bg-green-600 text-white p-4 mb-6 rounded-lg shadow-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const successMessage = document.getElementById('successMessage');
                            if (successMessage) {
                                setTimeout(() => {
                                    successMessage.style.transition = 'opacity 1.0s ease';
                                    successMessage.style.opacity = '0';
                                    setTimeout(() => successMessage.remove(), 500);
                                }, 3000);
                            }
                        });
                    </script>

                    
                    <div class="flex flex-wrap md:flex-nowrap justify-center items-center p-5 space-x-4 w-full">
                    
                        <form action="{{ route('students.index') }}" method="GET" class="flex items-center space-x-4 w-full max-w-3xl">
                            <!-- Search Input -->
                            <div class="relative w-full max-w-sm text-gray-800">
                                <input
                                    type="text"
                                    name="student_name"
                                    value="{{ request('student_name') }}"
                                    placeholder="Search by student name"
                                    class="block w-full px-4 py-3 pl-10 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out"/>
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
                        

                        <!-- Add Student Button (Right) -->
                        @role('admin')
                        <div class="flex justify-left">
                            <a href="{{ route('students.create') }}" 
                            class="bg-gray-900 hover:bg-transparent px-6 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 
                                    border-gray-500 hover:border-gray-500 text-gray-100 hover:text-gray-900 rounded-xl transition ease-in duration-150">
                                Add Student
                            </a>
                        </div>
                        @endrole
                    </div>

                

                    <!-- Students Table -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <table class="min-w-full table-auto border-collapse border border-gray-300">
                            <thead class="bg-slate-100 text-gray-900">
                                <tr>
                                    {{-- <th class="px-6 py-3 text-left border-b">ID</th> --}}
                                    <th class="px-6 py-3 text-left border-b text-sm">Name</th>
                                    <th class="px-6 py-3 text-left border-b text-sm">English Name</th>
                                    <th class="px-6 py-3 text-left border-b text-sm">Course</th>
                                    <th class="px-6 py-3 text-left border-b text-sm">Level</th>
                                    <th class="px-6 py-3 text-left border-b text-sm">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr class="hover:bg-gray-100">
                                        {{-- <td class="px-6 py-4 border-b text-gray-800">{{ $student->id }}</td> --}}
                                        <td class="px-6 py-4 border-b text-gray-800 text-xs">{{ $student->name }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 text-xs">{{ $student->english_name }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 text-xs">{{ $student->course }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 text-xs">{{ $student->level }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 text-xs">
                                                <div class="flex justify-start gap-2">
                                                    <!-- Edit Button -->
                                                    <button type="button" onclick="openEditModal({{ $student->id }}, '{{ $student->name }}', '{{ $student->english_name }}', '{{ $student->course }}', '{{ $student->level }}')"
                                                            class="group inline-flex items-center text-gray-800 hover:text-blue-600 text-sm cursor-pointer ml-1">
                                                    <!-- Edit Icon (Pencil) -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.232 5.232l3.536 3.536M9 11l6-6m2 2L9 17H5v-4l10-10z" />
                                                        </svg>
                                                        <span class="ml-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">Edit</span>
                                                    </button>
                                                    <!-- Delete Button as a direct form submission -->
                                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"  class="group inline-flex items-center text-red-500 hover:text-red-700 text-sm cursor-pointer">
                                                            <!-- Delete Icon (Trash) -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22" />
                                                            </svg>
                                                            <span class="ml-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">Delete</span>
                                                        </button>
                                                    </form>                                                      
                                                </div>
                                            </td>                                    
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @include('partials.students.edit-student-modal')

    <script>
    function openEditModal(studentId, name, englishName, course, level) {
        const modal = document.getElementById('editStudentModal');
        const form = document.getElementById('editStudentForm');
        const input = document.getElementById('modalName');
        const englishInput = document.getElementById('modalEnglishName');
        const courseInput = document.getElementById('modalCourse');
        const levelInput = document.getElementById('modalLevel');

        form.action = `/students/${studentId}`;
        input.value = name;
        englishInput.value = englishName;
        courseInput.value = course;
        levelInput.value = level;

        modal.classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editStudentModal').classList.add('hidden');
    }
    
    </script>
</x-app-layout>
