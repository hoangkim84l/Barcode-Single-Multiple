<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


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
        if($type == 'QRCODE'){
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
            if($request->type == 'QRCODE'){
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
                    if(strlen($line) < 4){
                        echo "Value must be more than 4 digit";
                        return;
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
