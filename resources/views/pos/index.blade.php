<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Point of Sales</title>
</head>

<body>
    <!-- <x-header />
    <x-title>POS</x-title>
    <div class="flex flex-row justify-center items-start gap-5 px-10 py-10 w-full">
        <form action="{{ route('pos.add') }}" method="post" class="flex flex-col w-full gap-5">
            @csrf
            <h2 class="font-bold text-2xl">Form Tambah Produk</h2>
            <input type="hidden" name="product_id" value="{{$products->id}}">
            <div class="flex flex-row justify-between items-center gap-2 w-full">
                <label class="font-semibold" for="productName">Nama Produk</label>
                <input type="text" name="productName" id="productName"
                    class="w-1/2 px-2 py-4 border-2 border-black-200 focus:border-blue-600">
            </div>
            <div class="flex flex-row justify-between items-center gap-2 w-full">
                <label class="font-semibold" for="quantity">Jumlah</label>
                <input type="number" name="quantity" id="quantity" min="1" max="{{$products->stock}}"
                    class="w-1/2 px-2 py-4 border-2 border-black-200 focus:border-blue-600">
            </div>
            <button type="submit" class="w-full px-2 py-4 bg-blue-600 font-semibold hover:bg-indigo-600 text-white">
                Add To Cart
            </button>
        </form>
        <table class="w-full text-center">
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Nama Produk</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Harga Satuan</th>
                <th class="px-4 py-2">Subtotal</th>
                <th class="px-4 py-2">Action</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td class="font-semibold px-4 py-2">1</td>
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($product->price) }}</td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2">27000</td>
                    <td class="px-4 py-2"><button class="px-4 py-2 bg-red-600 text-white">X</button></td>
                </tr>
            @endforeach
            <tr>
                <td class="font-semibold px-4 py-2">1</td>
                <td class="px-4 py-2">Melon</td>
                <td class="px-4 py-2">3</td>
                <td class="px-4 py-2">9000</td>
                <td class="px-4 py-2">27000</td>
                <td class="px-4 py-2"><button class="px-4 py-2 bg-red-600 text-white">X</button></td>
            </tr>
            <tr>
                <th class="font-semibold" colspan="4" class="px-4 py-2">Total Harga</th>
                <td class="font-semibold" class="px-4 py-2">27000</td>
            </tr>
            <tr>
                <td colspan="6"><button class="w-full px-2 py-4 bg-blue-600 hover:bg-indigo-600">Checkout</button></td>
            </tr>
        </table>
    </div> -->
</body>

</html>