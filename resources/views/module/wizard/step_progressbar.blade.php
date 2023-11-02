

<div id="progressbar" class="progressbar">
    {{-- <div class="progress-step progress-step-active" data-title="Pump Info"></div>
    <div class="progress-step" data-title="Godown"></div>
    <div class="progress-step" data-title="Rate"></div>
    <div class="progress-step" data-title="Invoice No"></div>
    <div class="progress-step" data-title="User"></div> --}}

</div>
<script>

    //console.log(stepper);



</script>

<style>
    *,
    *::before,
    *::after{
        box-sizing: border-box;
    }
    .stepper{
        /* width: clamp(320px,20%,430px); */
        width: 100%;
        margin: 0 auto;
        border: 1px solid #ccc;
        border-radius: 0.35rem;
        padding: 1.5rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    .progressbar {
    position: relative;
    display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
    counter-reset: step;
    margin: 0 1.5rem 1.5rem 1.5rem;
}
    .progressbar::before
    {
        content: "";
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        height: 4px;
        width: 100%;
        background-color: #829bee86;
        z-index: 1;

    }
    .progress-step{
        width: 2.1875rem;
        height: 2.1875rem;
        background-color: #dcdcdc;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;

    }
    .progress-step:hover{
        box-shadow: 0 0 5px 2px #3993dd99;
        border:2px solid #ccc;
        cursor: pointer;
        transition: 0.2s;
    }
    .progress-step::before{
        counter-increment: step;
        content:counter(step);
        z-index: 3;
        color: #284cc0;
        font-size: 0.8rem;
    }
    .progress-step::after{
        content: attr(data-title);
        position: absolute;
        top: calc(100% + 0.5rem);
        font-size: 0.8rem;
        justify-content: center;
        text-align:center;

    }
    .progress-step-active{
        background-color: #284cc0;
        color: #ccc;
    }
    .progress-step-active:before{
        color: #ccc;
    }
    .progress-step-active:after{
        color: #284cc0;
    }
    .progress-step:hover{
        font-weight: bold;
        transition: 0.2s;
    }
</style>
