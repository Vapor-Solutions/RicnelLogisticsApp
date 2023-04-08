<div wire:init="loadStuff">
    <div class="container-fluid">
        <!-- Page Heading -->
        <x-page-heading>
            Welcome {{ auth()->user()->name }}
        </x-page-heading>
        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Number of Products</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @if ($products)
                                        {{ number_format(count($products)) }}
                                    @else
                                        <div class="spinner-grow" role="status"></div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Inventory Value ({{ env('DEFAULT_CURRENCY') }})</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @if ($products)
                                        <x-currency></x-currency>{{ number_format($inventory_value, 2) }}
                                    @else
                                        <div class="spinner-grow" role="status"></div>
                                    @endif

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="row mx-3">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Purchases ({{ Carbon\Carbon::now()->format('F, Y') }})
                                    ({{ env('DEFAULT_CURRENCY_SYMBOL') }})</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @if ($purchasesThisMonth)
                                        <x-currency></x-currency>{{ number_format($purchasevalue, 2) }}
                                    @else
                                        <div class="spinner-grow" role="status"></div>
                                    @endif

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="row mx-3">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Sale Value ({{ Carbon\Carbon::now()->format('F, Y') }})
                                    ({{ env('DEFAULT_CURRENCY_SYMBOL') }})</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @if ($salesThisMonth)
                                        <x-currency></x-currency>{{ number_format($saleValue, 2) }}
                                    @else
                                        <div class="spinner-grow" role="status"></div>
                                    @endif

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="row mx-3">

                        </div>
                    </div>
                </div>
            </div>

        </div>



        {{-- Activity Log --}}

        @if (auth()->user()->roles->contains('id', 1))
            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Activity</th>
                                        <th scope="col">Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $activity)
                                        <tr class="">
                                            <td scope="row">{{ $activity->id }}</td>
                                            <td>{{ $activity->user->name }} {{ $activity->payload }}</td>
                                            <td>{{ Carbon\Carbon::parse($activity->created_at)->format('jS F, Y h:i:sA') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $activities ? $activities->links() : '' }}
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </div>

</div>
