<div class="card-content">
    <div class="row">



        <div class="col-md-3 col-10  pt-4">
            <div class="label-text pb-2" for="Map_filter">{{ __('View Options') }}</div>
            <select name="map_filter" id="map_filter" class="form-control">

                <option value="1">{{ __('My Pumps') }}</option>
                @if ($office['officeTypeId'] == 1)
                    <option value="-1">{{ __('Pumps Under My Chain') }}</option>
                @endif
                <option value="-2">{{ __('All Def Pumps') }}</option>


            </select>
        </div>

        <div class="col-2 d-none align-items-center mt-4 icon-wrap sr-only ">
            <a href="javascript:" class="search btn-zoom badge align-self-end" title="{{ __('Search') }}">
                <span class="iconify" data-icon="fe:search" style="color: #05a;" data-width="30"
                    data-height="30"></span>
            </a>


        </div>
        <div class="col-md-3 pt-4">
            {{-- ProductType --}}
            {{-- @dd($product_types) --}}
            <div class="label-text pb-2 " for="product_type">{{ __('Product Type') }}</div>
            <select name="product_type" id="product_type" class="form-control">

                @foreach ($product_types as $product_type)
                    <option value="{{ $product_type['productTypeId'] }}"
                        data-recorderpoint="{{ $product_type['recorderPoint'] }}"
                        data-maxstocklevel="{{ $product_type['maxStockLevel'] }}">{{ $product_type['productTypeName'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 pt-4">
            {{-- slider --}}
            <div class="label-text pb-2 " for="product_type">{{ __('Current Stock') }}</div>
            <div class="row">
                <div class="col-12 px-4">
                    <div class="box-minmax">
                        {{-- <span>0</span><span>200</span> --}}
                    </div>
                    <div class="range-slider position-relative">
                        <span class="ml-2 pt-2 position-absolute">0</span>
                        <i id="rs-bullet-back" class="rs-label-back noselect ">Recorder Point:
                            {{ $product_types[0]['recorderPoint'] }}</i>

                        <input id="rs-range-line-back" class="rs-range-back noselect  position-absolute" type="range"
                            value="{{ $product_types[0]['recorderPoint'] }}" min="0"
                            max="{{ $product_types[0]['maxStockLevel'] }}" disabled>

                        <input id="rs-range-line" class="rs-range" type="range" value="0" min="0"
                            data-min="{{ $product_types[0]['recorderPoint'] }}"
                            max="{{ $product_types[0]['maxStockLevel'] }}">

                        <span class="ml-2 pt-2 position-absolute slider-max">{{ $product_types[0]['maxStockLevel'] }}</span>
                        <span id="rs-bullet" class="rs-label">0</span>

                    </div>


                </div>

            </div>
        </div>



    </div>
    <script>
        //         document ready
        $(document).ready(function() {
            $('#product_type').on('change', function() {
                // console.log(e);
                // var product_type = sender;
                var maxStockLevel = $(this).find(':selected').data('maxstocklevel');
                $('#rs-range-line').attr('max', maxStockLevel);
                $('.slider-max').text(maxStockLevel);
                var recorderPoint = $(this).find(':selected').data('recorderpoint');
                $('#rs-bullet-back').html("Recorder Point : " + recorderPoint);
                $('#rs-range-line-back').attr('max', maxStockLevel);
                $('#rs-range-line-back').val(recorderPoint);
                // console.log($('#rs-bullet-back').clientWidth);
                var backSliderWidth = document.getElementById('rs-range-line-back');

                var x = backSliderWidth.clientWidth / maxStockLevel * recorderPoint;
                //console.log(x);
                $('#rs-bullet-back').css('left', x - 15 + "px")
            });
            $('#product_type').trigger('change');
        });
    </script>

    <script>
        var rangeSlider = document.getElementById("rs-range-line");
        var rangeBullet = document.getElementById("rs-bullet");

        // rangeSlider.addEventListener("input", showSliderValue, false);
        //  rangeSlider.addEventListener("input", changeValue, false);
        rangeSlider.addEventListener("change", changeValue, false);
        var lastValue = 0;

        function changeValue() {
            var value = rangeSlider.value;
            lastValue = value;
            // console.log(lastValue);
            setTimeout(() => {
                showSliderValue();
            }, 200);
        }

        function showSliderValue() {
            rangeBullet.innerHTML = rangeSlider.value;
            var bulletPosition = (rangeSlider.value / rangeSlider.max);
            var pixelPostion = rangeSlider.clientWidth * bulletPosition;

            rangeBullet.style.left = pixelPostion + "px";
            ShowFilteredPumps();

        }
        // async delay(ms) {
        //     return new Promise(resolve => setTimeout(resolve, ms));
        // }
    </script>
    <style>
        .box-minmax {
            /* margin-top: 30px; */
            width: 70%;
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            color: #352525;


        }

        .box-minmax span:first-child {
            margin-left: 10px;
        }

        .range-slider {
            /* margin-top: 30vh; */
            display: inline;

        }

        .rs-range, .rs-range-back {
            box-sizing: border-box;
            margin-top: 0;
            width: 100%;
            -webkit-appearance: none;

        }

        /* .rs-range-back {
            margin-top: 0;
            width:80%;
            -webkit-appearance: none;
        } */

        .rs-range:focus,
        .rs-range-back {
            outline: none;
        }

        .rs-range::-webkit-slider-runnable-track {
            width: 100%;
            height: 1px;
            cursor: pointer;
            box-shadow: none;
            background: #e60c0c;
            background: toLinearGradient(90deg, #e60c0c, #e60c0c00);
            border-radius: 0px;
            border: 0px solid #010101;
        }

        .rs-range-back::-webkit-slider-runnable-track {
            width: 100%;
            height: 1px;
            cursor: pointer;
            box-shadow: none;
            background: #916d6d9c;
            border-radius: 0px;
            border: 0px solid #010101;
        }

        .rs-range::-moz-range-track {
            width: 100%;
            height: 1px;
            cursor: pointer;
            box-shadow: none;
            background: #3d7ab3;
            border-radius: 0px;
            border: 0px solid #010101;
        }

        .rs-range-back::-moz-range-track {
            width: 100%;
            height: 1px;
            cursor: pointer;
            box-shadow: none;
            background: #3d7ab3;
            border-radius: 0px;
            border: 0px solid #010101;
        }

        .rs-range::-webkit-slider-thumb {
            box-shadow: none;
            transform-origin: center center;
            border: 0px solid #b63f3f;
            box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.25);
            height: 42px;
            width: 22px;
            border-radius: 22px;
            background: rgb(39, 150, 158);
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -20px;
            z-index: 100;
            transition: all 0.4s ease-out;
        }

        .rs-range::-webkit-slider-thumb:hover {
            background: rgb(58, 180, 170);
            transform-origin: center center;
            width: 42px;
            height: 22px;
            margin-top: -10px;
            margin-left: -8px;
            border-radius: 22px;
        }

        .rs-range-back::-webkit-slider-thumb {
            box-shadow: none;
            border: 0px solid #b63f3f;
            /* box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.25); */
            height: 42px;
            width: 2px;
            /* border-radius: 22px; */
            background: rgb(75, 8, 184);
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -5px;

        }

        .rs-label-back {

            position: absolute;
            transform-origin: center center;
            display: inline;
            width: 0;
            height: 0;
            white-space: nowrap;
            overflow-x: visible;
            background: #4fb9ffaf;
            line-height: 1;
            text-align: center;
            font-weight: bold;

            margin-top: -5px;
            margin-left: 40px;
            color: rgb(41, 38, 38);
            font-style: normal;
            font-weight: normal;
            line-height: normal;
            font-size: 0.7rem;

        }

        .noselect {
            -webkit-touch-callout: none;
            /* iOS Safari */
            -webkit-user-select: none;
            /* Safari */
            -khtml-user-select: none;
            /* Konqueror HTML */
            -moz-user-select: none;
            /* Old versions of Firefox */
            -ms-user-select: none;
            /* Internet Explorer/Edge */
            user-select: none;
            /* Non-prefixed version, currently
                                  supported by Chrome, Edge, Opera and Firefox */
        }

        .rs-range::-moz-range-thumb {
            box-shadow: none;
            border: 0px solid #6e2a2a;
            box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.25);
            height: 42px;
            width: 22px;
            border-radius: 22px;
            background: rgb(136, 72, 72);
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -20px;
        }

        .rs-range::-moz-focus-outer {
            border: 0;
        }


        .rs-label {

            position: absolute;
            transform-origin: center center;
            display: block;
            width: 50px;
            height: 0;
            background: transparent;
            border-radius: 50%;
            line-height: 1;
            text-align: center;
            font-weight: bold;
            box-sizing: border-box;
            border: none;
            margin-top: 14px;
            margin-left: -1px;
            color: rgb(41, 38, 38);
            font-style: normal;
            font-weight: normal;
            line-height: normal;
            font-size: 0.8rem;
        }

        .rs-label::after {

            display: block;
            font-size: 0.8rem;
        }
    </style>
</div>
