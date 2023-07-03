<div>
    <div class="container-fluid">
        <x-page-heading>Add a Purchase</x-page-heading>
        <div class="input-group mb-5">
            <input type="file" wire:model="file" class="form-control" placeholder="Recipient's username"
                aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" wire:click="uploadFile" id="button-addon2">Upload
                Data</button>
        </div>
        @error('file')
            <small id="helpId" class="form-text text-danger">{{ $message }}</small>
        @enderror

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
                                    <select wire:model="purchase.supplier_id" class="form-control" name="supplier_id"
                                        id="supplier_id">
                                        <option selected>Select one</option>
                                        @foreach (App\Models\Supplier::all() as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('purchase.supplier_id')
                                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="purchase" class="form-label">Purchase Date</label>
                                    <input wire:model="purchase.purchase_date" type="date"
                                        max="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                        name="purchase" id="purchase" aria-describedby="date"
                                        placeholder="Enter the purchase date">
                                    @error('purchase.purchase_date')
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
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Price</label>
                                    <input wire:model="price" type="number" min="1" step="0.01"
                                        class="form-control" name="" id="" aria-describedby="helpId"
                                        placeholder="Recomm: KES {{ number_format(App\Models\ProductDescription::find(intval($product_id))->price ?? 0) }}">
                                    @error('price')
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
                                            <th scope="col">Unit Cost</th>
                                            <th scope="col" class="text-right">Total Cost</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $complete_total = 0;
                                        @endphp
                                        @foreach ($productsList as $key => $item)
                                            @php
                                                $product = App\Models\ProductDescription::find($item[0]);
                                            @endphp

                                            <tr class="">
                                                <td scope="row">{{ $product->id }}</td>
                                                <td>{{ $product->title }} -
                                                    {{ $product->quantity . $product->unit->symbol }}</td>
                                                <td>{{ $item[1] }}</td>
                                                <td>
                                                    <x-currency />{{ number_format($item[2], 2) }}
                                                </td>
                                                @php
                                                    $total = $item[1] * $item[2];
                                                @endphp
                                                <td class="text-right">
                                                    <x-currency />{{ number_format($total, 2) }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm"
                                                        wire:click="remove({{ $key }})"><i
                                                            class="fas fa-xs fa-times"></i></button>
                                                </td>

                                            </tr>

                                            @php
                                                $complete_total += $total;
                                            @endphp
                                        @endforeach
                                        <tr class="my-3">
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr class="my-3">
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr class="my-3">
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr class="my-3">
                                            <td style="border-top:0.5px solid #858796" colspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-right">Total</td>
                                            <td class="text-right">
                                                <x-currency />{{ number_format(($complete_total * 100) / 116, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-right">VAT (16%)</td>
                                            <td class="text-right">
                                                <x-currency />{{ number_format(($complete_total * 16) / 116, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-right">Complete Total (16%)</td>
                                            <td class="text-right">
                                                <x-currency />{{ number_format($complete_total, 2) }}
                                            </td>
                                        </tr>
                                        <td></td>
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
