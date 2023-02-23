<?php

namespace App\Traits;

use NumberFormatter;
use Illuminate\Support\Str;

trait NumberFormat
{
    protected static function boot ()
    {
        // Boot other traits on the Model
        parent::boot();


    }

    public static function LFormat($number, $decimals = 2, $dec_point = '.', $thousands_sep = ''){
       // dd(gettype($number));
        $Locale='en_US';
        //get current Locale
        // $Locale = \App::getLocale();
        // $Locale=$Locale=='in' ? 'hi_IN' : ($Locale=='bn' ? 'bn_BD' : 'en_US');

        $num = new  NumberFormatter($Locale, NumberFormatter::DECIMAL);
        //dd($num->format($number));
        return $num->format($number);
    }
}
