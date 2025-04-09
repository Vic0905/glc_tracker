<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center bg-gray-900 hover:bg-transparent px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-gray-900 hover:border-gray-900 text-white hover:text-gray-900 rounded-lg transition ease-in duration-300']) }}>
    {{ $slot }}
</button>
