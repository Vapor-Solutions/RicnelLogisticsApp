<div>
    <div class="container-fluid">
        <x-page-heading>
            quoteRequests List
        </x-page-heading>

        <div class="card my-5 shadow-sm">
            <div class="card-header">
                <h5>List of quoteRequests Made</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered
                align-middle">
                        <thead class="">
                            <caption></caption>
                            <tr>
                                <th>ID</th>
                                <th>RFQ Date</th>
                                <th>Number of Products</th>

                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($quoteRequests as $quoteRequest)
                                <tr class="">
                                    <td scope="row">{{ $quoteRequest->id }}</td>
                                    <td>{{ Carbon\Carbon::parse($quoteRequest->quoteRequest_date)->format('jS F, Y') }}</td>
                                    <td>{{ count($quoteRequest->productDescriptions) }}</td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            <div class="flex-col mx-2">
                                                <a href="{{ route('admin.quotation-requests.generate', $quoteRequest->id) }}" target="_blank"
                                                    class="btn btn-dark">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </div>
                                            <div class="flex-col mx-2">
                                                <a href="{{ route('admin.quotation-requests.show', $quoteRequest->id) }}"
                                                    class="btn btn-dark">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                            </div>
                                            <div class="flex-col mx-2">
                                                <a href="{{ route('admin.quotation-requests.edit', $quoteRequest->id) }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="flex-col mx-2">
                                                <button
                                                    onclick="confirm('Are You Sure you want to delete this Product quoteRequest?')||event.stopImmediatePropagation()"
                                                    wire:click="delete({{ $quoteRequest->id }})" class="btn btn-danger">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>

            </div>
            <div class="card-footer">
                {{ $quoteRequests->links() }}
            </div>
        </div>
    </div>
</div>
