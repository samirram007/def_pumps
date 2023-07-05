<div class="card-content mt-2 ">
    <div class="row p-1 mx-2 card-row">
        <div class="card-pices">
            <div>
                <img src="{{ asset('images/icons/map-pump-icon-teal.png') }}" alt="">
            </div>
            <div>Retail Pumps</div>
        </div>
        <div class="card-pices">
            <div>
                <img src="{{ asset('images/icons/map-pump-icon.png') }}" alt="">
            </div>
            <div>Wholesale Pumps</div>
        </div>
        <div class="card-pices">
            <div>
                <img src="{{ asset('images/icons/map-pump-icon-red.png') }}" alt="">
            </div>
            <div>Below Recorder-point</div>
        </div>
        <div class="card-pices">
            <div>
                <img src="{{ asset('images/icons/map-pump-icon-gray.png') }}" alt="">
            </div>
            <div>Out of Searching Range</div>
        </div>

    </div>
</div>
<style>
    .card-content {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);
        padding: 0;
        margin: 0;
    }

    .card-content .row {
        margin: 0;
        padding: 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .card-content .row:last-child {
        border-bottom: none;
    }

    .card-content .row div:first-child {
        /* padding: 10px 10px 10px 20px; */

        text-align: left;

    }

    .card-content .row div:first-child img {
        height: 28px;
        width: 20px;

    }

    .card-content .row div:last-child {
        /* padding: 5px;
          padding: 10px 20px 10px 10px;
        text-align: left; */
    }

    .card-row {
        width: 100%;
        display: flex;
        text-align: center;
        flex-flow: column wrap;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .card-pices {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        flex-wrap: nowrap;
        margin: 5px;
    }

    .card-pices div:nth-child(2) {
        margin-left: 5px;
    }
</style>
