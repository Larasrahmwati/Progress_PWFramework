<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>


 
  <div class="container p-4 mx-auto">f
    <div class="overflow-x-auto">
      
    @if (session('success'))
    <div class="mb-4 rounded-lg bg-green-50 p-4">
        <p style="color: #22c55e;">{{ session('success') }}</p> 
    @elseif(session('error'))
    <div class="mb-4 rounded-lg bg-red-50 p-4">
        <p style="color: #ef4444;">{{ session('error') }}</p> 
    </div>
    @endif
    <form method="GET" action="{{ route('product-index') }}" class="mb-4 flex items-center">
      <input type="text" name="search" value"{{ request('search') }}" placeholder="Cari produk...." class="w-1/4 rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
      <button type="submit" class="ml-2 rounded-lg bg-green-500 px-4 py-2 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Cari</button>
    </form>

      <a href="{{ route('product-create')}}">
      <button class="px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
            Add product data
        </button>

        <a href="{{ route('product-export-excel') }}">
        <button class="px-4 py-2 text-white bg-blue-500 border border-blue-500 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4 text-sm">
          Export to Excel
        </button>
      </a>

      <a href="{{ route('product.export.pdf') }}">
      <button class="px-4 py-2 text-white bg-blue-500 border border-blue-500 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4 text-sm">
          Export to PDF
        </button>
      </a>

    </a>
      <table class="min-w-full border border-collapse border-gray-200">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">ID</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Product Name</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Unit</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Type</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">information</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">qty</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">producer</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Aksi</th>
          </tr>
        </thead>
        <tbody>
        <tbody>
        @php
          $currentPage = $products->currentPage();
          $perPage = $products->perPage();
          $startIndex = ($currentPage - 1) * $perPage;
        @endphp

       @forelse ($products as $product)
          <tr class="bg-white">
            <!-- Ganti $loop->iteration dengan $startIndex + $loop->iteration -->
            <td class="px-4 py-2 border border-gray-200">{{ $startIndex + $loop->iteration }}</td>
            <td class="border-gray-200 px-4 py-2 hover:text-blue-500 hover:underline">
              <a href="{{ route('product-detail', $product->id)}}">
                {{ $product->product_name }}
              </a>
            </td>
            <td class="px-4 py-2 border border-gray-200">{{ $product->unit }}</td>
            <td class="px-4 py-2 border border-gray-200">{{ $product->type }}</td>
            <td class="px-4 py-2 border border-gray-200">{{ $product->information }}</td>
            <td class="px-4 py-2 border border-gray-200">{{ $product->qty }}</td>
            <td class="px-4 py-2 border border-gray-200">{{ $product->producer }}</td>
            <td class="px-4 py-2 border border-gray-200">
              <a href="{{ route('product-edit', $product->id) }}" class="px-2 text-blue-600 hover:text-blue-800">Edit</a>
              <button class="px-2 text-red-600 hover:text-red-800" onclick="confirmDelete('{{ route('product-deleted', $product->id) }}')">Hapus</button>
            </td>
          </tr>
       @empty
        <p class="mb-4 text-center text-2xl font-bold text-red-600">No products found</p>
      @endforelse



          <!-- Tambahkan baris lainnya sesuai kebutuhan -->
        </tbody>
      </table>
      {{--Pagination--}}
      <div class="mt-4">
        {{-- {{ $products->links() }} --}}
        {{ $products->appends(['search' => request('search')])->links() }}
      </div>
    </div>
  </div>


  <script>
    function confirmDelete(deleteUrl) {
            console.log(deleteUrl);
            if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
                // Jika user mengonfirmasi, kita dapat membuat form dan mengirimkan permintaan delete
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
   
                // Tambahkan CSRF token
                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
   
                // Tambahkan method spoofing untuk DELETE (karena HTML form hanya mendukung GET dan POST)
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
   
                // Tambahkan form ke body dan submit
                document.body.appendChild(form);
                form.submit();
            }
        }
  </script>




</x-app-layout>

