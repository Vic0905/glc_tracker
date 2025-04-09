<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
         <!-- Teachers Table -->
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg overflow-y-auto">
                    <div class="min-w-full inline-block">
                        <table class="min-w-full table-auto border-collapse border border-gray-300">
                            <thead class="bg-gray-800 text-white sticky top-0 z-10">
                                <tr>
                                    {{-- <th class="px-6 py-3 text-left border-b">ID</th> --}}
                                    <th class="px-6 py-3 text-left border-b text-sm">Name</th>
                                    <th class="px-12 py-3 text-left border-b text-sm">Email</th>
                                    <th class="px-12 py-3 text-left border-b text-sm">Role</th>
                                    <th class="px-12 py-3 text-left border-b text-sm">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-100">
                                        {{-- <td class="px-6 py-4 border-b text-gray-800">{{ $user->id }}</td> --}}
                                        <td class="px-6 py-4 border-b text-gray-800 text-xs" >{{ $user->name }}</td>
                                        <td class="px-12 py-4 border-b text-gray-800 text-xs">{{ $user->email }}</td>
                                        <td class="px-12 py-4 border-b text-gray-800 text-xs">
                                            {{ $user->roles->pluck('name')->implode(', ') }} <!-- Display Roles -->
                                        </td>
                                        <td class="px-12 py-4 border-b text-gray-800">
                                            <div class="flex justify-start gap-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('users.edit', $user->id) }}" class="bg-gray-800 hover:bg-transparent px-5 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider 
                                                    border-2 border-gray-500 hover:border-gray-500 text-white hover:text-gray-900 rounded-xl transition ease-in duration-300">Edit</a>
                                        

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
</x-app-layout>



