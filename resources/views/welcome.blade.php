@extends('layouts.app')
@section('content')
@guest
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Barcode Image</a></li>
                    <li><a data-toggle="tab" href="#menu1">Barcode Sheet</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <br>
                        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                            <form action="" method="get">
                                <div class="form-group">
                                    <label for="type">Symbology</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="UPCA" <?php if(isset($_GET['type']) && ($_GET['type'] == 'UPCA')){echo "selected";} ?>>UPC-A</option>
                                        <option value="EAN8" <?php if(isset($_GET['type']) && $_GET['type'] == 'EAN8'){echo "selected";} ?>>EAN 8</option>
                                        <option value="EAN13" <?php if(isset($_GET['type']) && $_GET['type'] == 'EAN13'){echo "selected";} ?>>EAN 13</option>
                                        <option value="QRCODE" <?php if(isset($_GET['type']) && $_GET['type'] == 'QRCODE'){echo "selected";} ?>>QR</option>
                                        <option value="POSTNET" <?php if(isset($_GET['type']) && $_GET['type'] == 'POSTNET'){echo "selected";} ?>>ITF</option>
                                        <option value="C39" <?php if(isset($_GET['type']) && $_GET['type'] == 'C39'){echo "selected";} ?>>CODE 39</option>
                                        <option value="C128" <?php if(isset($_GET['type']) && $_GET['type'] == 'C128'){echo "selected";} ?>>CODE 128</option>
                                        <option value="DATAMATRIX" <?php if(isset($_GET['type']) && $_GET['type'] == 'DATAMATRIX'){echo "selected";} ?>>DATA MATRIX</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="IncludeText">Include Text</label>
                                    <select name="text" id="" class="form-control">
                                        <option value="true" <?php if(isset($_GET['text']) && $_GET['text'] == 'true'){echo "selected";} ?>>Yes</option>
                                        <option value="false" <?php if(isset($_GET['text']) && $_GET['text'] == 'false'){echo "selected";} ?>>No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ImageSize">Image Size</label>
                                    <select name="size" id="" class="form-control">
                                        <option value="1" <?php if(isset($_GET['size']) && $_GET['size'] == '1'){echo "selected";} ?>>Small</option>
                                        <option value="2" <?php if(isset($_GET['size']) && $_GET['size'] == '2'){echo "selected";} ?>>Medium</option>
                                        <option value="3" <?php if(isset($_GET['size']) && $_GET['size'] == '3'){echo "selected";} ?>>Large</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ImageFormat">Image Format</label>
                                    <select name="format" id="" class="form-control">
                                        <option value="PNG" <?php if(isset($_GET['format']) && $_GET['format'] == 'PNG'){echo "selected";} ?>>PNG</option>
                                        {{-- <option value="SVG" <?php if(isset($_GET['format']) && $_GET['format'] == 'SVG'){echo "selected";} ?>>SVG</option> --}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="BarcodeValue">Barcode Value</label>
                                    <input type="text" class="form-control" name="barcodeValue" placeholder="Barcode value" autocomplete="off" value="<?php if(isset($_GET['barcodeValue'])) {echo $_GET['barcodeValue'];}?>">
                                </div>
            
                                <input type="submit" name="btnSubmitBarcodeImage" class="btn btn-default" value="Generator">
                            </form>
                        </div>  
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <br/>
                        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                            <form action="{{url('barocesheet')}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="form-group">
                                    <label for="type">Symbology</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="UPCA">UPC-A</option>
                                        <option value="EAN8">EAN 8</option>
                                        <option value="EAN13">EAN 13</option>
                                        <option value="QRCODE">QR</option>
                                        <option value="POSTNET">ITF</option>
                                        <option value="C39">CODE 39</option>
                                        <option value="C128">CODE 128</option>
                                        <option value="DATAMATRIX">DATA MATRIX</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="IncludeText">Include Text</label>
                                    <select name="stext" id="" class="form-control">
                                        <option value="true">Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ImageSize">Image Size</label>
                                    <select name="size" id="" class="form-control">
                                        <option value="1">Small</option>
                                        <option value="2">Medium</option>
                                        <option value="3">Large</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="PageSize">Page Size</label>
                                    <select name="pagesize" id="" class="form-control">
                                        <option value="a4">A4</option>
                                        <option value="a5">A5</option>
                                        <option value="a6">A6</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="BarcodeValue">Barcode Value</label>
                                    <textarea id="" cols="30" rows="10" name="barcodeValue" class="form-control"></textarea>
                                </div>
            
                                <input type="submit" name="btnSubmitBarcodeSheet" class="btn btn-default" value="Generator Barcode Sheet">
                            </form>
                        </div> 
                    </div>
                </div>   
            </div>
            <div class="col-lg-6">
                <h2>Generator Barcode</h2>
                <?php
                /**
                    * Generator barcode image
                    * Parameter
                    * Type: UPCA, EAN8, EAN13, QR, ITF, CODE39, CODE128
                    * Format: PNG, SVG
                    * Show text: true, false
                    * Size: small(1), medium(2), large(3)
                    * Value: must be digit for UPC-A, EAN 8, EAN 13, and ITF
                    * Value: Accept text and digit for CODE 39, CODE 128, QR
                    * */
                    if(!empty($_GET['btnSubmitBarcodeImage']) && $_GET['btnSubmitBarcodeImage'] == "Generator"){
                        $type = $_GET['type'];
                        $text = $_GET['text'];
                        $size = $_GET['size'];
                        $format = $_GET['format'];
                        $barcodeValue = $_GET['barcodeValue'];
                        $height = 0;
                        $width = 0;
                        //validate
                        if($type == "UPCA" || $type == "EAN8" || $type == "EAN13" || $type == "POSTNET"){
                            if(is_numeric($barcodeValue) != 1){
                                echo "<p style='color: red;'>Value must be digit</p>";
                                return;
                            }
                            if($type == "EAN8"){
                                if((strlen($barcodeValue) < 4 && $type == "EAN8") || (strlen($barcodeValue) > 8 && $type == "EAN8")){
                                    echo "<p style='color: red;'>EAN-8 codes must contain 8 numeric digits</p>";
                                    return;
                                }
                                if(BarcodeValidator::IsValidEAN8($barcodeValue) == false){
                                    echo "<h3>Something wrong</h3>.<br/> Detail <a href='https://www.gs1.org/standards/barcodes/ean-upc'>here</a>";
                                    return;
                                }
                            }
                            if($type == "UPCA"){
                                if((strlen($barcodeValue) < 11 && $type == "UPCA") || (strlen($barcodeValue) > 12 && $type == "UPCA")){
                                    echo "<p style='color: red;'>UPC-A code values must contain 12 digits (without checksum digit)</p>";
                                    return;
                                }
                                if(BarcodeValidator::IsValidUPCA($barcodeValue) == false){
                                    echo "<h3>Something wrong</h3>.<br/> Detail <a href='https://www.gs1.org/standards/barcodes/ean-upc'>here</a>";
                                    return;
                                }
                            }
                            if($type == "EAN13"){
                                if((strlen($barcodeValue) < 12 && $type == "EAN13") || (strlen($barcodeValue) > 13 && $type == "EAN13")){
                                    echo "<p style='color: red;'>EAN-13 code values must contain 13 digits (without checksum digit)</p>";
                                    return;
                                }
                                if(BarcodeValidator::IsValidEAN13($barcodeValue) == false){
                                    echo "<h3>Something wrong</h3>.<br/> Detail <a href='https://www.gs1.org/standards/barcodes/ean-upc'>here</a>";
                                    return;
                                }
                            }
                            $dns = '';
                            $barcodeType = 'getBarcode'.$format;
                            if($type == 'QRCODE' || $type == 'DATAMATRIX'){
                                $dns= 'DNS2D';
                                $height = $size * 5;
                                $width = $size * 5;
                            }else{
                                $dns = 'DNS1D';
                                $height = $size * 2;
                                $width = $size * 30;
                            }
                            if($text == 'true'){
                                $nameOfBarcode = $dns::$barcodeType($barcodeValue, $type, $height,$width,array(2,3,4), true);
                            }
                            else{
                                $nameOfBarcode = $dns::$barcodeType($barcodeValue, $type, $height,$width,array(2,3,4), false);
                            }
                            
                            $image = "data:image/png;base64,$nameOfBarcode";
                            
                            // $image = $request->image;  // your base64 encoded
                            $image = str_replace('data:image/png;base64,', '', $image);
                            $image = str_replace(' ', '+', $image);
                            $imageName = str_random(10) . '.png';

                            Storage::disk('public')->put($imageName, base64_decode($image));
                        }
                        else{
                            $dns = '';
                            $barcodeType = 'getBarcode'.$format;
                            if($type == 'QRCODE' || $type == 'DATAMATRIX'){
                                $dns= 'DNS2D';
                                $height = $size * 5;
                                $width = $size * 5;
                            }else{
                                $dns = 'DNS1D';
                                $height = $size * 2;
                                $width = $size * 30;
                            }
                            if($text == 'true'){
                                $nameOfBarcode = $dns::$barcodeType($barcodeValue, $type, $height,$width,array(2,3,4), true);
                            }
                            else{
                                $nameOfBarcode = $dns::$barcodeType($barcodeValue, $type, $height,$width,array(2,3,4), false);
                            }
                            $image = "data:image/png;base64,$nameOfBarcode";
                            
                            // $image = $request->image;  // your base64 encoded
                            $image = str_replace('data:image/png;base64,', '', $image);
                            $image = str_replace(' ', '+', $image);
                            $imageName = str_random(10) . '.png';

                            Storage::disk('public')->put($imageName, base64_decode($image));
                        }
                    ?>
                    <img src="<?php echo asset('storage/'.$imageName);?>" alt="barcode" />
                    <br/><br/>
                    <a href="<?php echo asset('storage/'.$imageName);?>" download target="_blank" rel="noopener noreferrer"> Download</a>

                <?php 
                    }
                ?>
            </div>
            
        </div>
    </div>
@else 
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Barcode Image</a></li>
                    <li><a data-toggle="tab" href="#menu1">Barcode Sheet</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <br>
                        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                            <form action="{{ route('barcode') }}" method="post">
                                <input type="hidden" name="csrf-token" value="{{csrf_token()}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="POST">

                                <div class="form-group">
                                    <label for="type">Symbology</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="UPCA">UPC-A</option>
                                        <option value="EAN8">EAN 8</option>
                                        <option value="EAN13">EAN 13</option>
                                        <option value="QRCODE">QR</option>
                                        <option value="POSTNET">ITF</option>
                                        <option value="C39">CODE 39</option>
                                        <option value="C128">CODE 128</option>
                                        <option value="DATAMATRIX">DATA MATRIX</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="IncludeText">Include Text</label>
                                    <select name="text" id="" class="form-control">
                                        <option value="true">Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ImageSize">Image Size</label>
                                    <select name="size" id="" class="form-control">
                                        <option value="1">Small</option>
                                        <option value="2">Medium</option>
                                        <option value="3">Large</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ImageFormat">Image Format</label>
                                    <select name="format" id="" class="form-control">
                                        <option value="PNG">PNG</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="BarcodeValue">Barcode Value</label>
                                    <input type="text" class="form-control" name="barcodeValue" placeholder="Barcode value" autocomplete="off" value="">
                                </div>
            
                                <input type="submit" name="btnSubmitBarcodeImage" class="btn btn-default" value="Generator">
                            </form>
                        </div>  
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <br/>
                        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                            <form action="{{url('barocesheet')}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="form-group">
                                    <label for="type">Symbology</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="UPCA">UPC-A</option>
                                        <option value="EAN8">EAN 8</option>
                                        <option value="EAN13">EAN 13</option>
                                        <option value="QRCODE">QR</option>
                                        <option value="POSTNET">ITF</option>
                                        <option value="C39">CODE 39</option>
                                        <option value="C128">CODE 128</option>
                                        <option value="DATAMATRIX">DATA MATRIX</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="IncludeText">Include Text</label>
                                    <select name="stext" id="" class="form-control">
                                        <option value="true">Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ImageSize">Image Size</label>
                                    <select name="size" id="" class="form-control">
                                        <option value="1">Small</option>
                                        <option value="2">Medium</option>
                                        <option value="3">Large</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="PageSize">Page Size</label>
                                    <select name="pagesize" id="" class="form-control">
                                        <option value="a4">A4</option>
                                        <option value="a5">A5</option>
                                        <option value="a6">A6</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="BarcodeValue">Barcode Value</label>
                                    <textarea id="" cols="30" rows="10" name="barcodeValue" class="form-control"></textarea>
                                </div>
            
                                <input type="submit" name="btnSubmitBarcodeSheet" class="btn btn-default" value="Generator Barcode Sheet">
                            </form>
                        </div> 
                    </div>
                </div>   
            </div>
            <div class="col-lg-6">
                <h2>Generator Barcode</h2>
                <?php
                if(!empty($finalImage))
                {
                ?>
                    <img src="<?php echo $finalImage;?>" alt="barcode" />
                    <br/><br/>
                    <a href="<?php echo $finalImage;?>" download target="_blank" rel="noopener noreferrer"> Download</a>

                <?php 
                    }
                ?>
            </div>
            
        </div>
    </div>
@endguest
@endsection