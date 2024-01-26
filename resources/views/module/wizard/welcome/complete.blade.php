<section class="content">
    <div class="  p-3 bg-transparent   min-h-100">

        <div class="row">
            <div class=" col-12  ">
                <div class="wizard-box scroll-box card card-primary position-relative ">


                    <div class="rounded card p-3 bg-white shadow min-h-100 d-none ">
                        @include('module.wizard.office.info')

                    </div>

                    <div class="rounded card p-3 bg-white   min-h-100 m-4 shadow-anim">Please wait while we are
                        processing
                        your
                        data...</div>
                    {{-- <div class="complete-deleted-success offset-sm-2 offset-md-4 col-md-4 col-sm-8 d-none"> --}}
                    <div class="complete-deleted-success   d-none">
                        <div class="frame">
                            <h1 class="h1 plus-jakarta-sans"><span class="successfully">Congrats!</span> Pump created
                                successfully</h1>
                            <p class="p card-text plus-jakarta-sans">Thank you for being patient through the process.
                            </p>

                            <!-- Replace cards with the SVG icon -->
                            <img src="{{ asset('wizard/check.png') }}" alt="Check Icon" class="svg-icon">

                            <button class="get-started plus-jakarta-sans"
                                onclick="makeFirstSale()">{{ __('Make you first sale') }}</button>
                        </div>
                        <a href="javascript:" onclick="()=>{}" class="btn_sales btn btn-primary  d-none  btn-block"> Go
                            to
                            sale</a>
                    </div>


                    <style>
                        .bg-info {
                            background-color: #17a2b8 !important;

                        }

                        .shadow-anim {
                            background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 0%, rgba(49, 109, 79, 0) 1%);
                            box-shadow: 0 5px 10px rgba(6, 216, 6, 0.3);
                            animation: shadow 5s ease-in-out infinite forwards;
                        }

                        /* Keyframes for shadow animation */
                        @keyframes shadow {
                            0% {
                                box-shadow: 0 5px 10px rgba(6, 216, 6, 0.3);
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 0%, rgba(49, 109, 79, 0) 1%);

                            }

                            10% {
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 8%, rgba(49, 109, 79, 0) 11%);
                            }

                            20% {
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 18%, rgba(49, 109, 79, 0) 21%);
                            }

                            30% {
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 28%, rgba(49, 109, 79, 0) 31%);
                            }

                            40% {
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 33%, rgba(49, 109, 79, 0) 41%);
                            }

                            50% {
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 43%, rgba(49, 109, 79, 0) 51%);
                            }

                            60% {
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 54%, rgba(49, 109, 79, 0) 61%);
                            }

                            70% {
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 65%, rgba(49, 109, 79, 0) 71%);
                            }

                            80% {
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 76%, rgba(49, 109, 79, 0) 81%);
                            }

                            90% {
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 87%, rgba(49, 109, 79, 0) 91%);
                            }

                            100% {
                                box-shadow: 0 10px 30px rgba(19, 63, 184, 0.6);
                                background: linear-gradient(90deg, rgba(49, 56, 109, 0.171) 98%, rgba(49, 109, 79, 0) 110%);

                            }
                        }
                    </style>
                    <style>
                        /* Custom class to apply Plus Jakarta Sans font family */
                        .plus-jakarta-sans {
                            font-family: 'Plus Jakarta Sans', sans-serif;
                        }

                        .frame {
                            text-align: center;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            padding-bottom: 20px
                        }

                        .frame .h1 {
                            font-size: 2rem !important;
                        }

                        .h1 {
                            padding: 10px;
                            margin-bottom: 5px;
                            color: #2c3e50;
                            /* Dark blue-gray text color */
                        }

                        .successfully {
                            color: #0fc47c;
                            /* Green color for "Successfully" */
                        }

                        .p {
                            padding: 10px;
                            margin-bottom: 0px;
                        }

                        .svg-icon {
                            margin-top: 0px;
                            /* Add margin to move the icon down */
                            height: 270px;
                            /* Adjust the height as needed */
                            width: auto;
                            /* Maintain aspect ratio */
                        }

                        .border-box-none {
                            border: none;
                            box-shadow: none;
                        }

                        .get-started {
                            font-size: 1.5rem;
                            margin-top: 20px;
                            /* Adjust the margin as needed */
                            font-weight: bold;
                            cursor: pointer;
                            /* Set cursor to pointer for better UX */
                            padding: 10px 45px;
                            /* Reduced width */
                            background-color: #0fc47c;
                            /* Green color for the button */
                            border: none;
                            /* Remove button border */
                            border-radius: 50px;
                            /* Rounded corners for a smoother look */
                            color: #ffffff;
                            /* White text color */
                            transition: background-color 0.5s ease, transform 0.3s ease, box-shadow 0.3s ease;
                            /* Add smooth transitions */
                            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
                            /* Add box shadow */
                        }

                        .get-started:hover {
                            background-color: #219d54;
                            /* Darker green color on hover */
                            transform: scale(1.05);
                            /* Add a subtle scale effect on hover */
                            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
                            /* Adjusted box shadow on hover */
                        }
                    </style>
                    <script>
                        $(document).ready(function() {
                            // setTimeout(() => {
                            //     document.querySelector('.btn_sales').classList.remove('d-none')
                            // }, 3000);
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</section>
