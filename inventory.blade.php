<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{$page['page']}}</title>
</head>
<body>
    <x-header />
    <x-title>Inventory</x-title>
    <h1>{{$page['page']}}</h1>
    <h3>{{$page['description']}}</h3>
    <table id="inventory" class="w-11/12 px-20 text-center mx-auto mb-10 border-collapse border border-gray-300 shadow-md rounded-lg">
    <thead class="bg-green-500 text-white">
        <tr>
            <th class="px-5 py-2 border border-gray-300">No</th>
            <th class="px-5 py-2 border border-gray-300">ID</th>
            <th class="px-5 py-2 border border-gray-300">Nama</th>
            <th class="px-5 py-2 border border-gray-300">Harga</th>
            <th class="px-5 py-2 border border-gray-300">Stock</th>
            <th class="px-5 py-2 border border-gray-300">Aksi</th>
        </tr>
    </thead>
    <tbody id="result">
        @php
            $i = 0;
        @endphp
        // @foreach ($inventory as $key => $value)"undefined dibagian view"
            <tr class="hover:bg-green-100 transition duration-200">
                <td class="px-5 py-2 font-semibold border border-gray-300">{{ ++$i }}</td>
                <td class="px-5 py-2 border border-gray-300">{{ $value["id"] }}</td>
                <td class="px-5 py-2 border border-gray-300">{{ $value["name"] }}</td>
                <td class="px-5 py-2 border border-gray-300">{{ $value["price"] }}</td>
                <td class="px-5 py-2 border border-gray-300">{{ $value["stock"] }}</td>
                <td class="px-5 py-2 border border-gray-300">
                    <button class="bg-yellow-500 text-white px-4 py-2 rounded-md">Edit</button>
                    <button class="bg-red-500 text-white px-4 py-2 rounded-md">Hapus</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Button untuk menambah item -->
<div class="text-center mb-5">
    <button class="bg-blue-500 text-white px-6 py-3 rounded-md">Tambah Item</button>
</div>

</body>


</html>