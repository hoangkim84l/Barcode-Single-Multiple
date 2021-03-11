<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PDF;
use URL;

class HomeController extends Controller
{
    //show barcode form
    public function formview(){
        return view('welcome');
    }
    //show barcoee test
    public function barcode(){
        return view('barcode');
    }
    //public barcode sheet
    public function barcodeSheet(Request $request){
        //validate barcode type
        $type = $request->type;

        $text = trim($request->barcodeValue); 
        $textAr = explode("\n", $text);  // remove the last \n or whitespace character
        $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
        $showtext =  $request->stext;
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
                if($type == "UPCA" || $type == "EAN8" || $type == "EAN13" || $type == "POSTNET"){
                    if(is_numeric($line) != 1){
                        echo "<h3 style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'>Value must be digit<br/><br/>
                        <a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a>
                        </h3>";
                        return;
                    }
                    if((strlen($line) < 11 && $type == "UPCA") || (strlen($line) > 11 && $type == "UPCA")){
                        echo "<h3 style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'>UPC-A code values must contain 11 digits (without checksum digit)<br/><br/>
                        <a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a>
                        </h3>";
                        return;
                    }
                    if((strlen($line) < 4 && $type == "EAN8") || (strlen($line) > 8 && $type == "EAN8")){
                        echo "<h3 style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'>EAN-8 codes must contain 7 numeric digits<br/><br/>
                        <a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a>
                        </h3>";
                        return;
                    }
                    if((strlen($line) < 12 && $type == "EAN13") || strlen($line) > 12 && $type == "EAN13"){
                        echo "<h3 style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'>EAN-13 code values must contain 12 digits (without checksum digit)<br/><br/>
                        <a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a>
                        </h3>";
                        return;
                    }
                }
            }
            if($showtext == 'true'){
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
            array_push($newArr, $imageName);

        }
        
        $pdf = PDF::loadView('barocesheet', ['newArr' => $newArr]);
        $pdf->setPaper($request->pagesize, 'portrait');
        return $pdf->stream('barcodesheet.pdf');
        // return view('barocesheet', ['newArr' => $newArr]);
    }
}