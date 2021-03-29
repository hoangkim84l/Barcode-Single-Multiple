<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PDF;
use URL;
use BarcodeValidator;
use App\Models\Barcode;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }
    //show barcode form
    public function formview(){
        return view('welcome');
    }
    //show barcoee test
    public function barcode(){
        return view('barcode');
    }

    //gennerator and store barocde
    public function postBarcode(Request $req){
        if(Auth::check()){
            // var_dump(Auth::user()->id);exit();
            $user_id = Auth::user()->id;
            $type = $req->type;
            $text = $req->text;
            $size = $req->size;
            $format = $req->format;
            $barcodeValue = $req->barcodeValue;
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
                $barcode_store = new Barcode();
                $barcode_store->id_user = $user_id;
                $barcode_store->barcode = $imageName;
                $barcode_store->save();
                $finalImage = asset('storage/'.$imageName);
                return view('welcome',['finalImage' => $finalImage]);
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
                $barcode_store = new Barcode();
                $barcode_store->id_user = $user_id;
                $barcode_store->barcode = $imageName;
                $barcode_store->save();
                $finalImage = asset('storage/'.$imageName);
                return view('welcome',['finalImage' => $finalImage]);
            }
        }else{
            $this->middleware('auth');
        }
    }

    //get list barcode based on user
    public function getListBarcode(){
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $listBarcode = Barcode::where('id_user',$user_id)->paginate(100);
            return view('listbarcode',['listBarcode' => $listBarcode]);
        }else{
            return view('welcome');
        }
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
                    if($type == "UPCA"){
                        if((strlen($line) < 11 && $type == "UPCA") || (strlen($line) > 12 && $type == "UPCA")){
                            echo "<h3 style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'>UPC-A code values must contain 12 digits (without checksum digit)<br/><br/>
                            <a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a>
                            </h3>";
                            return;
                        }
                        if(BarcodeValidator::IsValidUPCA($line) == false){
                            echo "<div style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'><h3>Something wrong</h3>.<br/>Detail <a href='https://www.gs1.org/standards/barcodes/ean-upc'>here</a><br/><a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a></div>";
                            return;
                        }
                    }
                    if($type=="EAN8"){
                        if((strlen($line) < 4 && $type == "EAN8") || (strlen($line) > 8 && $type == "EAN8")){
                            echo "<h3 style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'>EAN-8 codes must contain 8 numeric digits<br/><br/>
                            <a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a>
                            </h3>";
                            return;
                        }
                        if(BarcodeValidator::IsValidEAN8($line) == false){
                            echo "<div style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'><h3>Something wrong</h3>.<br/> Detail <a href='https://www.gs1.org/standards/barcodes/ean-upc'>here</a><br/><a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a></div>";
                            return;
                        }
                    }
                    if($type == "EAN13"){
                        if((strlen($line) < 12 && $type == "EAN13") || strlen($line) > 13 && $type == "EAN13"){
                            echo "<h3 style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'>EAN-13 code values must contain 13 digits (without checksum digit)<br/><br/>
                            <a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a>
                            </h3>";
                            return;
                        }
                        if(BarcodeValidator::IsValidEAN13($line) == false){
                            echo "<div style='padding: 50px;color: red; width:300px; height: 300px; margin: 0 auto;'><h3>Something wrong</h3>.<br/> Detail <a href='https://www.gs1.org/standards/barcodes/ean-upc'>here</a><br/><a href='".URL::previous()."' style='width:300px; height: 300px; margin: 0 auto;'>Back</a></div>";
                            return;
                        }
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
            if (Auth::check()) {
                $user_id = Auth::user()->id;
                $barcode_store = new Barcode();
                $barcode_store->id_user = $user_id;
                $barcode_store->barcode = $imageName;
                $barcode_store->save();
            }

        }
        
        $pdf = PDF::loadView('barocesheet', ['newArr' => $newArr]);
        $pdf->setPaper($request->pagesize, 'portrait');
        return $pdf->stream('barcodesheet.pdf');
        // return view('barocesheet', ['newArr' => $newArr]);
    }
}