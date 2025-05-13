<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Update Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage Data Product</flux:subheading>
        <flux:separator variant="subtle"/>
    </div>
    @if(session()->has('succesMessage'))
    <flux:badge color="lime" class="mb-3 w-full">{{session()->get('succesMessage')}}</flux:badge>
    @elseif(session()->has('errorMessage'))
    <flux:badge color="red" class="mb-3 w-full">{{session()->get('errorMessage')}}</flux:badge>
    @endif

    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf

                    <flux:select name="category_slug" label="Category" class="mb-3" required>
  @foreach($categories as $category)
    <option value="{{ $category->slug }}" {{ old('category_slug') == $category->slug ? 'selected' : '' }}>
      {{ $category->name }}
    </option>
  @endforeach
</flux:select>

        <div class="grid grid-cols-1 gap-6">
            <flux:input name="name" label="Name" value="{{ $product->name }}" placeholder="Product Name" class="mb-3" required/>
            
            <flux:input name="slug" label="Slug" value="{{ $product->slug }}" placeholders="product-name" class="mb-3" required/>

            <flux:input name="sku" label="SKU" value="{{ $product->sku }}" placeholders="product-name" class="mb-3" required/>

            <flux:input name="price" label="Price" value="{{ $product->price }}" placeholders="product-name" class="mb-3" required/>

            <flux:input name="stock" label="Stock" value="{{ $product->stock }}" placeholders="product-name" class="mb-3" required/>


         @php
           $categories = \App\Models\Categories::all();
         @endphp

         <!-- <div class="mb-3">
             <label for="category_slug" class="block font-medium text-sm text-gray-700">Category</label>
             <select name="category_slug" id="category_slug" required
                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                 <option value="">-- Select Category --</option>
                 @foreach($categories as $category)
                     <option value="{{ $category->slug }}">{{ $category->name }}</option>
                 @endforeach
             </select>
         </div> -->

            
            <flux:textarea name="description" label="Description" placeholder="Product Description" class="mb-3" required>
                {{ $product->description }}
            </flux:textarea>

            @if($product->image)
            <div class="mb-3">
                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-32 h-32 object-cover rounded">
            </div>
            @endif

            <flux:input  type="file" label="Image" name="image_url" class="mb-3"/>
            <flux:separator/>
        </div>

        <div class="mt-4">
            <flux:button type="submit" icon="" variant="primary" class="mt-4 text-black ">Update</flux:button>
            <flux:link href="{{ route('product.index') }}" variant="ghost" class="ml-3 bg-black text-white p-3 rounded-xl">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>