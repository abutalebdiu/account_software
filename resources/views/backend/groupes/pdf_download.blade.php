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
            font-size:10px;
        }
    </style>
    <meta charset="utf-8">

    <title>Group  List</title>
 
 

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
                        <th>Sl.No</th>
                        <th>Group Id</th>
                        <th>Group Name</th>
                     </tr>
                </thead>
                   
                <tbody>
                     @foreach($groupes as $group)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$group->id}}</td>
                            <td>{{$group->name}}</td>
                         </tr>
                    @endforeach
                </tbody>
       </table>


</body>

</html>