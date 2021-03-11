<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>    
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
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
                                    if((strlen($barcodeValue) < 11 && $type == "UPCA") || (strlen($barcodeValue) > 11 && $type == "UPCA")){
                                        echo "<p style='color: red;'>UPC-A code values must contain 11 digits (without checksum digit)</p>";
                                        return;
                                    }
                                    if((strlen($barcodeValue) < 4 && $type == "EAN8") || (strlen($barcodeValue) > 8 && $type == "EAN8")){
                                        echo "<p style='color: red;'>EAN-8 codes must contain 7 numeric digits</p>";
                                        return;
                                    }
                                    if((strlen($barcodeValue) < 12 && $type == "EAN13") || (strlen($barcodeValue) > 12 && $type == "EAN13")){
                                        echo "<p style='color: red;'>EAN-13 code values must contain 12 digits (without checksum digit)</p>";
                                        return;
                                    }
                                    if(is_numeric($barcodeValue) != 1){
                                        echo "<p style='color: red;'>Value must be digit</p>";
                                        return;
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
            
        </div>
    </body>
</html>
