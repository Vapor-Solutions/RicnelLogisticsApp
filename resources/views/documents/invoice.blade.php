<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice No. #{{ $invoice->id }}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        /*
        @page {
            size: 7in 9.25in;
            margin: 27mm 16mm 27mm 16mm;
        } */

        table {
            font-size: x-small;

        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }
    </style>

</head>

<body>

    <table width="100%">
        <tr>
            <td valign="top"
                style="background: transparent url({{ env('APP_URL') }}/logo.png);width: 185px;height: 150px;background-position: center;background-size: 185px;">
            </td>
            <td align="right">
                <h2 style="font-size: 28px">Ricnel Logistics</h2>
                <h2 style="font-size: 20px" style="color: #17046d">Invoice No. #{{ sprintf('%04d', $invoice->id) }}</h2>
                <pre>
                    <strong>Date:</strong>
                    {{ Carbon\Carbon::parse($invoice->sale->sale_date)->format('jS F, Y h:i A') }}
            </pre>
            </td>
        </tr>

    </table>

    <br>
    <br>

    <table width="100%">
        <tr style="font-size: 12px;">
            <td>
                <strong>From:</strong>
                Ricnel Logistics <br>
                {{ env('COMPANY_ADDRESS_1') }} <br>
                {{ env('COMPANY_ADDRESS_2') }} <br>
                {{ env('COMPANY_COUNTY') }}, {{ env('COMPANY_COUNTRY') }} <br>
                {{ env('COMPANY_CONTACT') }} <br>
            </td>

            <td>
                <strong>To:</strong> {{ $invoice->sale->customer->name }} <br>
                {{ $invoice->sale->customer->email }}<br>
                {{ $invoice->sale->customer->address }}<br><br>
                {{ $invoice->sale->customer->phone_number }}<br>
            </td>
        </tr>

    </table>

    <br />
    <br />
    <strong>Delivery type:</strong> STANDARD<br>
    <strong>Generated By:</strong> {{ $invoice->user->name }}<br>
    <br>
    <table width="100%">
        <thead style="background-color: lightgray; font-size:12px;">
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price (KES)</th>
                <th>Total (KES)</th>
            </tr>
        </thead>
        <tbody>

            @php
                $total_count = 0;
                $total_cost = 0;
            @endphp
            @foreach ($invoice->productDescriptions() as $product)
                @php
                    $count = 0;
                    $cost = 0;
                @endphp
                @foreach ($invoice->sale->productItems as $item)
                    @if ($product->product_description_id == $item->product_description_id)
                        @php
                            $cost += $item->pivot->sale_price;
                            $count++;
                            $total_count++;
                            $total_cost += $item->pivot->sale_price;
                        @endphp
                    @endif
                @endforeach

                    <tr style="font-size:12px">
                        <th scope="row">#{{ $product->productDescription->id }}</th>
                        <td>{{ $product->productDescription->brand->name != 'Miscellaneous' ? $product->productDescription->brand->name : '' }}</span>
                            {{ $product->productDescription->title }} - {{ $product->productDescription->quantity }}{{ $product->productDescription->unit->symbol }}</td>
                        <td align="right">{{ $count }}</td>
                        <td align="right">{{ number_format($product->count > 0 ? $cost / $product->count : 0, 2) }}</td>
                        <td align="right">{{ number_format($cost, 2) }}</td>
                    </tr>
                    <tr></tr>
            @endforeach
        </tbody>
        <br>
        <br>
        <br>
        <br>
        <tfoot>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td align="right">Subtotal KES</td>
                <td align="right" style="font-size:16px">
                    <x-currency></x-currency> {{ number_format($total_cost, 2) }}
                </td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td align="right"></td>
                <td align="right">Tax KES</td>
                <td align="right" style="font-size:16px">
                    <x-currency></x-currency> 0.00
                </td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td align="right"></td>
                <td align="right">Total KES</td>
                <td align="right" class="gray" style="font-size:16px">
                    <x-currency></x-currency> {{ number_format($total_cost, 2) }}
                </td>
            </tr>
        </tfoot>
        </tbody>

    </table>
    <br>
    <br>
    <h2 style="color: #17046d; text-align:center">Thank You for Your Business!!</h2>

</body>

</html>
