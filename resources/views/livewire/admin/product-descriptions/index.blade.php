<div>
    <div class="container-fluid">
        <x-page-heading>
            Products List
        </x-page-heading>

        <div class="card my-5 shadow-sm">
            <div class="card-header">
                <h5>List of Product Descriptions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-striped
                    table-hover
                    table-bordered

                    align-middle">
                        <thead class="">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Brand Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Unit Size</th>
                                <th>Unit Price</th>
                                <th>No. of Units Available</th>
                                <th>Estimated Value</th>
                                <th>Actual Value</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        @php
                            $sum = 0;
                            $actual_sum = 0;
                        @endphp

                        <tbody class="table-group-divider">
                            @foreach ($product_descriptions as $description)
                                @php
                                    $sum += $description->total_value;
                                    $actual_sum += $description->actual_value;

                                @endphp
                                <tr>
                                    <td scope="row">{{ $description->id }}</td>
                                    <td>{{ $description->title }}</td>
                                    <td>{{ $description->brand->name }}</td>
                                    <td>{{ $description->description }}</td>
                                    <td>{{ $description->category->title }}</td>
                                    <td>{{ $description->quantity . ' ' . $description->unit->symbol }}</td>
                                    <td>KES {{ number_format($description->price, 2) }}</td>
                                    <td>{{ $description->available_items }}</td>
                                    <td>KES {{ number_format($description->total_value, 2) }}</td>
                                    <td>KES {{ number_format($description->actual_value, 2) }}</td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            <div class="flex-col mx-2">
                                                <a href="{{ route('admin.product-descriptions.show', $description->id) }}"
                                                    class="btn btn-dark">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                            </div>
                                            <div class="flex-col mx-2">
                                                <a href="{{ route('admin.product-descriptions.edit', $description->id) }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="flex-col mx-2">
                                                <button
                                                    onclick="confirm('Are You Sure you want to delete this Product Description?')||event.stopImmediatePropagation()"
                                                    wire:click="delete({{ $description->id }})" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                                <td colspan="7">
                                    <h4 class="text-center">TOTAL ON PAGE</h4>
                                </td>
                                <td class="text-dark">
                                    <h4>
                                        <x-currency></x-currency><strong>{{ number_format($sum, 2) }}</strong>
                                    </h4>
                                </td>
                                <td
                                    class="{{ $actual_sum > $sum ? 'text-danger' : ($actual_sum == $sum ? 'text-secondary' : 'text-success') }}">
                                    <h4>
                                        <x-currency></x-currency><strong>{{ number_format($actual_sum, 2) }}</strong>
                                    </h4>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
                {{-- <div class="card-footer">
                    {{ $product_descriptions->links() }}
                </div> --}}

            </div>
            <div class="row">
                <div class="col-6">
                    <h4 class="text-center">
                        Estimated Value of all Products
                    </h4>
                    <h2 class="text-center my-5">
                        <x-currency></x-currency>{{ number_format($inventory_value, 2) }}
                    </h2>
                </div>
                <div class="col-6">
                    <h4 class="text-center">
                        Actual Value of all Products
                    </h4>
                    <h2
                        class="text-center {{ $actual_inventory > $inventory_value ? 'text-danger' : ($actual_inventory == $inventory_value ? 'text-secondary' : 'text-success') }} my-5">
                        <x-currency></x-currency>{{ number_format($actual_inventory, 2) }}
                    </h2>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.product-descriptions.stock-sheet') }}" target="_blank"
            class="btn btn-secondary">Download Stock Sheet</a>
    </div>
</div>
