<div>
    <div class="container-fluid">
        <x-page-heading>
            {{ $product->title }} - {{ $product->quantity }}{{ $product->unit->title }}
        </x-page-heading>

        <div class="table-responsive">
            <table class="table table-striped
            table-hover
            table-bordered
            align-top">
                <thead class="">
                    <caption></caption>
                    <tr>
                        <th>ID</th>
                        <th>SKU Number</th>
                        <th>Date Added</th>
                        <th>Purchase/Opener</th>
                        <th>status</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($productItems as $item)
                        <tr class="">
                            <td scope="row">{{ $item->id }}</td>
                            <td>{{ $item->sku_number }}</td>
                            <td>{{ Carbon\Carbon::parse($item->created_at)->format('jS \of F, Y') }}</td>
                            <td>{!! $item->purchases->count() > 0
                                ? '<h5 class="text-danger">WAS PURCHASED</h5>'
                                : '<h5 class="text-primary">IS OPENING STOCK</h5>' !!}</td>
                            <td>{!! $item->is_dispatched ? '<h5 class="text-danger text-uppercase">Dispatched to '.$item->dispatches()->first()->department->title.'</h5>' : '<h5 class="text-success">IN STOCK</h5>' !!}</td>
                            <td><x-currency></x-currency>{{ number_format($item->price, 2) }}</td>
                            <td>
                                <button
                                    onclick="confirm('Are you Sure you want to delete this Product Item?')||event.stopImmediatePropagation()"
                                    wire:click="deleteProduct({{ $item->id }})" class="btn btn-danger flex-col mx-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
                <tfoot>
                    {{ $productItems->links() }}
                </tfoot>
            </table>
            {{ $productItems->links() }}


            <!-- Modal trigger button -->
            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addProduct">
                Add One Product
            </button>

            <!-- Modal Body -->
            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
            <div wire:ignore.self class="modal fade" id="addProduct" tabindex="-1" data-bs-backdrop="static"
                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Add a New <strong>{{ $product->title }} -
                                    {{ $product->quantity }}{{ $product->unit->title }}</strong> into the system</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="sku_number" class="form-label">SKU Number</label>
                                <div class="input-group">
                                    <input wire:model="productItem.sku_number" type="text" class="form-control"
                                        name="sku_number" id="sku_number" aria-describedby="sku" disabled
                                        placeholder="Click Button to generate">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"
                                        wire:click="generateSku">Generate new SKU</button>
                                </div>
                                @error('productItem.sku_number')
                                    <small class="text-danger form-text">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="sku_number" class="form-label">Price <small class="text-danger">(in
                                        {{ env('DEFAULT_CURRENCY') }})</small></label>
                                <input wire:model="productItem.price" type="number" min="0" step="0.05"
                                    class="form-control" name="sku_number" id="sku_number" aria-describedby="sku"
                                    placeholder="Default Price is KES {{ $product->price }}">
                                @error('productItem.price')
                                    <small class="text-danger form-text">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" wire:click="addProduct">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal trigger button -->
            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalId">
                Mass Add Products
            </button>

            <!-- Modal Body -->
            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
            <div wire:ignore.self class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static"
                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Mass Addition of Products</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Quantity</label>
                                <input type="number" min="0" step="1" wire:model="quantity"
                                    class="form-control" name="" id="" aria-describedby="helpId"
                                    placeholder="Enter the Number of {{ $product->title }}s you want to add">
                                @error('quantity')
                                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Price</label>
                                <input type="number" min="0" step="0.01" wire:model="price"
                                    class="form-control" name="" id="" aria-describedby="helpId"
                                    placeholder="Default Price is KES {{ $product->price }}">
                                @error('price')
                                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" wire:click="addProducts">Save</button>
                        </div>
                    </div>
                </div>
            </div>


            <button type="button" onclick="confirm('Are you Sure you want to delete all Opening Stock?')||event.stopImmediatePropagation()" wire:click="deleteAllProducts" class="btn btn-primary btn-lg" >
                Delete All Opening Stock
            </button>

        </div>
    </div>
</div>
