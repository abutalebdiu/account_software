<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        #table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-right:2%;
        margin-left:1%;
        }

        #table td, #table th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size:10px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #table tr:hover {background-color: #ddd;}

        #table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
        }
    </style>
    <meta charset="utf-8">

    <title>Product List</title>
 
 

</head>

<body>
      
      <br>
      <address style="text-align:center;">
        <strong style="font-size:22px;">Amader Sanitary</strong>
        <br />
        Janata Bank More, (Hafez Building Under Graound) Mujib Sarak, Niltuli,Faridpur <br />
        Mobile: +8801711111192  , +8801613000450<br />
        {{--  Email: kamrulislam643@gmail.com  --}}
    </address>
        <hr/>
      <br>

       <table  width="100%" id="table">
                <thead>
                     <tr>
                        <th>Sl.N</th>
                        <th>AS Code</th>
                        <th>Company Code</th>
                        <th>Supplier</th>
                        <th>Brand Name</th>
                        <th>Product Name</th>
                        <th>Purchase Price</th>
                        <th>Whole Sale Price</th>
                        <th>Sale Price</th>
                        <th>MRP</th>
                    </tr>
                </thead>
                   
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $product->custom_code }}</td>
                            <td>{{ $product->company_code }}</td>
                            <td>{{$product->suppliers?$product->suppliers->name:NULL}}</td>
                            <td>{{$product->brand?$product->brand->name:NULL}}</td>
                            <td>{{$product->name}}</td>
                            <td style="text-align:right">{{$product->purchase_price}}</td>
                            <td style="text-align:right">{{$product->whole_sale_price}}</td>
                            <td style="text-align:right">{{$product->sale_price}}</td>
                         
                             <td style="text-align:right">{{$product->mrp_price}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
</body>

</html>