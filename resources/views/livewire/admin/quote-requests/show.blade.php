<div>
    <div class="container">
        <x-page-heading>
            Local quoteRequest quoteRequest No. #{{ sprintf('%04d', $quoteRequest->id) }}
        </x-page-heading>
        <div class="row justify-content-start">
            <div class="col-12">
                {{ env('COMPANY_NAME') }}
            </div>
            <div class="col-12">
                {{ env('COMPANY_ADDRESS_1') }}
            </div>
            <div class="col-12">
                {{ env('COMPANY_ADDRESS_2') }}
            </div>
            <div class="col-12">
                {{ env('COMPANY_CONTACT') }}</div>
        </div>
        <div class="row justify-content-end mt-3">
            <div class="col-12 ">
                <p class="me-auto"><u>Supplier</u>: {{ $quoteRequest->supplier->name ?? '' }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-12">
                <div class="card my-5">
                    <div class="table-responsive " style="height: 600px">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Product Description</th>
                                    <th scope="col">Product Unit Size</th>
                                    <th scope="col">Product Unit Cost</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($quoteRequest->productDescriptions as $item)
                                    <tr class="">
                                        <td scope="row">{{ $item->id }}</td>
                                        <td>{{ $item->brand->name != 'Miscellaneous' ? $item->brand->name : '' }}
                                            {{ $item->title }}
                                            -
                                            {{ $item->quantity . $item->unit->symbol }}
                                            <br>
                                            <sup>{{ $item->description != '-' ? $item->description : '' }}</sup></td>
                                        <td>{{ $item->quantity . $item->unit->symbol }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
