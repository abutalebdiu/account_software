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
        padding: 8px;
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

    <title>Customer List</title>
 
 

</head>

<body>
      
      
      <br>
            <address style="text-align:center;">
                <strong style="font-size:22px;">Amader Sanitary</strong>
                <br />
                Janata Bank More, (Hafez Building Under Graound) Mujib Sarak, Niltuli,Faridpur <br />
                Mobile: +8801711111192  , +8801613000450<br />
            </address>
        <hr/>
                             <table width="100%"  border="1" style="border-collapse: collapse;"> 
                               
                               <tr>
                                  <th>Customer Name</th>
                                  <td>{{ $customer->name }}</td>
                             
                                  <th>Phone</th>
                                  <td>
                                      {{ $customer->phone }} <br>
                                      {{ $customer->phone_2 }}
                                  </td>
                              </tr> 
                              <tr>
                                  <th>Customer Email</th>
                                  <td>{{ $customer->email }}</td>
                             
                                  <th>Address</th>
                                  <td>{{ $customer->address }}</td>
                              </tr>
                          </table>

                          <br>
                          <br>

                        <table width="100%"  border="1" style="border-collapse: collapse;font-size: 12px"> 
                              <thead>
                                   <tr>
                                        <th width="2%">SN</th>
                                        <th width="5%">Invoice</th>
                                        <th width="9%">Date</th>
                                        <th width="15%">Media Name</th>
                                        <th width="8%">Loan</th>
                                        <th width="8%">Bill</th>
                                        <th width="8%">Received</th>
                                        <th width="8%">Due</th>
                                        <th width="8%">Total Due</th>
                                        <th width="8%">Advance</th>
                                        <th width="5"> Payment <br/> Method</th>
                                        <th width="5"><small>Credit/<br/>Debit</small></th>
                                    </tr>
                              </thead>
                              <tbody>
                                  @foreach($paymenthistories as $data)

                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{ $data->payment_invoice_no }}</td>
                                        <td>{{ date('d-m-Y H:i:s',strtotime($data->payment_date)) }}</td>
                                        <td>{{ $data->takenby }}</td>
                                        <td>
                                            @if($data->module_id==5)
                                            {{ $data->payment_amount }}
                                            @endif
                                        </td>
                                        <td></td>
                                        <td>
                                            @if($data->module_id==2)
                                            {{ $data->payment_amount }}
                                            @endif
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <small style="font-size:11px;">
                                            {{$data->paymentMethods?$data->paymentMethods->method:NULL}}<br/>
                                            {{$data->accounts?$data->accounts->bank?"(".$data->accounts->bank->short_name.")":NULL:NULL}}
                                            </small>
                                        </td>
                                         <td>
                                           <small> {{getCDFName_HH($data->cdf_type_id)}} </small>
                                        </td>
                                    </tr>

                                    @endforeach>
                              </tbody>
                          </table>


                           
                              

                            
    


</body>

</html>