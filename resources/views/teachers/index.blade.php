<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teachers') }}
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
                                    setTimeout(() => successMessage.remove(), 500); // Fully removes the element after fading out
                                }, 3000); // 3-second delay before fading out
                            }
                        });
                    </script>


                    <div class="flex flex-wrap md:flex-nowrap justify-center items-center p-5 space-x-4 w-full">

                        <form action="{{ route('teachers.index') }}" method="GET" class="flex items-center space-x-4 w-full max-w-3xl">
                            <!-- Search Input -->
                            <div class="relative w-full max-w-sm text-gray-800">
                                <input
                                    type="text"
                                    name="teacher_name"
                                    value="{{ request('teacher_name') }}"
                                    placeholder="Search by subject name"
                                    class="block w-full px-4 py-3 pl-10 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out"
                                />
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 18a7 7 0 100-14 7 7 0 000 14zM21 21l-4.35-4.35" />
                                    </svg>
                                </div>
                            </div>
                        
                            <!-- Submit Button -->
                            <button
                                class="bg-gray-900 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-gray-200 hover:border-gray-200 text-gray-100 hover:text-gray-900 rounded-lg transition ease-in duration-100"
                                type="submit">
                                Search
                            </button>
                        </form>

                        <!-- Add Teacher Button (Right) -->
                        <div class="flex justify-left">
                            <a href="{{ route('teachers.create') }}" 
                            class="bg-gray-900 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider
                                border-2 border-gray-200 hover:border-gray-200 text-gray-100 hover:text-gray-900 rounded-lg transition ease-in duration-100">
                                Add Teacher
                                
                            </a>
                        </div>
                    </div>

                    
                <!-- Teachers Table -->
                <div class="bg-white shadow-lg sm:rounded-lg overflow-x-auto max-w-auto rounded-lg max-h-[500px] overflow-y-auto text-sm ">
                    <div class="min-w-full inline-block">
                        <table class="min-w-full table-auto border-collapse border border-gray-300">
                            <thead class="bg-gray-800 text-white sticky top-0 z-10">
                                <tr>
                                    {{-- <th class="px-6 py-3 text-left border-b">ID</th> --}}
                                    <th class="px-6 py-3 text-left border-b">Name</th>
                                    <th class="px-6 py-3 text-left border-b">Nickname</th>
                                    <th class="px-12 py-3 text-left border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                    <tr class="hover:bg-gray-100">
                                        {{-- <td class="px-6 py-4 border-b text-gray-800">{{ $teacher->id }}</td> --}}
                                        <td class="px-6 py-4 border-b text-gray-800 text-xs">{{ $teacher->name }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 text-xs">{{ $teacher->nickname }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 flex gap-2">
                                            <div class="flex justify-start gap-2">
                                                         <!-- Edit Button -->
                                                    <button type="button" onclick="openEditModal({{ $teacher->id }}, '{{ $teacher->name }}', '{{ $teacher->nickname }}')"
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
                                                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this teacher?');" class="inline">
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 flex justify-end">
                        {{ $teachers->links('vendor.pagination.tailwind') }}
                    </div>    
                </div>
            </div>
        </div>
    </div>
@include('partials.teachers.edit-teacher-modal')

    <script> 
       function openEditModal(teacherId, name, nickname) {
            const modal = document.getElementById('editteacherModal');
            const form = document.getElementById('editTeacherForm');
            const input = document.getElementById('modalName');
            const nicknameInput = document.getElementById('modalNickname');

            form.action = `/teachers/${teacherId}`;
            input.value = name;
            nicknameInput.value = nickname;

            modal.classList.remove('hidden');
       }
       function closeEditModal() {
            const modal = document.getElementById('editteacherModal').classList.add('hidden');
       }
    </script>
</x-app-layout>
