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
    <div id="searchbar" class="w-full py-4 px-20 gap-4 flex flex-row justify-center items-center">
        <input type="text" id="" oninput="handleSearch(this.value)" placeholder="Search Transaction by email"
            class="w-full border-2 border-black outline-none focus:border-blue-600 px-5 py-2">
    </div>
    <br>
    <table id="transactions" class="w-11/12 px-20 text-center mx-auto mb-10">
        <thead>
            <th class="px-5 py-2">No</th>
            <th class="px-5 py-2">Id Transaksi</th>
            <th class="px-5 py-2">Tanggal Transaksi</th>
            <th class="px-5 py-2">Nama Kasir</th>
            <th class="px-5 py-2">Nama Customer</th>
            <th class="px-5 py-2">Total Harga</th>
        </thead>
        <tbody id="result">
            @php
                $i = 0;
            @endphp
            @foreach ($transactions as $key => $value)
                <tr class="hover:bg-blue-100">
                    <td class="px-5 py-2 font-semibold">{{ ++$i }}</td>
                    <td class="px-5 py-2">{{ $value["id"] }}</td>
                    <td class="px-5 py-2">{{ $value["created_at"] }}</td>
                    <td class="px-5 py-2">{{ "Muhammad Faisal" }}</td>
                    <td class="px-5 py-2">{{ $value["email"] }}</td>
                    <td class="px-5 py-2">{{ $value["total"] }}</td>
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