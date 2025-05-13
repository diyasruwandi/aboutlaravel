<x-layouts.app :title="__('Categories')">
  <div class="relative mb-6 w-full">
    <flux:button>Create new Product Category</flux:button>
    <flux:subheading class=m-4>Form untuk menambah data product category baru.</flux:subheading>
    <flux:separator variant="subtle"/>
  </div>

  @if(session()->has('succesMessage'))
  <flux:badge color="lime" class="mb-3 w-full">{{session()->get('succesMessage')}}</flux:badge>
  @elseif(session()->has('errorMessage'))
  <flux:badge color="red" class="mb-3 w-full">{{session()->get('errorMessage')}}</flux:badge>
  @endif

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6">          

          <flux:input name="name" label="Name" placeholder="Product Category Name" class="mb-3" required/>

          <flux:input name="slug" label="Slug" placeholders="product-category-name" class="mb-3" required/>

          <flux:textarea name="description" label="Description" placeholder="Product Description" class="mb-3" required/>

          <flux:input name="image" type="file" label="Image" placeholder="Product Image" class="mb-3"/>

          <flux:separator/>

        </div>

        <div class="mt-4">
          <flux:button type="submit" icon="" variant="primary" class="mt-4 text-black ">Create</flux:button>
          <flux:link href="{{ route('categories.index') }}" variant="ghost" class="ml-3 bg-black text-white p-3 rounded-xl">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>
