<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Point of Sales</title>
</head>

<body>
    <x-header />
    <div class="flex flex-col md:flex-row justify-center items-start gap-10 md:gap-5 px-10 py-10 w-full">
        <form id="cart" method="post" onsubmit="return handleCartSubmit(event)"
            class="flex flex-col w-full gap-5 justify-end">
            @csrf
            <h2 class="font-bold text-2xl">Form Tambah Produk</h2>
            <div class="flex flex-row justify-between items-center gap-2 w-full">
                <label class="font-semibold" for="selectProduct">Nama Produk</label>
                <select name="selectProduct" id="selectProduct" onchange="handleSelectProduct(this.value)"
                    class="w-1/2 px-2 py-4 border-2 border-black-200 focus:border-blue-600">
                    <option value="0" selected>Pilih Produk</option>
                    @foreach ($products as $product)
                        <option value="{{$product->id}}" {{$product->stock == 0 ? "disabled" : ""}}>{{$product->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-row justify-between items-center gap-2 w-full">
                <label class="font-semibold" for="quantity" id="quantityLabel">Jumlah</label>
                <div class="w-1/2 flex flex-col justify-center items-center gap-2">
                    <input type="number" name="quantity" id="quantity" min="1" placeholder="0" max=""
                        onchange="handleQuantity(this.value)"
                        class="w-full px-2 py-4 border-2 border-black-200 focus:border-blue-600 outline-none">
                    <p class="w-full hidden opacity-50" id="quantity-alert">Stock available 0</p>
                </div>
            </div>
            <button type="submit" id="addToCart"
                class="w-full md:w-1/2 px-2 py-4 bg-blue-600 font-semibold hover:bg-indigo-600 text-white">
                Tambah Pesanan
            </button>
        </form>
        <div class="w-full text-center flex flex-col justify-center items-end gap-10">
            <h2 class="font-bold text-2xl">Keranjang Belanja</h2>
            <table class="w-full">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama Produk</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Harga Satuan</th>
                    <th class="px-4 py-2">Subtotal</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
                <tbody id="cartBody"></tbody>
                <tr>
                    <th class="font-semibold px-4 py-2 text-start" colspan="4">Total Harga</th>
                    <td class="font-bold text-2xl px-4 py-2" colspan="2" id="total">0</td>
                </tr>
            </table>
            <div class="w-full md:w-1/2 flex flex-col justify-center items-center gap-5">
                <div class="w-full">
                    <input type="text" id="email"
                        class="w-full px-2 py-4 border-2 border-black-200 focus:border-blue-600 outline-none"
                        placeholder="Email">
                </div>
                <div class="w-full"><button onclick="handleCheckout()" id="buttonCheckout"
                        class="w-full px-2 py-4 text-white font-semibold bg-red-600 hover:bg-red-800">Checkout</button>
                </div>
            </div>
        </div>
    </div>
    <div id="loading" class="hidden fixed z-50 top-0 left-0 w-svw h-svh justify-center items-center bg-white">
        <img src="{{ asset('assets/loading.jpg') }}" alt="... loading" class="w-44 rounded-full">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let stock;
        fetchCart();

        function handleSelectProduct(id) {
            const csrfToken = "{{csrf_token()}}";
            const url = "/admin/products/" + id;

            console.log(id);
            fetch(
                `${url}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
            }
            ).then(response => {
                console.log("Server Response: ", response);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            }).then(data => {
                if (data.success) {
                    stock = data.data.stock;
                    document.getElementById("quantity").max = data.data.stock;
                    document.getElementById("quantity-alert").classList.replace("hidden", "block");
                    document.getElementById("quantity-alert").innerText = `Stock available ${data.data.stock}`;
                } else {
                    console.log(data.message);
                }
            }).catch(error => {
                console.log("Error: ", error);
            }
            );
        }

        function handleQuantity(quantity) {
            if (quantity > stock) {
                document.getElementById("addToCart").disabled = true;
                document.getElementById("addToCart").classList.replace("hover:bg-indigo-600", "opacity-50");
                document.getElementById("quantity-alert").classList.replace("opacity-50", "text-red-600");
            } else {
                document.getElementById("addToCart").disabled = false;
                document.getElementById("addToCart").classList.replace("opacity-50", "hover:bg-indigo-600");
                document.getElementById("quantity-alert").classList.replace("text-red-600", "opacity-50");
            }
        }

        function handleCartSubmit(event) {
            event.preventDefault();

            const csrfToken = "{{ csrf_token() }}";
            const url = "{{ route('cart.add') }}";

            let productId = document.getElementById("selectProduct").value;
            let quantity = document.getElementById("quantity").value;

            if (productId == null || productId == "0") {
                return alert("Produk belum dipilih");
            } else if (quantity == 0 || quantity == "") {
                return alert("Jumlah pesanan kurang dari 1");
            }

            const data = {
                "productId": productId,
                "quantity": quantity
            };

            fetch(
                url, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            }
            ).then(response => {
                console.log(response);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            }).then(data => {
                if (data.success) {
                    // alert(data.message);
                    console.log(data.cart);
                    fetchCart();
                }
            }
            ).catch(error => {
            });

            document.querySelector("option[value='0']").selected = true;
            document.getElementById("quantity").value = "";
        }

        async function fetchCart() {
            const csrfToken = "{{csrf_token()}}";
            const urlCart = "{{ route('cart.index') }}";
            const urlProducts = "{{ route("products.index")}}";

            await fetch(urlCart, {
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
                console.log(data);
                if (data.success) {
                    const dataCart = data.cart;

                    fetch(urlProducts).then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    }).then(dataProducts => {
                        console.log("datacart", dataCart);
                        console.log("dataProduct", dataProducts);

                        const cartBody = document.getElementById("cartBody");
                        cartBody.innerHTML = "";


                        const filteredProducts = dataProducts.data.filter((value, index) => {
                            return dataCart[index + 1] != undefined
                        });

                        console.log("filter ", filteredProducts);

                        // total harga semua product yang di beli
                        let total = 0;

                        filteredProducts.forEach((value, index) => {
                            let productId = dataCart[value.id]["product_id"];
                            let productName = value["name"];
                            let price = value["price"];
                            let quantity = dataCart[value.id]["quantity"];
                            let subTotal = price * quantity;
                            total += subTotal;

                            const row = `
                    <tr>
                        <td class="font-semibold px-4 py-2">${index + 1}</td>
                        <td class="text-start px-4 py-2">${productName}</td>
                        <td class="px-4 py-2">${quantity}</td>
                        <td class="px-4 py-2">Rp ${price}</td>
                        <td class="px-4 py-2">Rp ${subTotal}</td>
                        <td class="px-4 py-2"><button class="px-4 py-2 bg-red-600 text-white" onclick='handleRemoveItem(${productId})'>X</button></td>
                    </tr>
                `;
                            cartBody.innerHTML += row;
                        });

                        document.getElementById("total").innerText = "Rp " + total;
                        document.getElementById("buttonCheckout").disabled = false;
                        document.getElementById("buttonCheckout").classList.remove("opacity-50");
                    });
                } else {
                    const cartBody = document.getElementById("cartBody");
                    cartBody.innerHTML = `<td colspan='6' class='font-italic p-5'>${data.message}</td>`;
                    document.getElementById("total").innerText = "Rp " + "0";
                    document.getElementById("buttonCheckout").disabled = true;
                    document.getElementById("buttonCheckout").classList.add("opacity-50");
                }
            }).catch(err => {
                console.log(err);
            });
        }

        async function handleRemoveItem(productId) {
            const loading = document.getElementById("loading");
            loading.classList.replace("hidden", "flex");

            const csrfToken = "{{csrf_token()}}";
            const url = "{{ route('cart.remove')}}";

            await fetch(`${url}/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
            }).then(data => {
                fetchCart();
                loading.classList.replace("flex", "hidden");
            }).catch(err => console.log(err));
        }


        async function handleCheckout() {
            const loading = document.getElementById("loading");
            loading.classList.replace("hidden", "flex");

            const csrfToken = "{{csrf_token()}}";
            const urlCart = "{{ route('cart.index') }}";
            const urlTransaction = "{{ route('transaction.add') }}";

            let data;
            let dataCart;

            email = document.getElementById("email").value;
            validateEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!validateEmail.test(email)) {
                return alert("Email tidak Valid");
            }

            await fetch(urlCart, {
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
            }).then(response => {
                if (response.success) {
                    dataCart = response.cart;
                    console.log(dataCart);
                }
            }).catch(err => {
                console.log(err);
            });

            data = {
                "user_id": 1,
                "email": email,
                "cart": dataCart
            };

            fetch(
                urlTransaction, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            }
            ).then(response => {
                console.log("response checkout: ", response);
                return response.json();
            }).then(response => {
                loading.classList.replace("flex", "hidden");
                console.log("response data checkout: ", response);

                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                });
                fetchCart();
                document.getElementById("email").value = "";
            }).catch(err => console.log(err));
        }
    </script>
</body>

</html>