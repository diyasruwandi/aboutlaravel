<x-layouts.app :title="('Product')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Product Management</flux:heading>
        <flux:separator variant="subtle" class="mt-6"/>
    </div>

        <div class="flex justify-between items-center mb-4">
        <div>
            <form action="{{ route('product.index') }}" method="get">
                @csrf
                <flux:input icon="magnifying-glass" name="q" value=""
                    placeholder="Search Product" />
            </form>
        </div>
        <div>
            <flux:button icon="plus">
                <flux:link href="{{ route('product.create') }}"
                    variant="subtle">Add New Product</flux:link>
            </flux:button>
        </div>
    </div>
    @if(session()->has('successMessage'))
    <flux:badge color="lime" class="mb-3 w-full">{{session()->get('successMessage')}}</flux:badge>
    @endif


<div class="overflow-x-auto">
    <table class="min-w-full bg-transparent leading-normal">
        <thead>
            <tr>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">ID</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">Image</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">Name</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">Slug</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">Description</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">SKU</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">Price</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">Stock</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">Created at</th>
                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm text-white">Action</th>
            </tr>
    </thead>
    
    <tbody>
        @foreach($products as $key=>$item)
        <tr class="border-b border-gray-200">
            <td class="px-4 py-2">
                <p class="text-white whitespace-no-wrap">
                    {{ $key+1 }}
                </p>
            </td>

            <td class="px-4 py-2">
                <p class="text-gray-900 whitespace-no-wrap">
                    @if($item->image_url)
                    <img src="{{ Storage::url($item->image_url) }}" alt="{{ $item->name }}" class="h-10 w-10 rounded-full">
                    @else
                    <div class="h-10 w-10 bg-gray-200 flex items-center justify-center rounded">
                        <span class="text-black text-sm">N/A</span>
                    </div>
                    @endif
                </p>
            </td>
            
            <td class="px-4 py-2">
                <p  class="text-white whitespace-no-wrap">
                    {{ $item->name }}
                </p>
            </td>

            <td class="px-4 py-2">
                <p  class="text-white whitespace-no-wrap">
                    {{ $item->slug }}
                </p>
            </td>
            
            <td class="px-4 py-2">
                <p  class="text-white whitespace-no-wrap">
                    {{ $item->description }}
                </p>
            </td>
            
            <td class="px-4 py-2">
                <p  class="text-white whitespace-no-wrap">
                    {{ $item->sku }}
                </p>
            </td>
            
            <td class="px-4 py-2">
                <p  class="text-white whitespace-no-wrap">
                    {{ $item->price }}
                </p>
            </td>
            
            <!-- <td class="px-4 py-2">
                <p  class="text-white whitespace-no-wrap">
                    {{ $item->stock }}
                </p>
            </td> -->

            <td>
                @if ($item->stock > 0)
                <div class="h-4 w-16 rounded-full bg-green-500"></div>
                @else
                <div class="h-4 w-16 rounded-full bg-red-500"></div>
                @endif
            </td>


            
            <td class="px-4 py-2">
                <p  class="text-white whitespace-no-wrap">
                    {{ $item->created_at }}
                </p>
            </td>
            
            <td class="px-4 py-2">
                <flux:dropdown>
                    <flux:button
                        icon:trailing="chevron-down">Action</flux:button>
                    <flux:menu>
                        <flux:menu.item icon="pencil" href="{{ route('product.edit', $item->id) }}">Edit</flux:menu.item>
                        <flux:menu.item icon="trash" variant="danger" onclick="event.preventDefault();
                        if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-form-{{ $item->id }}').submit();">Delete</flux:menu.item>
                        <form id="delete-form-{{ $item->id }}" action="{{ route('product.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form> 
                    </flux:menu>
                </flux:dropdown>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-3">
    {{ $products->links() }}
</div>
</div>



</x-layouts.app>