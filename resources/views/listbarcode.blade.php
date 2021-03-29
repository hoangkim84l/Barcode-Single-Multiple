@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                
                <h2>User: {{ Auth::user()->name}}</h2>
                <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search for date day-month-year" title="Type in a date">
                <table class="table" id="myBarcode">
                    <thead>
                    <tr class="header">
                        <th>Barcode</th>
                        <th>Date create</th>
                        <th>Download</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($listBarcode as $vd_barcode)
                        <tr>
                            <td><img width="" src="{{  asset('storage/'.$vd_barcode->barcode) }}" height=""></td>
                            <td class="barcodeDate">{{ date_format($vd_barcode->created_at,"d-m-Y") }}</td>
                            <td><a href="<?php echo asset('storage/'.$vd_barcode->barcode);?>" download target="_blank" rel="noopener noreferrer"> Download</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>



                
            </div>
        </div>
    </div>
<script>
    function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myBarcode");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
        }       
    }
    }
</script>
@endsection
