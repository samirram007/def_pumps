<style>
    .description {
        font-size: 0.8rem;
        color: #0689bd;
        border: 1px dashed #0689bd00;
        margin: 3px 5px 10px 0;
        /* padding: 0 5px; */
        border-radius: 10px;
        text-align: left;
    }

    .wizard-box {
        min-height: 50vh;
        max-height: 100%;
        border-bottom: 7px solid #31787a
    }

    @media screen and (max-width:480px) {
        .wizard-box {
            min-height: 70vh;
            max-height: 100%;
            border-bottom: 0px solid #31787a;
            margin-bottom: 10px;

        }
    }

    .form-control {
        color: #0689bd;
        background: #eceded85;
    }

    .form-control:focus {
        color: #0689bd;
        background: #cde0e048;
        clear: both;
        -webkit-user-modify: read-write-plaintext-only;
    }

    .form-control:focus+.description {
        color: #0055c5;
        font-weight: bolder;
        background: #cde0e048;
    }

    .scroll-box {
        overflow-y: auto;
        overflow-x: clip;

    }

    .scroll-box::-webkit-scrollbar {
        width: 5px;
    }

    .scroll-box::-webkit-scrollbar-track {
        box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.3);
    }

    .scroll-box::-webkit-scrollbar-thumb {
        background-color: rgb(19, 120, 221);
        outline: 0 solid rgb(19, 120, 221);
    }

    .btn-section {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .info-image {
        min-height: 60vh;
        max-height: 60vh;
    }

    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 140px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 150%;
        left: 50%;
        margin-left: -75px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    .count-char {
        right: 14px;
        bottom: 0;
        font-size: 0.75rem;
        font-weight: bolder;
        color: #0689bd;
    }

    .form-group>label {
        margin-bottom: .1rem !important;
    }
</style>

<style>
    .description {
        display: none;
    }

    .info {
        color: rgb(196, 199, 199);
        position: absolute;
        right: 10px;
        top: 35px;
        border-radius: 50%;
    }

    .info-select {
        right: 15px !important;
    }

    .info:active,
    .info:hover {
        color: #346bda;
    }

    .info:active {
        box-shadow: 0 0 5px 5px #719cf1;
    }

    .form-group>label {
        width: 100% !important;
        position: relative;
    }
</style>
