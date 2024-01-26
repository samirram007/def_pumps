<section class="content">
    <div class="  p-3 bg-transparent   min-h-100">

        <div class="row">


            <div class=" col-12  ">
                <div class="wizard-box scroll-box card card-primary position-relative ">



                    <div class="big-images-section">
                        <img src="{{ asset('wizard/welcome_cartoon.png') }}" alt="Image 1" class="big-image">
                        <button class="get-started plus-jakarta-sans  "
                            onclick="handleClickGetStarted(this)">{{ __('Get  Started') }}</button>
                        <img src="{{ asset('wizard/pump.svg') }}" alt="Image 2" class="big-image2">

                    </div>
                    {{-- <h1 class="h1 plus-jakarta-sans">5 Steps Pump Creation Process</h1>

                        <p class="p card-text plus-jakarta-sans">Here's a quick overview of the process, from start to
                            finish.</p>

                        <div class="fixed-box">
                            <button class="get-started   btn btn-info animated-shine btn-rounded"
                                onclick="handleClickGetStarted(this)"> </button>
                        </div> --}}



                </div>
            </div>
        </div>
    </div>
    <style>
        .big-images-section {
            background: linear-gradient(to bottom right, #ffffff, #f0f0f0);
            box-shadow: none;
            padding: 20px 30px;
            display: flex;
            flex-flow: row wrap;

            flex: 1;
            justify-content: space-evenly;
            /* Adjust spacing between images */
            align-items: center;
            width: 100%;
            border-radius: 10px;
            overflow: visible;
        }

        /* Add these styles to your existing CSS */
        .big-image {
            width: 450px;

            /* Adjust the width of images */
            height: 300px;
            /* Adjust the height of images */
            margin-left: -63px;
            transition: transform 0.3s ease;
            /* Add transition */
            border-radius: 10px;

        }

        @media (max-width: 480px) {
            .big-image {
                width: 100%;
                height: 100%;
                margin-left: 0;
            }
        }

        .big-image2 {
            width: 300px;
            /* Adjust the width of images */
            height: 300px;
            /* Adjust the height of images */
            transition: transform 0.3s ease;
            /* Add transition */
            border-radius: 10px;
        }

        .big-image:hover,
        .big-image2:hover {
            transform: scale(1.1);
            /* Add a slight scale effect on hover */
        }

        .get-started {
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            cursor: pointer;
            padding: 10px 45px;
            background: linear-gradient(135deg, #12e7c0, #078e76);
            /* Match gradient with box */
            border: none;
            border-radius: 50px;
            color: #ffffff;
            transition: background-color 0.5s ease, box-shadow 0.3s ease, transform 0.3s ease;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
        }

        /* Add these styles to your existing CSS */

        .get-started:hover {
            background: linear-gradient(135deg, #0da568, #066c5a);
            /* Adjust hover gradient */
            transform: scale(1.05);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }



        .frame {
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* Center items vertically */
            min-height: 50vh;
            /* Set minimum height to the full viewport height */
        }
    </style>
</section>
