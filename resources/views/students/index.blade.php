<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students') }}
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
                        class="bg-gray-900 hover:bg-transparent px-6 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 
                              border-gray-500 hover:border-gray-500 text-gray-100 hover:text-gray-900 rounded-xl transition ease-in duration-300"
                            type="submit">
                            Search
                    </button>
                </form>
                

                <!-- Add Student Button (Right) -->
                @role('admin')
                <div class="flex justify-left mb-6">
                    <a href="{{ route('students.create') }}" 
                    class="flex justify-center gap-2 items-center mx-auto shadow-xl text-lg bg-gray-50 backdrop-blur-md lg:font-semibold isolation-auto border-gray-50 before:absolute before:w-full before:transition-all before:duration-700 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-gray-900 hover:text-gray-50 before:-z-10 before:aspect-square before:hover:scale-150 before:hover:duration-700 relative z-10 px-4 py-2 overflow-hidden border-2 rounded-full group">
                        Add Student
                        <svg class="w-8 h-8 justify-end group-hover:rotate-90 group-hover:bg-gray-50 text-gray-50 ease-linear duration-300 rounded-full border border-gray-700 group-hover:border-none p-2 rotate-45"
                            viewBox="0 0 16 19" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                                class="fill-gray-800 group-hover:fill-gray-800"></path>
                        </svg>
                    </a>
                </div>
                @endrole
            </div>

            

            <!-- Students Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <table class="min-w-full table-auto border-collapse border border-gray-300">
                            <thead class="bg-gray-800 text-white">
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
                                        <td class="px-6 py-4 border-b text-gray-800 text-sm">{{ $student->name }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 text-sm">{{ $student->english_name }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 text-sm">{{ $student->course }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 text-sm">{{ $student->level }}</td>
                                        <td class="px-6 py-4 border-b text-gray-800 text-sm">
                                                    <div class="flex justify-start gap-2">
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('students.edit', $student->id) }}" class="bg-gray-800 hover:bg-transparent px-5 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider 
                                    border-2 border-gray-500 hover:border-gray-500 text-white hover:text-gray-900 rounded-xl transition ease-in duration-300">Edit</a>
                                                
                                                        <!-- Delete Button to Trigger Modal -->
                                                        <button onclick="openModal()" class="bg-red-500 hover:bg-transparent px-5 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider 
                                        border-2 border-red-500 hover:border-red-500 text-white hover:text-red-500 rounded-xl transition ease-in duration-300">
                                                            Delete
                                                        </button>                                                        
                                                    </div>
                                                
                                                    <!-- Modal Background -->
                                                    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                                                        <div class="group select-none w-[250px] flex flex-col p-4 relative items-center justify-center bg-gray-800 border border-gray-800 shadow-lg rounded-2xl">
                                                            <div>
                                                                <div class="text-center p-3 flex-auto justify-center">
                                                                    <!-- Modal Icon (SVG) -->
                                                                    <svg fill="currentColor" viewBox="0 0 20 20" class="group-hover:animate-bounce w-12 h-12 flex items-center text-gray-600 fill-red-500 mx-auto" xmlns="http://www.w3.org/2000/svg">
                                                                        <path clip-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                    <!-- Modal Title and Description -->
                                                                    <h2 class="text-xl font-bold py-4 text-gray-200">Are you sure?</h2>
                                                                    <p class="font-bold text-sm text-gray-500 px-2">
                                                                        Do you really want to continue? This process cannot be undone.
                                                                    </p>
                                                                </div>
                                                                                                                <!-- Modal Actions -->
                                                                <div class="p-2 mt-2 text-center flex justify-center items-center space-x-4">
                                                                    <!-- Cancel Button -->
                                                                    <button onclick="closeModal()" class="bg-gray-700 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border-2 border-gray-600 hover:border-gray-700 text-gray-300 rounded-full hover:shadow-lg hover:bg-gray-800 transition ease-in duration-300">
                                                                        Cancel
                                                                    </button>

                                                                    <!-- Confirm Delete Button that Submits the Form -->
                                                                    <form id="deleteForm" action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="bg-red-500 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 hover:border-red-500 text-white hover:text-red-500 rounded-full transition ease-in duration-300">
                                                                            Confirm
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
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
    </div>

    <script>
            
    // Open the modal
    function openModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    // Close the modal
    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    </script>
</x-app-layout>
