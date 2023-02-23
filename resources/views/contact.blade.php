<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="{{asset('landing/dist/css/style.css')}}">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/bn/bn-style.css')}}">
</head>
<body>
<section class="contact-us-wrap">
    
    <section class="contact-us-cont">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 left-part">
                    <div class="brand header-brand">
                        <h1 class="m-0">
                            <a href="#">
                                <img class="header-logo-image asset-light" src="{{asset('landing/dist/images/logo.png')}}" alt="Logo">
                                <img class="header-logo-image asset-dark" src="{{asset('landing/dist/images/logo-white.png')}}" alt="Logo">
                            </a>
                        </h1>
                    </div>
                    <div class="call"> 
                        <i class="fa fa-phone" aria-hidden="true"></i>  Call Us: <a href="tel:9026917869"> 9026917869 </a> / <a href="tel:8828353235">  8828353235</a>
                    </div>
                    <div class="infographics">
                        <img class="" src="{{asset('css/bn/bn-images/contact-infographics.png')}}" alt="DEF-Pump">
                    </div>
                    <div class="join-now">
                    <a href="#">
                        <span>Join Us</span>
                    </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 form-box">
                <div class="box">
                    <h2>Contact Us</h2>
                    <h3 class="heading">Send us a message</h3>
                    <form class="mb-5" method="post" id="contactForm" name="contactForm" novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name" class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="email" class="col-form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="phone" class="col-form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 form-group">
                                <label for="message" class="col-form-label">Message</label>
                                <textarea class="form-control" name="message" id="message" cols="30" rows="7"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" value="Submit">
                                <span class="submitting"></span>
                            </div>
                        </div>
                    </form>
                    <div id="form-message-warning mt-4"></div>
                    <div id="form-message-success">
                        Your message was sent, thank you!
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="text-center py-5">We Are Certified From</h5>
                </div>
                <ul class="brand-logos">
                    <li><img class="img-fluid" src="{{asset('css/bn/bn-images/iso.png')}}" alt="iso"></li>
                    <li><img class="img-fluid" src="{{asset('css/bn/bn-images/certified.png')}}" alt="iso"></li>
                    <li><img class="img-fluid" src="{{asset('css/bn/bn-images/uk-certificate.png')}}" alt="iso"></li>
                </ul>    
            </div>
            <div class="row brand-logo-wrap">
                <div class="col-lg-12">
                    <h4 class="text-center py-5">These Organisation Trust Us</h4>
                </div>
                <ul class="brand-logos">
                    <li> <a href="#"><img class="img-fluid" src="{{asset('css/bn/bn-images/ashok.png')}}" alt="Ashok Leyland"></a></li>
                    <li> <a href="#"><img class="img-fluid" src="{{asset('css/bn/bn-images/eicher.png')}}" alt="Eicher"></a></li>
                    <li> <a href="#"><img class="img-fluid" src="{{asset('css/bn/bn-images/mahindra.png')}}" alt="Mahindra"></a></li>
                    <li> <a href="#"><img class="img-fluid" src="{{asset('css/bn/bn-images/marcopolo.png')}}" alt="Marcopolo"></a></li>
                    <li> <a href="#"><img class="img-fluid" src="{{asset('css/bn/bn-images/tata.png')}}" alt="Tata"></a></li>
                </ul>
            </div>
        </div>
    </section>    
</section>  
        
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{asset('landing/dist/js/main.min.js')}}"></script>
    <script src="{{asset('landing/src/js/main.js')}}"></script>
</body>
</html>
