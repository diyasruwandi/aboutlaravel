<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:button>Create new Product</flux:button>
        <flux:subheading class=m-4>Form untuk menambah data product baru.</flux:subheading>
        <flux:separator variant="subtle"/>
    </div>

  @if(session()->has('successMessage'))
  <flux:badge color="lime" class="mb-3 w-full">{{session()->get('successMessage')}}</flux:badge>
  @elseif(session()->has('errorMessage'))
  <flux:badge color="red" class="mb-3 w-full">{{session()->get('errorMessage')}}</flux:badge>
  @endif

  <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

              <flux:select name="category_slug" label="Category" class="mb-3" required>
  @foreach($categories as $category)
    <option value="{{ $category->slug }}" {{ old('category_slug') == $category->slug ? 'selected' : '' }}>
      {{ $category->name }}
    </option>
  @endforeach
</flux:select>

    <div class="grid grid-cols-1 gap-6">

          <flux:input name="name" label="Name" placeholder="Product Name" class="mb-3" required/>

          <flux:input name="slug" label="Slug" placeholders="product-name" class="mb-3" required/>

          <flux:input name="sku" label="SKU" placeholders="product-name" class="mb-3" required/>

          <flux:input name="price" label="Price" placeholders="product-name" class="mb-3" required/>

          <flux:input name="stock" label="Stock" placeholders="product-name" class="mb-3" required/>

          @php
            $categories = \App\Models\Categories::all();
          @endphp

          <!-- <div class="mb-3">
              <label for="category_slug" class="block font-medium text-sm text-gray-700">Category</label>
              <select name="category_slug" id="category_slug" required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                  <option value="">-- Select Category --</option>
                  @foreach($categories as $category)
<option value="{{ $category->slug }}"
    @if(old('category_slug') == $category->slug || (isset($product) && $product->category->slug == $category->slug))
        selected
    @endif
>
    {{ $category->name }}
</option>

                  @endforeach
              </select>
          </div> -->


          <flux:textarea name="description" label="Description" placeholder="Product Description" class="mb-3" required/>

          <flux:input name="image_url" type="file" label="Image" placeholder="Product Image" class="mb-3"/>

          <flux:separator/>

    </div>
    <div class="mt-4">
        <flux:button type="submit" icon="" variant="primary" class="mt-4 text-black ">Create</flux:button>
        <flux:link href="{{ route('product.index') }}" variant="ghost" class="ml-3 bg-black text-white p-3 rounded-xl">Kembali</flux:link>
    </div>
  </form>
    
</x-layouts.app>