<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    {{--      
    <style>
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        nav,
        section {

            display: block
        }

        audio[controls],

        canvas,
        video {
            display: inline-block
        }

        [hidden],

        audio {
            display: none
        }

        mark {
            background: #FF0;
            color: #000;
        }



        /* reset */


        span.checkbr br {
            display: none;
        }


        * {

            border: 0;

            box-sizing: content-box;

            color: inherit;

            font-family: inherit;

            font-size: inherit;

            font-style: inherit;

            font-weight: inherit;

            line-height: inherit;

            list-style: none;

            margin: 0;

            padding: 0;

            text-decoration: none;

            vertical-align: top;

        }



        /* content editable */



        *[contenteditable] {
            border-radius: 0.25em;
            min-width: 1em;
            outline: 0;
        }



        *[contenteditable] {
            cursor: pointer;
        }



        *[contenteditable]:hover,
        *[contenteditable]:focus,
        td:hover *[contenteditable],
        td:focus *[contenteditable],
        img.hover {
            background: #DEF;
            box-shadow: 0 0 1em 0.5em #DEF;
        }



        span[contenteditable] {
            display: inline-block;
        }



        /* heading */



        h1 {
            font: bold 100% sans-serif;
            text-align: center;
            text-transform: uppercase;
        }



        /* table */



        table {
            font-size: 75%;
            table-layout: fixed;
            width: 100%;
        }

        table {
            border-collapse: separate;
            border-spacing: 2px;
        }

        th,
        td {
            border-width: 1px;
            padding: 0.5em;
            position: relative;
            text-align: left;
        }

        th,
        td {
            border-radius: 0.25em;
            border-style: solid;
        }

        th {
            background: #f0f0f0;
            border-color: #ececec;
            padding: 8px;
        }

        td {
            border-color: #DDD;
        }



        /* page */



        html {
            font: 16px/1 'Open Sans', sans-serif;
            overflow: auto;
            padding: 0.5in;
        }

        html {
            background: #f7fdfe;
            cursor: default;
        }



        body {
            box-sizing: border-box;
            height: auto;
            margin: 0 auto;
            overflow: hidden;
            padding: 20px;
            width: 8.5in;
        
            background: #FFF;
            border-radius: 1px;
            margin-top: 0px;
            border: 1px solid #460c84;
        }



        /* header */



        header {
            margin: 0 0 3em;
        }

        header:after {
            clear: both;
            content: "";
            display: table;
        }



        header h1 {
            background: #1eadd5;
            border-radius: 0em;
            color: #FFF;
            margin: 0 0 1.5em;
            padding: 0.6em 0;
            font-size: 20px;
        }

        header address {
            float: left;
            font-size: 14px;
            font-style: normal;
            line-height: 17px;
            margin: 0 1em 1em 0;
            font-weight: 400;
            color: #000;
        }

        header address p {
            margin: 0 0 0.25em;
        }

        header span,
        header img {
            display: block;
            float: right;
        }

        header span {
            margin: 0 0 1em 1em;
            max-height: 25%;
            max-width: 60%;
            position: relative;
        }

        header img {
            max-height: 100%;
            max-width: 100%;
        }

        header input {
            cursor: pointer;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            height: 100%;
            left: 0;
            opacity: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        table{
            border-collapse: collapse;
        }
        table tr{

        }

        table tr td{

        }



        /* article */

    
 

 

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

            span:empty {
                display: none;
            }

            table{

            }

        }



        @page {
            margin: 0;
        }



        #payment {

            margin-top: -72px;

            margin-left: 250px;

        }
    </style>
  --}}
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

    <title>Unit  List</title>
 
 

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
                        <th>Unit Id</th>
                        <th>Unit Full Name</th>
                        <th>Unit Short Name</th>
                        <th>Parent Unit</th>
                        <th>Description</th>
                    </tr>
                </thead>
                   
                <tbody>
                    @foreach($units as $unit)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$unit->id}}</td>
                            <td>{{$unit->full_name}}</td>
                            <td>{{$unit->short_name}}</td>
                            <td>{{$unit->parentUnitName() }}</td>
                            <td>{{$unit->description}}</td>
                        </tr>
                    @endforeach
                </tbody>
    


</body>

</html>