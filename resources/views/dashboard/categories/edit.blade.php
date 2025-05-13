<x-layouts.app :title="__('Categories')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Update Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage Data Product Categories</flux:subheading>
        <flux:separator variant="subtle"/>
    </div>
    @if(session()->has('succesMessage'))
    <flux:badge color="lime" class="mb-3 w-full">{{session()->get('succesMessage')}}</flux:badge>
    @elseif(session()->has('errorMessage'))
    <flux:badge color="red" class="mb-3 w-full">{{session()->get('errorMessage')}}</flux:badge>
    @endif

    <!-- <flux:button>Edit Product Category</flux:button>
    <flux:separator variant="subtle"/> -->

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf

        <div class="grid grid-cols-1 gap-6">
            
            <flux:input name="name" label="Name" value="{{ $category->name }}" placeholder="Product Category Name" class="mb-3" required/>
            
            <flux:input name="slug" label="Slug" value="{{ $category->slug }}" placeholders="product-category-name" class="mb-3" required/>
            
            <flux:textarea name="description" label="Description" placeholder="Product Description" class="mb-3" required>
                {{ $category->description }}
            </flux:textarea>
            
            @if($category->image)
            <div class="mb-3">
                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded">
            </div>
            @endif
            
            <flux:input type="file" label="Image" name="image" class="mb-3"/>
            <flux:separator/>
        </div>

        <div>

            <flux:button type="submit" icon="" variant="primary" class="mt-4">Update</flux:button>
            <flux:link href="{{ route('categories.index') }}" variant="ghost" class="ml-3 bg-black text-white p-3 rounded-xl">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>