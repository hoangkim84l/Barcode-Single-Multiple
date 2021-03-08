
@extends('layouts.app')

@section('content')
    <h2>Generator Barcode Sheet</h2>
	<br/>
	<br>
	@foreach ($newArr as $row)
		<img src="<?php echo asset('storage/'.$row);?>" alt="barcode" />
		<br/><br/>
	@endforeach
                        
   {{-- <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('test', 'C128', 2,60,array(2,3,4), false)}}" alt="barcode" /><br/> --}}
	 
	 {{-- <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('12', 'C39+')}}" alt="barcode" /><br/>
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('13', 'C39E')}}" alt="barcode" /><br/>
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('14', 'C39E+')}}" alt="barcode" /><br/>
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('15', 'C93', 3,40,array(2,3,4), true)}}" alt="barcode" />
	<br/>
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('19', 'S25')}}" alt="barcode" />
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('20', 'S25+')}}" alt="barcode" />
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('21', 'I25')}}" alt="barcode" />
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('22', 'MSI+')}}" alt="barcode" />
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('23', 'POSTNET')}}" alt="barcode" />
	<br/>
	<img src="data:image/png;base64,{{DNS2D::getBarcodePNG('16', 'QRCODE')}}" alt="barcode" />
	<img src="data:image/png;base64,{{DNS2D::getBarcodePNG('17', 'PDF417')}}" alt="barcode" />
	<img src="data:image/png;base64,{{DNS2D::getBarcodePNG('18', 'DATAMATRIX')}}" alt="barcode" /> --}}
@endsection