<style>
    body {
        background-color: #f3f3f3;
        /* Light grey background color */
    }

    /* Custom class to apply Plus Jakarta Sans font family */
    .plus-jakarta-sans {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Custom styles for the cards */
    .cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 70px;

    }

    .card {
        width: 250px;
        min-height: 200px;
        text-align: center;
        /* Center-align the text */
        position: relative;
        /* Position relative for absolute positioning of circle */
        background-color: rgb(255, 255, 255);
        border-radius: 10%;
        padding: 20px 10px;
        /* Adjust padding for the dashed outline */
        border: 2px dashed #12e7c0;
        /* Dashed outline */
    }

    /* Custom style for the green circle */
    .circle {
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

    /* Adjust the position of h2 and p */
    .card-body {

        flex-direction: column;
        justify-content: center;
        height: 100%;

    }

    .get-started {
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

    .get-started:hover {
        background-color: #0da568;
        transform: scale(1.05);
        /* Add a slight scale effect on hover */
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        /* Adjust box shadow on hover */
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

    .card-text {
        margin-bottom: 20px;
    }

    /* Styles for the SVG icon */
    .svg-icon {
        margin-top: 40px;
        /* Add margin to move the icon down */
        height: 50px;
    }

    .h1 {

        text-align: center;
        margin-bottom: 5px;
    }

    .p {
        padding: 10px 5px;
        text-align: center;
        margin-bottom: 20px;
        margin-top: 5px;
    }





    /* Fixed box styles */
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

    .col {
        margin: 10px;
        margin-bottom: 40px;
    }


    .show-more {
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

    .show-more:hover {
        background-color: #1aa87a;
        transform: scale(1.1);
        /* Add a slight scale effect on hover */
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        /* Adjust box shadow on hover */
    }

    .show-less {
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

    .show-less:hover {
        background-color: #1aa87a;
        transform: scale(1.1);
        /* Add a slight scale effect on hover */
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        /* Adjust box shadow on hover */
    }


    .card-text-collapsed {
        max-height: 30px;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .card-text-expanded {
        max-height: none;
        transition: max-height 0.3s ease-in;
    }

    .card-title {
        margin-bottom: 0px;
        margin-top: 8px;
    }
</style>
