<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MapController extends Controller
{
    public function show($id='')
    {
        //dd($id);
        //dev url aHR0cDovLzExNS4xMjQuMTIwLjI1MTo1MjUwL2FwaS9tYXN0ZXIvdmlld3MvcG93ZXJzdGF0aW9ucy9wbXA=
        $url=$id==''?'http://115.124.120.251:5250/api/master/views/powerstations/pmp': base64_decode($id);

        // dd($url);
        $headers = [ "Accept" => "application/json",];
        $res = Http::withHeaders($headers)->get($url)->json();
        // dd($res);
        // $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'http://115.124.120.251:5250/api/master/views/powerstations/pmp')->json();
        //dd($res);
        $data = $res['data'];
        //dd($data);
        $cnt=0;
        foreach($data as $key => $value) {
            //dd($value['GeoLocation']);
            //if($key>50) break;

            // if($value['FuelType'] == null || $cnt>=600) {
            if($value['FuelType'] == null) {
                unset($data[$key]);
            }
            else{
                $cnt++;
                $data[$key]['lat'] = $value['GeoLocation'][0];
                $data[$key]['lng'] = $value['GeoLocation'][1];
                //$data[$key]['position']= new google.maps.LatLng($value['GeoLocation'][0],$value['GeoLocation'][1]);
                unset($data[$key]['RegionName']);
                unset($data[$key]['AreaAcronym']);
                unset($data[$key]['GeoLocation']);
                unset($data[$key]['__units__']);
            }

        }
        asort($data);
        $data['map_data'] = array_values($data);
        // dd($map_data);
        //        dd(json_encode($data,true));
        //$map_data=json_encode($map_data,true);
        $data['TITLE']='Power Stations';
        $data['map_data'] = json_encode($data['map_data']);
        //dd($data['map_data']);
        return view('map', $data);
    }
}
