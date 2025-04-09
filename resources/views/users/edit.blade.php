<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-100">
                    <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">Edit User</h1>

                    <div class="max-w-2xl mx-auto bg-white p-10 rounded-lg shadow-lg">
                        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                    
                      <!-- Back Button -->
                      <div class="flex justify-right mb-6">
                        <a href="{{ url()->previous() }}" 
                        class="bg-gray-900 hover:bg-transparent px-6 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 
                                    border-gray-500 hover:border-gray-500 text-gray-100 hover:text-gray-900 rounded-xl transition ease-in duration-300">
                            ← Back
                        </a>
                    </div>

                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-lg font-medium text-gray-700 mb-2">Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="block w-full text-lg py-3 px-4 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter teacher's name" 
                            required
                            value="{{ $user->name }}">
                        @error('name')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-lg font-medium text-gray-700 mb-2">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="block w-full text-lg py-3 px-4 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter teacher's email" 
                            required
                            value="{{ $user->email }}">
                        @error('email')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                   <!-- Role Selection -->
                    <div class="mb-6">
                        <label for="role_id" class="block text-lg font-medium text-gray-700 mb-2">Role</label>
                        <select 
                            name="role_id" 
                            id="role_id" 
                            class="block w-full text-lg py-3 px-4 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->roles->first()->id ?? '') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button 
                                type="submit" 
                                class="bg-gray-900 hover:bg-transparent px-6 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 
                                    border-gray-500 hover:border-gray-500 text-gray-100 hover:text-gray-900 rounded-xl transition ease-in duration-300">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
