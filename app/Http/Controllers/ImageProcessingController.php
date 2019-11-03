<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
# imports the Google Cloud client library
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class ImageProcessingController extends Controller
{
    //
    public function extractImageLabel(Request $request)
    {
        $client = new Client();
        $arrJson = array ( 'requests' => array ( 0 => array ( 'image' => array ( 'content' => $request->imgBase64, ), 'features' => array ( 0 => array ( 'maxResults' => 5, 'type' => 'LABEL_DETECTION', ), ), ), ), );
        $options = [
            'json' => $arrJson
        ];
        $res = $client->post("https://vision.googleapis.com/v1/images:annotate?key=AIzaSyChzYezozzX3-kRB13u2QED4oDOP8_A1mc", $options);

        $resp = json_decode($res->getBody()->getContents(), 1);

        $labels = ($resp['responses'][0]['labelAnnotations']);

        $annotationArr = [];

        foreach ($labels as $label) {
            $annotationArr[] = ['object' => $label['description'], 'precision' => $label['score']];
        }

        return response()->json( $annotationArr, 201 );
    }
}
