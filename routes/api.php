<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
// use BarcodeValidator;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//test
Route::get('welcome/{username}', function(Request $request, $username){
    return response()->json("Hello $username!");
});
/**
 * Generator 1 barcode
 * Parameter
 * Type: UPCA, EAN8, EAN13, QR, ITF, CODE39, CODE128
 * Format: PNG, SVG
 * Show text: true, false
 * Size: small(1), medium(2), large(3)
 * Value: must be digit for UPC-A, EAN 8, EAN 13, QR and ITF
 * Value: Accept text and digit for CODE 39, CODE 128
 * */
Route::get('barcode/{type}&{format}&{showtext}&{size}&{value}', 
    function(Request $request, $type, $format, $showtext, $size, $value){
        $height = 0;
        $width = 0;

        $dns = '';
        $barcodeType = 'getBarcode'.$format;
        //validate
        if ($type == "UPCA" || $type == "EAN8" || $type == "EAN13" || $type == "POSTNET") {
            if (is_numeric($value) != 1) {
                echo "Value must be digit";
                return;
            }
            if ($type == "EAN8") {
                if ((strlen($value) < 4 && $type == "EAN8") || (strlen($value) > 8 && $type == "EAN8")) {
                    echo "EAN-8 codes must contain 8 numeric digits";
                    return;
                }
                if (BarcodeValidator::IsValidEAN8($value) == false) {
                    echo "Something wrong.\n Detail https://www.gs1.org/standards/barcodes/ean-upc";
                    return;
                }
            }
            if ($type == "UPCA") {
                if ((strlen($value) < 11 && $type == "UPCA") || (strlen($value) > 12 && $type == "UPCA")) {
                    echo "UPC-A code values must contain 12 digits (without checksum digit)";
                    return;
                }
                if (BarcodeValidator::IsValidUPCA($value) == false) {
                    echo "Something wrong.\n Detail https://www.gs1.org/standards/barcodes/ean-upc";
                    return;
                }
            }
            if ($type == "EAN13") {
                if ((strlen($value) < 12 && $type == "EAN13") || (strlen($value) > 13 && $type == "EAN13")) {
                    echo "EAN-13 code values must contain 13 digits (without checksum digit)";
                    return;
                }
                if (BarcodeValidator::IsValidEAN13($value) == false) {
                    echo "Something wrong.\n Detail https://www.gs1.org/standards/barcodes/ean-upc";
                    return;
                }
            }
        }
        if($type == 'QRCODE' || $type == 'DATAMATRIX'){
            $dns= 'DNS2D';
            $height = $size * 5;
            $width = $size * 5;
        }else{
            $dns = 'DNS1D';
            $height = $size * 2;
            $width = $size * 30;
        }
        $nameOfBarcode = $dns::$barcodeType($value, $type, $height,$width,array(2,3,4), $showtext);
        $image = "data:image/png;base64,$nameOfBarcode";
        
        // $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10) . '.png';

        Storage::disk('public')->put($imageName, base64_decode($image)); 
        $finalImage = asset('storage/'.$imageName);
    return response()->json($finalImage);
});


/**
 * Generator barcode sheet
 * Parameter
 * Type: UPCA, EAN8, EAN13, QR, ITF, CODE39, CODE128
 * Format: This case default is PNG
 * Show text: true, false
 * Size: small(1), medium(2), large(3)
 * Value: must be digit for UPC-A, EAN 8, EAN 13, QR and ITF
 * Value: Accept text and digit for CODE 39, CODE 128
 * */
Route::post('barcode_sheet', 
    function(Request $request){
        $type = $request->type;
        $text = trim($request->barcodeValue); 
        $textAr = explode("\n", $text);  // remove the last \n or whitespace character
        $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
        
        $newArr = array();
        foreach ($textAr as $line) {
            // processing here. 
            // echo $line;
            $height = 0;
            $width = 0;

            $dns = '';
            $barcodeType = 'getBarcodePNG';
            if($request->type == 'QRCODE' || $request->type == 'DATAMATRIX'){
                settype($line, "string");
                $dns= 'DNS2D';
                $height = $request->size * 5;
                $width = $request->size * 5;
            }else{
                settype($line, "integer");
                $dns = 'DNS1D';
                $height = $request->size * 2;
                $width = $request->size * 30;
                //validate
                if($type == "C128" || $type == "UPCA" || $type == "EAN8" || $type == "EAN13" || $type == "POSTNET"){
                    if(is_numeric($line) != 1){
                        echo "Value must be digit";
                        return;
                    }
                    if($type == "UPCA"){
                        if((strlen($line) < 11 && $type == "UPCA") || (strlen($line) > 12 && $type == "UPCA")){
                            echo "UPC-A code values must contain 12 digits (without checksum digit)";
                            return;
                        }
                        if(BarcodeValidator::IsValidUPCA($line) == false){
                            echo "Something wrong.\n Detail https://www.gs1.org/standards/barcodes/ean-upc";
                            return;
                        }
                    }
                    if($type=="EAN8"){
                        if((strlen($line) < 4 && $type == "EAN8") || (strlen($line) > 8 && $type == "EAN8")){
                            echo "EAN-8 codes must contain 8 numeric digits";
                            return;
                        }
                        if(BarcodeValidator::IsValidEAN8($line) == false){
                            echo "Something wrong.\n Detail https://www.gs1.org/standards/barcodes/ean-upc\n";
                            return;
                        }
                    }
                    if($type == "EAN13"){
                        if((strlen($line) < 12 && $type == "EAN13") || strlen($line) > 13 && $type == "EAN13"){
                            echo "EAN-13 code values must contain 13 digits (without checksum digit)";
                            return;
                        }
                        if(BarcodeValidator::IsValidEAN13($line) == false){
                            echo "Something wrong.\n Detail https://www.gs1.org/standards/barcodes/ean-upc";
                            return;
                        }
                    }
                }
            }
            if($request->text == 'true'){
                $nameOfBarcode = $dns::$barcodeType($line, $request->type, $height,$width,array(2,3,4), true);
            }else{
                $nameOfBarcode = $dns::$barcodeType($line, $request->type, $height,$width,array(2,3,4), false);
            }
            $image = "data:image/png;base64,$nameOfBarcode";
            
            // $image = $request->image;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10) . '.png';

            Storage::disk('public')->put($imageName, base64_decode($image));
            array_push($newArr, asset('storage/'.$imageName));
        }
    return response()->json($newArr);
});
//
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
