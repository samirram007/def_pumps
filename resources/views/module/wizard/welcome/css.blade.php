<style>
    /* Custom class to apply Plus Jakarta Sans font family */
    #progessBlock .plus-jakarta-sans {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Custom styles for the cards */
    #progessBlock .cardScroll {
        /* overflow-x: scroll; */
        max-width: calc(100vw - 25px);
        overflow: auto;

    }

    #progressBlock .cards {
        display: flex;
        flex-flow: row nowrap;
        justify-content: start;
        margin-bottom: 10px;
        overflow-x: auto;
        width: 100%;
    }

    #progressBlock .card {
        width: 170px;
        min-height: 150px;
        text-align: center;
        position: relative;
        background-color: rgb(255, 255, 255);
        border-radius: 10%;
        padding: 3px 10px;
        border: 2px dashed #12e7c0;
    }

    /* Custom style for the green circle */
    #progressBlock .circle {
        position: absolute;
        top: -32px;
        /* Position the circle at the top of the card */
        left: 50%;
        /* Center the circle horizontally */
        transform: translateX(-50%);
        /* Center the circle horizontally */
        width: 70px;
        height: 70px;
        background-color: #12e7c0;
        /* Green color */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 2rem;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
    }

    #progressBlock .circle:focus,
    #progressBlock .circle:active {
        /* skew */
        outline: none !important;
        transition: all 0.4s ease-in-out;
        transform: scale(1.1) rotateZ(9deg);
        z-index: 1;

    }

    /* Adjust the position of h2 and p */
    #progressBlock .card-body {

        flex-direction: column;
        justify-content: center;
        height: 100%;

    }

    #progressBlock .get-started {
        display: flex;
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
        padding: 15px 25px;
        justify-content: center;
        background-color: #12e7c0;
        border: none;
        border-radius: 50px;
        color: #ffffff;
        transition: background-color 0.5s ease, box-shadow 0.3s ease, transform 0.3s ease;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
    }

    #progressBlock .get-started:hover {
        background-color: #0da568;
        transform: scale(1.05);
        /* Add a slight scale effect on hover */
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        /* Adjust box shadow on hover */
    }


    #progressBlock .frame {
        display: flex;
        flex-wrap: nowrap;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        /* Center items vertically */
        min-height: 30vh;
        max-height: 40vh;
        /* Set minimum height to the full viewport height */
    }

    #progressBlock .card-text {
        margin-bottom: 20px;
    }

    /* Styles for the SVG icon */
    #progressBlock .svg-icon {
        margin-top: 20px;
        /* Add margin to move the icon down */
        height: 50px;
    }

    #progressBlock .h1 {

        text-align: center;
        margin-bottom: 5px;
    }

    #progressBlock .p {
        padding: 10px 5px;
        text-align: center;
        margin-bottom: 20px;
        margin-top: 5px;
    }





    /* Fixed box styles */
    #progressBlock .fixed-box {
        display: flex;
        justify-content: center;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: white;
        padding: 15px 0px;
        box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.2);

    }

    @media(max-width:480px) {
        .fixed-box {
            display: flex;
            justify-content: center;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: white;
            padding: 15px 0px;
            box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.2);

        }
    }


    #progressBlock .col {
        width: 20%;
        margin: 1px;
        margin-bottom: 1px;
        cursor: pointer;
        transition: zoom 1s ease-in-out;
    }

    #progressBlock .progress-step-active .card::after {
        position: absolute;
        bottom: 0;
        left: 0;
        margin-left: -20px;
        margin-bottom: -20px;
        content: "\2713";
        rotate: 1deg;
        background: #2378e7;
        color: #ffffff;
        border-radius: 50%;
        font-size: 30px;
        width: 40px;
        height: 40px;
        box-shadow: 0 0 13px 0px #df2828;
    }

    #progressBlock .progress-step-active .card::after:hover {
        background: #5e9cec;
    }

    #progressBlock .current-step .card::after {
        content: "";
        display: none;
    }

    #progressBlock .col:active {
        zoom: 0.8;

    }

    @media(max-width:480px) {
        #progressBlock .col {
            width: 100%;
            margin: 1px;
            margin-bottom: 1px;
            padding-inline: 1px;
        }
    }


    #progressBlock .show-more {
        color: #ffffff;
        padding: 10px;
        border-radius: 20px;
        background-color: #22da91;
        width: 100px;
        cursor: pointer;
        display: inline;
        font-weight: bold;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: none;
        transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
        /* Add box shadow */
    }

    #progressBlock .show-more:hover {
        background-color: #1aa87a;
        transform: scale(1.1);
        /* Add a slight scale effect on hover */
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        /* Adjust box shadow on hover */
    }

    #progressBlock .show-less {
        color: #ffffff;
        padding: 10px;
        border-radius: 20px;
        margin-top: -10px;
        background-color: #22da91;
        width: 100px;
        cursor: pointer;
        display: none;
        font-weight: bold;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: none;
        transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
        /* Add box shadow */
    }

    #progressBlock .show-less:hover {
        background-color: #1aa87a;
        transform: scale(1.1);
        /* Add a slight scale effect on hover */
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        /* Adjust box shadow on hover */
    }


    #progressBlock .card-text-collapsed {
        max-height: 30px;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    #progressBlock .card-text-expanded {
        max-height: none;
        transition: max-height 0.3s ease-in;
    }

    #progressBlock .card-title {
        margin-bottom: 0px;
        margin-top: 8px;
    }

    #progressBlock .progress-step {
        zoom: 0.6;
        /* gary scale */
        filter: grayscale(100%);
        pointer-events: none;
    }

    #progressBlock .progress-step-active {
        zoom: 0.6;
        filter: grayscale(0%);
        pointer-events: auto;
    }

    #progressBlock .progress-step-active .card {
        width: 170px;
        min-height: 150px;
        text-align: center;
        position: relative;
        background-color: #12e7c030;
        border-radius: 10%;
        padding: 3px 10px;
        border: 2px dashed #12e7c0;
    }

    #progressBlock .current-step {
        zoom: 1;
        filter: grayscale(0%);
        pointer-events: none;
    }

    #progressBlock .current-step .card {
        width: 170px;
        min-height: 150px;
        text-align: center;
        position: relative;
        background-color: #12e7c049;
        border-radius: 10%;
        padding: 3px 10px;
        border: 3px dashed #12e7c0;
    }

    /* Add these styles to your existing CSS */


    .pe-none {
        pointer-events: none !important;
    }
</style>
