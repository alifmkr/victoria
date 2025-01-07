<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Transactions</title>
</head>

<body>
    <x-header />
    <x-title>Transactions</x-title>
    <div id="searchbar" class="w-full py-4 px-20 gap-4 flex flex-row justify-center items-center bg-gray-100 shadow-md rounded-lg">
        <input type="text" id="" oninput="handleSearch(this.value)" placeholder="Search Transaction by email"
            class="w-full border-2 border-gray-300 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-300 px-5 py-2 rounded-lg transition duration-200">
    </div>
    <br>
    <table id="transactions" class="w-11/12 px-20 text-center mx-auto mb-10 border-collapse border border-gray-300 shadow-md rounded-lg">
        <thead class="bg-blue-500 text-white">
            <tr>
                <th class="px-5 py-2 border border-gray-300">No</th>
                <th class="px-5 py-2 border border-gray-300">Id Transaksi</th>
                <th class="px-5 py-2 border border-gray-300">Tanggal Transaksi</th>
                <th class="px-5 py-2 border border-gray-300">Nama Kasir</th>
                <th class="px-5 py-2 border border-gray-300">Nama Customer</th>
                <th class="px-5 py-2 border border-gray-300">Total Harga</th>
            </tr>
        </thead>
        <tbody id="result">
            @php
                $i = 0;
            @endphp
            @foreach ($transactions as $key => $value)
                <tr class="hover:bg-blue-100 transition duration-200">
                    <td class="px-5 py-2 font-semibold border border-gray-300">{{ ++$i }}</td>
                    <td class="px-5 py-2 border border-gray-300">{{ $value["id"] }}</td>
                    <td class="px-5 py-2 border border-gray-300">{{ $value["created_at"] }}</td>
                    <td class="px-5 py-2 border border-gray-300">{{ "Muhammad Faisal" }}</td>
                    <td class="px-5 py-2 border border-gray-300">{{ $value["email"] }}</td>
                    <td class="px-5 py-2 border border-gray-300">{{ $value["total"] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        const transactions = @json($transactions);
        console.log(transactions);

        function handleSearch(value) {
            let text = value;
            console.log(text);
            let result = [];

            transactions.forEach(value => {
                if (value["email"].includes(text)) {
                    console.log(value);
                    result.push(value);
                }
            });

            console.log(result);
            searchResult(result);
        }

        function searchResult(result){
            // let result = result;
            let row = "";

            result.forEach((value, index) => {
                const date = new Date(value["created_at"]);

                row += `<tr class="hover:bg-blue-100">
                    <td class="px-5 py-2 font-semibold">${ ++index }</td>
                    <td class="px-5 py-2">${ value["id"] }</td>
                    <td class="px-5 py-2">${ date.toLocaleString() }</td>
                    <td class="px-5 py-2">Muhammad Faisal</td>
                    <td class="px-5 py-2">${ value["email"] }</td>
                    <td class="px-5 py-2">${ value["total"] }</td>
                </tr>`
            });

            document.getElementById("result").innerHTML = row;
        }
    </script>
</body>

</html>