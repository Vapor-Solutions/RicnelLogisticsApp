<div>
    <div class="container-fluid">
        <x-page-heading>Add a Purchase</x-page-heading>

        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Add Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="supplier_id" class="form-label">Supplier</label>
                                    <select wire:model="quoteRequest.supplier_id" class="form-control"
                                        name="supplier_id" id="supplier_id">
                                        <option selected>Select one</option>
                                        @foreach (App\Models\Supplier::all() as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('quoteRequest.supplier_id')
                                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="purchase" class="form-label">Purchase Date</label>
                                    <input wire:model="quoteRequest.purchase_date" type="date"
                                        max="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                        name="purchase" id="purchase" aria-describedby="date"
                                        placeholder="Enter the purchase date">
                                    @error('quoteRequest.purchase_date')
                                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Product Description</label>
                                    <select wire:model="product_id" class="form-control" name="" id="">

                                        <option selected>Select one</option>

                                        @foreach ($productDescriptions as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->brand->name != 'Miscellaneous' ? $product->brand->name : '' }}
                                                {{ $product->title }}
                                                -
                                                {{ $product->quantity . $product->unit->symbol }}
                                                <br>
                                                <sup>{{ $product->description != '-' ? $product->description : '' }}</sup>
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Quantity</label>
                                    <input wire:model="quantity" type="number" min="1" step="1"
                                        class="form-control" name="" id="" aria-describedby="helpId"
                                        placeholder="Enter the Number of items you want to buy">
                                    @error('quantity')
                                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-dark" wire:click="addToCart">Add To List</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Added Products</h5>
                    </div>
                    <div class="card-body">
                        @if (count($productsList) > 0)

                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Product Description</th>
                                            <th scope="col">Quantity</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($productsList as $key => $item)
                                            @php
                                                $product = App\Models\ProductDescription::find($item[0]);
                                            @endphp

                                            <tr class="">
                                                <td scope="row">{{ $product->id }}</td>
                                                <td>{{ $product->brand->name != 'Miscellaneous' ? $product->brand->name : '' }}
                                                    {{ $product->title }}
                                                    -
                                                    {{ $product->quantity . $product->unit->symbol }}
                                                    <br>
                                                    <sup>{{ $product->description != '-' ? $product->description : '' }}</sup>
                                                </td>
                                                <td>{{ $item[1] }}</td>

                                                <td>
                                                    <button class="btn btn-danger btn-sm"
                                                        wire:click="remove({{ $key }})"><i
                                                            class="fas fa-xs fa-times"></i></button>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        @endif
                    </div>
                    <div class="card-footer">
                        @if ($productsList)
                            <button class="btn btn-dark text-uppercase" wire:click="makePurchase">
                                Make Purchase
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
