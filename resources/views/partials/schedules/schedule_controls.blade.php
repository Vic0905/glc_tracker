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

        <!-- Date Selection Form (Centered on Mobile) this function will enable the-->
        <div class="flex flex-col items-center w-full mt-3">
            <form method="GET" action="{{ route('schedules.index') }}" class="flex flex-col md:flex-row items-center gap-2 w-full max-w-md text-gray-800">
                <input type="date" id="date" name="date" value="{{ $date }}" class="block w-full px-4 py-3 pl-10 text-gray-800 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out"/>
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
    <form action="{{ route('schedules.index') }}" method="GET" class="w-full max-w-5xl mx-auto flex flex-col md:flex-row md:items-center gap-4 p-4">
    
        <!-- Search Input -->
        <div class="relative w-full md:flex-1">
            <input type="text" name="student_name" value="{{ request('student_name') }}"
                placeholder="Search by student name"
                class="w-full px-4 py-3 pl-10 text-gray-800 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" />
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 18a7 7 0 100-14 7 7 0 000 14zM21 21l-4.35-4.35" />
                </svg>
            </div>
        </div>
    
        <!-- Search Button -->
        <div class="w-full md:w-auto">
            <button type="submit"
                class="w-full md:w-auto bg-gray-900 hover:bg-transparent px-6 py-2 text-xs font-medium tracking-wider border-2 border-gray-500 hover:border-gray-500 text-white hover:text-gray-900 rounded-xl transition duration-150 ease-in">
                Search
            </button>
        </div>

            <!-- Date Picker -->
            <div class="w-full md:w-auto">
                <input type="date" name="date" value="{{ $date }}"
                    class="w-full md:w-60 px-4 py-3 text-gray-800 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" />
            </div>
        
            <!-- Generate Button -->
            <div class="w-full md:w-auto">
                <button type="submit"
                    class="w-full md:w-auto bg-gray-900 hover:bg-transparent px-6 py-2 text-xs font-medium tracking-wider border-2 border-gray-500 hover:border-gray-500 text-white hover:text-gray-900 rounded-xl transition duration-150 ease-in">
                    Generate
                </button>
            </div>
    
    </form>
    @endrole
    
</div>