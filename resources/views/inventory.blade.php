<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Inventory</title>
</head>

<body>
    <x-header />

    <div id="searchbar" class="w-full py-4 px-20 gap-4 flex flex-row justify-center items-center">
        <input type="text" id="" oninput="handleSearch(this.value)" placeholder="Search Transaction by nama"
            class="flex-1 border-2 border-black rounded-xl outline-none focus:border-blue-600 px-5 py-2">
        <button type="button" onclick="handleAddProduct()"
            class="w-auto text-wrap px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg">Tambah Produk</button>
    </div>
    <div id="addProduct"
        class="fixed z-50 top-0 left-0 w-svw h-svh hidden justify-center items-center bg-black bg-opacity-25">
        <form method="post" id="formAddProduct"
            class="w-96 p-8 flex flex-col justify-center items-center gap-5 bg-white rounded-lg">
            <input type="hidden" name="productId" id="productId" value="">
            <h2 id="formTitle" class="w-full font-bold text-xl">Form Tambah Produk</h2>
            <div class="w-full flex flex-row justify-between items-center gap-5">
                <label for="name" class="font-semibold w-full text-left">Nama Produk</label>
                <input type="text" name="name" id="name"
                    class="bg-white px-4 py-2 rounded-lg border-2 border-black outline-none focus:border-blue-600">
            </div>
            <div class="w-full flex flex-row justify-between items-center gap-5">
                <label for="price" class="font-semibold w-full text-left">Harga</label>
                <input type="number" name="price" id="price"
                    class="bg-white px-4 py-2 rounded-lg border-2 border-black outline-none focus:border-blue-600">
            </div>
            <div class="w-full flex flex-row justify-between items-center gap-5">
                <label for="stock" class="font-semibold w-full text-left">Stock</label>
                <input type="number" name="stock" id="stock"
                    class="bg-white px-4 py-2 rounded-lg border-2 border-black outline-none focus:border-blue-600">
            </div>
            <div class="w-full flex flex-row justify-between items-center gap-5">
                <input type="reset" onclick="handleCancel()"
                    class="w-full px-4 py-2 bg-white text-black font-semibold rounded-lg" value="Batalkan">
                <input type="submit" id="formSubmit"
                    class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg" value="Tambah">
            </div>
        </form>
    </div>
    <br>
    <table id="products" class="w-11/12 px-20 text-center mx-auto mb-10">
        <thead>
            <th class="px-5 py-2">No</th>
            <th class="px-5 py-2">Nama</th>
            <th class="px-5 py-2">Harga</th>
            <th class="px-5 py-2">Stock</th>
            <th class="px-5 py-2">Action</th>
        </thead>
        <tbody id="result">
            @php
                $i = 0;
            @endphp
            @foreach ($products as $key => $value)
                <tr class="hover:bg-blue-100">
                    <td class="px-5 py-2 font-semibold">{{ ++$i }}</td>
                    <td class="px-5 py-2 text-left">{{ $value["name"] }}</td>
                    <td class="px-5 py-2">{{ $value["price"] }}</td>
                    <td class="px-5 py-2">{{ $value["stock"] }}</td>
                    <td class="px-5 py-2 flex gap-5">
                        <button onclick="handleAddProduct({{$value['id']}})"
                            class="px-6 py-2 text-white bg-blue-600 rounded-lg flex justify-center items-center gap-2"><img
                                class="max-w-5 hidden md:block" src="{{asset('assets/edit.svg')}}" alt=""> Edit</button>
                        <button onclick="handleDeleteProduct({{$value['id']}})"
                            class="px-6 py-2 bg-white rounded-lg flex justify-center items-center gap-2"><img
                                class="max-w-5 hidden md:block" src="{{asset('assets/trash.svg')}}" alt=""> Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="loading" class="hidden fixed z-50 top-0 left-0 w-svw h-svh justify-center items-center bg-white">
        <img src="{{ asset('assets/loading.jpg') }}" alt="... loading" class="w-44 rounded-full">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let products = @json($products);
        console.log(products);

        function handleSearch(value) {
            let text = value;
            let result = [];

            products.forEach(value => {
                if (value["name"].toLowerCase().includes(text)) {
                    result.push(value);
                }
            });

            console.log(result);
            searchResult(result);
        }

        function searchResult(result) {
            let row = "";

            result.forEach((value, index) => {
                row += `
                <tr class="hover:bg-blue-100">
                    <td class="px-5 py-2 font-semibold">${++index}</td>
                    <td class="px-5 py-2 text-left">${value["name"]}</td>
                    <td class="px-5 py-2">${value["stock"]}</td>
                    <td class="px-5 py-2">${value["price"]}</td>
                    <td class="px-5 py-2 flex gap-5">
                        <button onclick="handleAddProduct({{$value['id']}})"
                            class="px-6 py-2 text-white bg-blue-600 rounded-lg flex justify-center items-center gap-2"><img
                                class="max-w-5 hidden md:block" src="{{asset('assets/edit.svg')}}" alt=""> Edit</button>
                        <button onclick="handleDeleteProduct({{$value['id']}})"
                            class="px-6 py-2 bg-white rounded-lg flex justify-center items-center gap-2"><img
                                class="max-w-5 hidden md:block" src="{{asset('assets/trash.svg')}}" alt=""> Delete</button>
                    </td>
                </tr>`
            });

            document.getElementById("result").innerHTML = row;
        }

        async function fetchProducts() {
            const csrfToken = "{{csrf_token()}}";
            const urlProducts = "{{ route("products.index")}}";

            await fetch(urlProducts, {
                method: "GET",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
            }).then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            }).then(data => {
                if (data.success) {
                    products = data.data;
                    searchResult(products);
                }
            }).catch(err => {
                console.log(err);
            });
        }

        document.getElementById("formAddProduct").addEventListener(
            "submit", handleSubmitProduct
        );

        async function handleSubmitProduct(e) {
            e.preventDefault();

            const loading = document.getElementById("loading");
            loading.classList.replace("hidden", "flex");

            const csrfToken = "{{csrf_token()}}";
            const urlAdd = "{{ route('products.add') }}";
            const urlUpdate = "{{ route('products.update') }}";

            let data;

            id = document.getElementById("productId").value;
            name = document.getElementById("name").value;
            price = document.getElementById("price").value;
            stock = document.getElementById("stock").value;

            if (id) {
                alert(productId);
                data = {
                    id: id,
                    name: name,
                    price: price,
                    stock: stock
                }


                await fetch(urlUpdate, {
                    method: "PUT",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data),
                }).then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                }).then(response => {
                    if (response.success) {
                        loading.classList.replace("flex", "hidden");
                        console.log("response data product: ", response);

                        Swal.fire({
                            title: "Success Updated!",
                            text: response.message,
                            icon: "success"
                        });

                        fetchProducts();
                        handleCancel();
                    }
                }).catch(err => {
                    console.log(err);
                });
            } else {
                data = {
                    name: name,
                    price: price,
                    stock: stock
                }

                await fetch(urlAdd, {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data),
                }).then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                }).then(response => {
                    if (response.success) {
                        loading.classList.replace("flex", "hidden");
                        console.log("response data product: ", response);

                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });

                        fetchProducts();
                        handleCancel();
                    }
                }).catch(err => {
                    console.log(err);
                });
            }
        }

        async function handleDeleteProduct(productId) {
            const csrfToken = "{{csrf_token()}}";
            const url = "{{ route('products.destroy') }}";

            Swal.fire({
                title: 'Do you want to Delete Product?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                customClass: {
                    actions: 'my-actions',
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                },
            }).then(async (result) => {
                if (result.isConfirmed) {

                    await fetch(`${url}/${productId}`, {
                        method: "DELETE",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    }).then(response => {
                        if (response.success) {
                            loading.classList.replace("flex", "hidden");
                            console.log("response data delete: ", response);

                            fetchProducts();
                            handleCancel();
                        }
                    }).catch(err => {
                        console.log(err);
                    });

                    Swal.fire('Delete Successfully!', '', 'success')
                } else if (result.isDenied) {
                    Swal.fire('Delete Cancelled', '', 'info')
                }
            })
        }

        function handleCancel() {
            document.getElementById("addProduct").classList.replace("flex", "hidden");
            document.getElementById("name").value = "";
            document.getElementById("price").value = "";
            document.getElementById("stock").value = "";
            document.getElementById("productId").value = "";
        }

        function handleAddProduct(productId) {
            document.getElementById("addProduct").classList.replace("hidden", "flex");

            document.getElementById("formTitle").innerText = "Form Tambah Product";
            document.getElementById("formSubmit").value = "Tambah";

            if (productId) {
                console.log(productId);
                document.getElementById("productId").value = productId;
                document.getElementById("formTitle").innerText = "Form Edit Product";
                document.getElementById("formSubmit").value = "Update";
            }
        }
    </script>
</body>

</html>