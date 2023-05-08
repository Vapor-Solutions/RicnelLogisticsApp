<div>
    <div class="container-fluid">
        <x-page-heading>Customers</x-page-heading>

        <div class="card">
            <div class="card-header">
                <h5>Customer's Table</h5>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Affiliated Company</th>
                            <th scope="col">Address</th>
                            <th scope="col">Balance Unpaid</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr class="">
                                <td scope="row">{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone_number }}</td>
                                <td>{{ $customer->company_name }}</td>
                                <td>{{ $customer->address ?? 'NOT SET' }}</td>
                                    @php
                                        $balance = 0;

                                        if ($customer->sales) {
                                            foreach ($customer->sales as $sale) {
                                                $balance += $sale->balance;
                                            }
                                        }
                                    @endphp
                                <td class="{{$balance>0?'text-danger':'text-success' }}">

                                    <x-currency></x-currency>
                                    {{ number_format($balance, 2) }}
                                </td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                            class="btn btn-dark flex-col mx-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button
                                            onclick="confirm('Are you Sure you want to delete this customer?')||event.stopImmediatePropagation()"
                                            wire:click="delete({{ $customer->id }})"
                                            class="btn btn-danger flex-col mx-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $customers->links() }}
            </div>

        </div>
    </div>
</div>
