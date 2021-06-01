<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Invoice | Quotation</title>
    <!--favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="img/LOGO%20Asset%2013ldpi.png">
    <style>
        /* page */
        html {
            font: 15px/1 'Open Sans', sans-serif;
            overflow: auto;
            padding: 0.5in;
            background: #999;
            cursor: default;
        }

        body {
            box-sizing: border-box;
            height: 11in;
            margin: 0 auto;
            overflow: hidden;
            padding: 0.5in;
            width: 8.5in;
            background: #FFF;
            border-radius: 1px;
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        }

        @media print {

            * {
                -webkit-print-color-adjust: exact;
            }

            html {
                background: none;
                padding: 0;
            }

            body {
                box-shadow: none;
                margin: 0;
            }

        }

        @page {
            margin: 0;
        }

        /* header */
        /* main css */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .logo-img {
            float: left;
        }

        .logo-img img {
            width: 110px;
        }

        .provider-txt {
            float: right;
        }

        .provider-txt h4 {
            text-transform: uppercase;
            font-weight: bolder;
            padding-top: 10px;
        }

        .title-head {
            text-align: center;
            padding-top: 10px;
            border-bottom: 1px solid #000;
        }
        .title-head h1{
            margin-bottom: 5px;
        }

        .title-head p {
            margin: 0;
            padding: 0;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-size: 14px;
        }


        .title-head-txt {
            font-size: 25px !important;
            text-transform: uppercase;
        }

        .title-head h1 {
            text-transform: uppercase;
        }

        .main-contain-top{
            margin-top: 10px;
        }
        .main-contain-top p {
            text-transform: capitalize;
        }

        .main-contain-left {
            float: left;
            width: 50%;
        }

        .main-contain-right {
            float: left;
            width: 50%;
            text-align: right;
        }

        .data-table table {
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            text-transform: capitalize;
        }
        table th{
            background: #e6e6e6;
            text-align: left;
        }



        /* end main css */
    </style>
</head>

<body>

    <section class="header clearfix">
        <div class="logo-img">
            <img src="logo.png" alt="logo-img">
        </div>

    </section>

    <section class="title-head">
        <p class="title-head-txt">Amader Sanitary</p>
        <p>provider : Md. Amirul Islam (Amir)</p>
        <p>Janata Bank More, (Hafez Building Under Graound) Mujib Sarak, Niltuli,Faridpur</p>
        <p>mobile : +8801711111192  , +8801613000450</p>
        <h3>quotation</h3>
    </section>

    <section class="main-contain-top">
        <div class="main-contain-left">
            <p><b>quotation no.</b>  {{ $saleFinal->quotationInvoices ? $saleFinal->quotationInvoices->quotation_no:NULL}}</p>
            <p><b>customer : </b>  {{$saleFinal->quotationInvoices ? $saleFinal->quotationInvoices->customer_name:NULL}}</p>
        </div>
        <div class="main-contain-right">
            <p><b>date : </b> {{date('d-m-Y h:i:s a',strtotime($saleFinal->sale_date))}}</p>
        </div>
    </section>
    @php
        function first_letter($str)
        {
            return implode('', array_map(function($v) { return $v[0]; },array_filter(array_map('trim',explode(' ', $str)))));;
        }
    @endphp

    <section class="data-table">
        <table>
            <tr>
                <th>AS Code</th>
                <th style="width:50%;">product</th>
                <th>quantity</th>
                <th style="width:20%;">unit price</th>
                <th>subtotal</th>
            </tr>
                @foreach ($saleFinal->quotationSaleDetails ? $saleFinal->quotationSaleDetails:NULL  as $item)    
                <tr>
                    <td> {{$item->productVariations?$item->productVariations->products? $item->productVariations->products->custom_code:NULL:NULL}}</td>
                    <td>
                         {{--  {{ first_letter($item->productVariations?$item->productVariations->products?$item->productVariations->products->name:NULL:NULL) }}--}}
                        {{$item->productVariations?$item->productVariations->products?$item->productVariations->products->name:NULL:NULL}}
                        {{$item->productVariations?$item->productVariations->colors? "(". $item->productVariations->colors->name .")" :NULL:NULL}}
                        {{$item->productVariations?$item->productVariations->sizes? "(". $item->productVariations->sizes->name .")" :NULL:NULL}}
                        {{$item->productVariations?$item->productVariations->weights? "(". $item->productVariations->weights->name .")" :NULL:NULL}}  
                    </td>
                    <td>
                        {{$item->quantity}} {{ $item->units?$item->units->short_name:NULL }}
                    </td>
                    <td>
                        {{$item->unit_price}}
                    </td>
                    {{--  <td>
                        {{$item->discountAmounts()}}
                    </td>
                    <td>0.0</td>
                    <td>
                        {{$item->unit_price}}
                    </td>  --}}
                    <td>
                        {{$item->quotationSubTotalAmount()}}
                    </td>
                </tr>
                @endforeach
            <tr>
                <th colspan="3" style="opacity: 0; visibility: hidden;"></th>
                <th style="text-align:right;"><small>Subtotal</small> </th>
                <th >  {{$saleFinal->quotationSubTotalSaleAmount()}}</th>
            </tr>
            <tr>
                <th colspan="3" style="opacity: 0; visibility: hidden;"></th>
                <th style="text-align:right;"><small>Less Amount (-)</small> </th>
                <th > {{$saleFinal->quotationDiscountAmountOfSaleFinal()}}</th>
            </tr>
            <tr>
                <th colspan="3" style="opacity: 0; visibility: hidden;"></th>
                <th style="text-align:right;"><small>Shipping Charge  (+)</small> </th>
                <th > {{$saleFinal->quotationAdditionalShippingCharges()}}</th>
            </tr>
            <tr>
                <th colspan="3" style="opacity: 0; visibility: hidden;"></th>
                <th style="text-align:right;">Total </th>
                <th > {{$saleFinal->quotationTotalSaleAmount()}}</th>
            </tr>
        </table>
    </section>

</body>
</html>
