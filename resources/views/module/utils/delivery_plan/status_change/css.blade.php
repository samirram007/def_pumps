<style scoped>
    .status_panel * {
        margin: 0 !important;
        padding: 0 !important;
    }

    .set_complete {
        cursor: pointer;
    }

    .circle {
        height: 50px;
        width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #f4fcfa13;
        border-radius: 50%;
        font-size: 22px;
        margin-block: 5px;
        border: 2px solid #777;
        /* background-color: rgb(115, 175, 81); */

    }

    .row-block:has(.li_block) {
        display: flex;
        flex-flow: column nowrap;
        gap: 10px !important;
    }

    .row-block:has(.circle) {
        background-color: rgb(247, 248, 246);
        border: 2px solid rgb(115, 175, 81);
        color: rgb(115, 175, 81);
        padding: 5px 10px !important;
        border-radius: 20px;
        margin: 20px !important;
        box-shadow: 0 0 10px 5px #7777772d
    }

    .row-block:has(.pending) {
        background-color: rgb(247, 248, 246);
        border: 2px solid rgb(194, 194, 193);
        color: rgb(189, 190, 188);
        padding: 5px 10px !important;
        border-radius: 20px;
        margin: 20px !important;
        box-shadow: 0 0 10px 5px #7777772d
    }

    .row-block:has(.circle)::before {
        content: ' ';
    }


    .circle:has(.current) {
        background: linear-gradient(rgb(81, 124, 52), rgb(157, 207, 127));

        color: #e9f5ea;
        animation: bg_active 0.5s infinite ease-in-out;

    }

    @keyframes bg_active {
        0% {
            background: linear-gradient(rgb(98, 134, 75), rgb(177, 214, 155));
        }

        100% {
            background: linear-gradient(rgb(81, 124, 52), rgb(157, 207, 127));
        }
    }

    .circle:has(.done) {
        background-color: rgb(208, 238, 190);
        border: 2px solid rgb(115, 175, 81);
        color: rgb(115, 175, 81);
    }

    .circle:has(.pending) {
        background-color: rgb(231, 234, 236);
        border: 2px solid rgb(219, 219, 219);
        color: #aeafb1 !important;
    }

    .row-block>div:last-child {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        font-size: 18px;
        padding-left: 10px !important;

    }


    .list-group-item {
        border-bottom: 3px solid #bdb7b73d !important;
    }




    .text-break {
        white-space: pre-wrap;
    }


    .gap-10 {
        gap: 10px;
    }

    .fa-circle {
        border-radius: 50%;
        background-color: #9ca3a270;
        color: #0a705a;
        font-size: 100%;
    }

    .fa-circle:active {
        background-color: #464949d0;
        color: #d0ebe5;
        rotate: 45deg;
    }

    .fa-circle:hover {
        background-color: #3b6e6e91;
        color: #13332c;
        rotate: -135deg;
        transition: rotate 1s ease-in-out;
    }

    #table>tbody>tr>td:nth-child(1),
    #table>tbody>tr>td:nth-child(5),
    #table>tbody>tr>td:nth-child(6),
    #table>tbody>tr>td:nth-child(7) {
        text-align: center
    }

    #modal-popup {
        padding-right: 0 !important
    }
</style>
