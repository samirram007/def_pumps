<script>
    const getStartedBtntext = "{{ __('Get started') }}"
    const saveBtntext = "{{ __('Save & Next') }}"
    const completeBtntext = "{{ __('Complete') }}"
    const stepCount = document.querySelector("#stepCount")

    var step = @json($step);
    var routeRole = @json($routeRole);
    var section_modal = $('#section_modal');
    var section = section_modal;
    // var officeId = '';
    var wizardId = @json($wizardId);
    var SalesOfficeId = "";
    var masterOfficeId = '';
    var wizardOfficeId = '';
    var isUnderProgress = false;

    var isOfficeUnderProgress = false;
    var isGodownUnderProgress = false;
    var isProductUnderProgress = false;
    var isInvoiceUnderProgress = false;
    var isUserUnderProgress = false;

    $(document).ready(function() {
        letStep()
        $('#step-office').on('click', () => {
            step = "create_office"
            step = localStorage.setItem('step', 'create_office')
            letStep()
        })
        $('#step-godown').on('click', () => {
            step = "godown"
            step = localStorage.setItem('step', 'godown')
            letStep()
        })
        $('#step-product').on('click', () => {
            step = "product"
            step = localStorage.setItem('step', 'product')
            letStep()
        })
        $('#step-invoice').on('click', () => {
            step = "invoice"
            step = localStorage.setItem('step', 'invoice')
            letStep()
        })
        $('#step-user').on('click', () => {
            step = "user"
            step = localStorage.setItem('step', 'user')
            letStep()
        })





        function letStep() {

            $('.modal_section').addClass('d-none')
            let stepLoading = false

            if (localStorage.getItem("step") == null) {
                localStorage.setItem('step', 'welcome')
                step = "welcome"
            } else {
                step = localStorage.getItem('step')
                stepLoading = true

            }

            if (['modal', 'welcome'].includes(step)) {

                setTimeout(() => {
                    stepWelcome();

                }, 100);
            } else if (['create_office'].includes(step)) {
                setTimeout(() => {
                    stepOffice();

                }, 100);
            } else if (['godown'].includes(step)) {
                setTimeout(() => {
                    stepGodown();
                }, 100);
            } else if (['product'].includes(step)) {

                setTimeout(() => {
                    stepProduct();
                }, 100);
            } else if (['invoice'].includes(step)) {

                setTimeout(() => {
                    stepInvoice();
                }, 100);
            } else if (['user'].includes(step)) {

                setTimeout(() => {
                    stepUser();
                }, 100);
            } else if (['complete'].includes(step)) {

                setTimeout(() => {
                    stepComplete();
                }, 100);
            }


        }



        function ajaxPost(url, section, data) {
            $.ajax({
                url: url,
                method: "POST",
                data: data,
                success: function(response) {

                    if (response.status) {

                        section.innerHTML = response.html;
                        return;
                    }
                    toastr.error('something went wrong');
                    return;

                }
            });
        }



    });

    function stepWelcome() {
        step = 'welcome'
        localStorage.setItem('step', step)

        var url = "{{ route($routeRole . '.wizard.modal', 'welcome') }}";

        ajaxGet(url, 'stepWelcome');
        //loadStepData()
        setTimeout(() => {
            $('.modal_section').addClass('d-none')
            $(`#stepWelcome`).removeClass('d-none');
            const getStartedBtn = document.querySelector('.get-started')
            getStartedBtn.style = "opacity:0.2"
            getStartedBtn.innerHTML = getStartedBtntext
        }, 100);


    }

    function stepOffice() {
        //$('#spinner').removeClass('d-none')
        step = "create_office"
        localStorage.setItem("step", step);
        $('.progress-step').removeClass('current-step');
        var url = "{{ route($routeRole . '.wizard.modal', 'create_office') }}";
        $('#title').html("New Pump");
        if (localStorage.getItem("officeInfo") == null) {
            console.log("One");
            ajaxGet(url, 'stepOffice');

        } else if (!isUnderProgress) {
            isUnderProgress = true
            isOfficeUnderProgress = true
            console.log("two");
            ajaxGet(url, 'stepOffice');
        } else if (!isOfficeUnderProgress) {
            isUnderProgress = true
            isOfficeUnderProgress = true
            console.log("three");
            ajaxGet(url, 'stepOffice');
        } else if (isUnderProgress && isOfficeUnderProgress) {
            console.log("four");
            loadStepData()

        }



    }

    function stepGodown() {
        step = 'godown'
        localStorage.setItem('step', step)
        $('.progress-step').removeClass('current-step');

        // $('#spinner').removeClass('d-none')
        var url = "{{ route($routeRole . '.wizard.modal', 'godown') }}";
        // console.log(JSON.parse(localStorage.getItem("godownInfo")).length);
        if (localStorage.getItem("godownInfo") == null) {
            ajaxGet(url, 'stepGodown');
        } else if (JSON.parse(localStorage.getItem("godownInfo")).length) {
            isUnderProgress = true
            isGodownUnderProgress = true
            ajaxGet(url, 'stepGodown');
        } else if (!isUnderProgress) {
            isUnderProgress = true
            isGodownUnderProgress = true
            ajaxGet(url, 'stepGodown');
        } else if (!isGodownUnderProgress) {
            isUnderProgress = true
            isGodownUnderProgress = true
            ajaxGet(url, 'stepGodown');
        } else if (isUnderProgress && isGodownUnderProgress) {
            loadStepData()

        }



        // $('#spinner').addClass('d-none')

    }

    function stepProduct() {
        step = 'product'
        localStorage.setItem('step', step)
        $('.progress-step').removeClass('current-step');
        // $('#spinner').removeClass('d-none')
        var url = "{{ route($routeRole . '.wizard.modal', 'product') }}";
        if (localStorage.getItem("productInfo") == null) {
            ajaxGet(url, 'stepProduct');
        } else if (JSON.parse(localStorage.getItem("productInfo")).length) {
            isUnderProgress = true
            isProductUnderProgress = true
            ajaxGet(url, 'stepProduct');
        } else if (!isUnderProgress) {
            isUnderProgress = true
            isProductUnderProgress = true
            ajaxGet(url, 'stepProduct');
        } else if (!isProductUnderProgress) {
            isUnderProgress = true
            isProductUnderProgress = true
            ajaxGet(url, 'stepProduct');
        } else if (isUnderProgress && isProductUnderProgress) {
            loadStepData()

        }



    }

    function stepInvoice() {
        step = 'invoice'
        localStorage.setItem('step', step)

        // $('#spinner').removeClass('d-none')
        var url = "{{ route($routeRole . '.wizard.modal', 'invoice') }}";
        if (localStorage.getItem("officeInfo") == null) {
            ajaxGet(url, 'stepInvoice');
        } else if (!isUnderProgress) {
            isUnderProgress = true
            isInvoiceUnderProgress = true
            ajaxGet(url, 'stepInvoice');
        } else if (!isInvoiceUnderProgress) {
            isUnderProgress = true
            isInvoiceUnderProgress = true
            ajaxGet(url, 'stepInvoice');
        } else if (isUnderProgress && isInvoiceUnderProgress) {
            loadStepData()
            $('#stepInvoice').removeClass('d-none');
        }


    }

    function stepUser() {
        step = 'user'
        localStorage.setItem('step', step)

        // $('#spinner').removeClass('d-none')
        var url = "{{ route($routeRole . '.wizard.modal', 'user') }}";

        console.log('user');
        if (localStorage.getItem("userInfo") == null) {
            ajaxGet(url, 'stepUser');
        } else if (!isUnderProgress) {
            isUnderProgress = true
            isUserUnderProgress = true
            ajaxGet(url, 'stepUser');
        } else if (!isUserUnderProgress) {
            isUnderProgress = true
            isUserUnderProgress = true
            ajaxGet(url, 'stepUser');
        } else if (isUnderProgress) {
            loadStepData()

        }

    }

    function stepComplete() {
        step = 'complete'
        localStorage.setItem('step', step)

        // $('#spinner').removeClass('d-none')
        var url = "{{ route($routeRole . '.wizard.modal', 'complete') }}";

        ajaxGet(url, 'stepComplete');



    }

    function welcomeInfo() {
        console.log('Welcome Info Called');

    }

    function officeInfo() {
        //console.log();
        let data = localStorage.getItem("officeInfo")

        if (data == null || data == undefined) return false;
        else {
            data = JSON.parse(data);
            let thisHTML = ``
            thisHTML = `<div class="card rounded px-3 py-1 text-info" style="border-bottom: 3px solid #31787a;">
                <div>{{ __('Pump') }}: <span id="infoOfficeName" class="font-weight-bold">${data.officeName}</span></div>
                <div>{{ __('Type') }}: <span id="infoOfficeType" class="font-weight-bolder">${data.officeType.replace('Pumps','')}</span></div>
            </div>`


            document.querySelector(".BlockOfficeInfo").innerHTML = thisHTML
        }

    }

    async function storeOffice() {
        var btnOfficeStore = document.querySelector('.btn-office-store')
        var officeName = document.getElementById("officeName").value;
        var masterOfficeId = document.getElementById("masterOfficeId").value;
        var officeTypeId = document.getElementById("officeTypeId").value;
        var officeEmail = document.getElementById("officeEmail").value;
        var officeContactNo = document.getElementById("officeContactNo").value;
        var gstTypeId = document.getElementById("gstTypeId").value;
        var gstNumber = document.getElementById("gstNumber").value;
        var registeredAddress = document.getElementById("registeredAddress").value;
        var officeAddress = document.getElementById("officeAddress").value;
        var longitude = document.getElementById("longitude").value;
        var latitude = document.getElementById("latitude").value;

        var dropdown = document.querySelector("#officeTypeId");
        var selectedOption = dropdown.options[dropdown.selectedIndex];
        var officeType = selectedOption.text;
        var fiscalYearId = 2;
        // var officeType = document.querySelector("#officeTypeId").find(":selected").text();

        var errorStr = '<ul></ul>'
        var isError = false;
        if (officeName == '') {
            isError = true
            errorStr += `<li>Office Name is required</li>`
        } else {
            try {
                let exists = await officeNameExist(officeName);
                if (exists) {
                    isError = true;
                    errorStr += `<li>Office Name already taken</li>`;
                    // Perform other actions based on existence...
                } else {
                    // Office name does not exist; handle accordingly...
                }
            } catch (error) {
                // Handle error if fetch or processing fails
                console.error(error);
            }
        }
        if (masterOfficeId == '') {

            isError = true
            errorStr += `<li>Master Office is required</li>`
        }
        if (officeTypeId == '') {

            isError = true
            errorStr += `<li>Office Type is required</li>`
        }
        if (officeEmail != '') {
            //check email format
            var emailReg = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
            if (!emailReg.test(String(officeEmail).toLowerCase())) {

                isError = true
                errorStr += `<li>Please enter valid email</li>`
            }
        }
        if (officeContactNo != '') {
            //check contact no format
            // console.log(officeContactNo.length, gstTypeId);
            if (officeContactNo.length != 10) {
                isError = true
                errorStr += `<li>Invalid Contact No</li>`
            }
        }
        if (gstTypeId != '0') {
            if (gstNumber == '') {

                isError = true
                errorStr += `<li>GST Number is required</li>`
            }
            if (gstNumber.length < 13) {

                isError = true
                errorStr += `<li>Invalid GST Number</li>`
            }
        }
        if (!true) {
            if (registeredAddress == '') {

                isError = true
                errorStr += `<li>Business Communication Address is required</li>`
            }
            if (officeAddress == '') {

                isError = true
                errorStr += `<li>Pump Location is required</li>`
            }
            if (longitude == '') {

                isError = true
                errorStr += `<li>Longitude is required</li>`
            }
            if (latitude == '') {

                isError = true
                errorStr += `<li>Latitude is required</li>`
            }
        }

        errorStr += `</ul>`
        if (isError) {
            btnOfficeStore.innerHTML = saveBtntext
            btnOfficeStore.classList.remove("pe-none")
            toastr.error(errorStr)
            return
        }
        let invoiceNo = '';
        var ExistingOfficeInfo = localStorage.getItem("officeInfo")
        // console.log(ExistingOfficeInfo != null ? 'f' : 't');
        if (ExistingOfficeInfo !== null) {
            ExistingOfficeInfo = JSON.parse(ExistingOfficeInfo);
            // console.log(ExistingOfficeInfo);
            if (ExistingOfficeInfo.invoiceNo !== null && ExistingOfficeInfo.invoiceNo !== 'undefined') {
                invoiceNo = ExistingOfficeInfo.invoiceNo
            }
            if (ExistingOfficeInfo.fiscalYearId !== null && ExistingOfficeInfo.fiscalYearId !== 'undefined' &&
                ExistingOfficeInfo.fiscalYearId != 0) {
                fiscalYearId = ExistingOfficeInfo.fiscalYearId
            }
        }
        //console.log(ExistingOfficeInfo);
        //return
        let officeInfo = {
            "officeName": officeName,
            "masterOfficeId": masterOfficeId,
            "officeTypeId": officeTypeId,
            "officeType": officeType,
            "officeEmail": officeEmail,
            "officeContactNo": officeContactNo,
            "gstTypeId": gstTypeId,
            "gstNumber": gstNumber,
            "registeredAddress": registeredAddress,
            "officeAddress": officeAddress,
            "longitude": longitude,
            "latitude": latitude,
            "invoiceNo": invoiceNo,
            "fiscalYearId": fiscalYearId,
        };
        localStorage.setItem("officeInfo", JSON.stringify(officeInfo))
        callPostPayload()
        //stepGodown()

        // btnOfficeStore.innerHTML = saveBtntext
        // btnOfficeStore.classList.remove("pe-none")
        // console.log(officeInfo); //
    }

    async function officeNameExist(officeName) {
        let url = `{{ env('API_RESOURCE_URL') }}Office/OfficeNameCheck/${btoa(officeName)}`
        try {
            let res = await fetch(url);
            let data = await res.json();
            console.log(data);
            return data;
        } catch (error) {
            console.error(error);
            throw new Error('Failed to check office name existence');
        }
    }

    function storeGodown() {
        let godownName = document.querySelector("#createGodown #godownName").value;

        if (godownName === '') {
            $('#godownNameError').html('Godown Name is required');
            return;
        }
        let isReserver = document.querySelector("#createGodown #isReserver").value;
        let godownTypeId = document.querySelector("#createGodown #godownTypeId").value;
        let thisGodownInfo = {
            "godownName": godownName,
            "isReserver": isReserver,
            "godownTypeId": godownTypeId,
        };

        if (localStorage.getItem("godownInfo") == null) {
            const godownInfo = []
            godownInfo.push(thisGodownInfo)
            localStorage.setItem("godownInfo", JSON.stringify(godownInfo))
        } else {
            const godownInfo = JSON.parse(localStorage.getItem("godownInfo"))
            const existingGodown = godownInfo.filter(godown => godown.godownName == godownName)
            if (existingGodown.length > 0) {

                // ERROR: if same name exist
                // $('#godownNameError').html('Godown Name already exists');
                // return;

                //Delete AND Push as new
                const exceptionGodowns = godownInfo.filter(godown => godown.godownName !== godownName)
                exceptionGodowns.push(thisGodownInfo)
                localStorage.setItem("godownInfo", JSON.stringify(exceptionGodowns))
                return
            }
            godownInfo.push(thisGodownInfo)
            localStorage.setItem("godownInfo", JSON.stringify(godownInfo))

        }

    }

    function storeGodownIntoOffice() {
        const godownInfo = localStorage.getItem("godownInfo")
        // console.log(godownInfo ? JSON.parse(godownInfo).length : 0);
        // return
        if (godownInfo == null || (godownInfo ? JSON.parse(godownInfo).length : 0) == 0) {
            var btnGodownStore = document.querySelector('.btn-godown-store')
            btnGodownStore.innerHTML = saveBtntext
            btnGodownStore.classList.remove("pe-none")
            toastr.error("Please add some godown information")
            return;
        }
        callPostPayload()


    }


    function storeProductInfo() {
        let productId = document.querySelector("#formProduct #productId").value;

        if (productId === '') {
            $('#productIdError').html('Product is required');
            return;
        }
        let productRate = document.querySelector("#formProduct #productRate").value;
        let openingStock = document.querySelector("#formProduct #openingStock").value;

        var errorStr = '<ul></ul>'
        var isError = false;
        if (productId == '') {
            isError = true
            errorStr += `<li>Select a Product</li>`
        }
        if (productRate == '') {

            isError = true
            errorStr += `<li>Product Rate is required</li>`
        }
        if (openingStock == '') {

            isError = true
            errorStr += `<li>Add some stock</li>`
        }
        errorStr += `</ul>`
        if (isError) {
            toastr.error(errorStr)
            // return
        }
        let thisProductInfo = {
            "productId": productId,
            "productRate": productRate,
            "openingStock": openingStock,
        };

        if (localStorage.getItem("productInfo") == null) {
            const productInfo = []
            productInfo.push(thisProductInfo)
            localStorage.setItem("productInfo", JSON.stringify(productInfo))
        } else {
            const productInfo = JSON.parse(localStorage.getItem("productInfo"))
            const existingProduct = productInfo.filter(product => product.productId == productId)
            if (existingProduct.length > 0) {

                // ERROR: if same name exist
                // $('#godownNameError').html('Godown Name already exists');
                // return;

                //Delete AND Push as new
                const exceptionProducts = productInfo.filter(product => product.productId !== productId)
                exceptionProducts.push(thisProductInfo)
                localStorage.setItem("productInfo", JSON.stringify(exceptionProducts))
                return
            }
            productInfo.push(thisProductInfo)
            localStorage.setItem("productInfo", JSON.stringify(productInfo))

        }
    }

    function storeProductIntoOffice() {
        const productInfo = localStorage.getItem("productInfo")
        // console.log(godownInfo ? JSON.parse(godownInfo).length : 0);
        // return
        if (productInfo == null || (productInfo ? JSON.parse(productInfo).length : 0) == 0) {
            toastr.error("Please add some product information")
            var btnProductStore = document.querySelector('.btn-product-store')
            btnProductStore.innerHTML = saveBtntext
            btnProductStore.classList.remove("pe-none")
            return;
        }
        callPostPayload()


    }

    function storeInvoiceNoIntoOffice() {
        var invoiceNo = document.querySelector("#stepInvoice #invoiceNo").value;
        var fiscalYearId = document.querySelector("#stepInvoice #fiscalYearId").value;
        var errorStr = '<ul></ul>'
        var isError = false;

        if (invoiceNo == '' || invoiceNo == 'undefined') {
            isError = true
            errorStr += `<li>Invoice No is required</li>`

        }
        if (invoiceNo == '0') {
            isError = true
            errorStr += `<li>Invoice No is not valid</li>`

        }
        if (fiscalYearId == '' || fiscalYearId == null || fiscalYearId == 'undefined') {
            isError = true
            errorStr += `<li>Fiscal year is required</li>`

        }
        if (invoiceNo == '0') {
            isError = true
            errorStr += `<li>Fiscal year is not valid</li>`

        }

        errorStr += `</ul>`
        if (isError) {
            toastr.error(errorStr)
            var btnInvoiceStore = document.querySelector('.btn-invoice-store')
            btnInvoiceStore.innerHTML = saveBtntext
            btnInvoiceStore.classList.remove("pe-none")
            return
        }
        let officeInfo = JSON.parse(localStorage.getItem("officeInfo"))

        officeInfo["invoiceNo"] = invoiceNo
        officeInfo["fiscalYearId"] = fiscalYearId

        localStorage.setItem("officeInfo", JSON.stringify(officeInfo))
        // console.log(invoiceNo);
        // return

        callPostPayload()
    }

    function storeUserInfo() {
        let roleName = document.querySelector("#formUser #roleName").value;

        if (roleName === '') {
            $('#roleNameError').html('Role is required');
            return;
        }
        let contactNoGiven = false;
        let name = document.querySelector("#formUser #name").value;
        let phoneNumber = document.querySelector("#formUser #phoneNumber").value;
        let email = document.querySelector("#formUser #email").value;
        let api_path = "{{ env('API_RESOURCE_URL') }}";
        let thisUserInfo = {
            "roleName": roleName,
            "name": name,
            "phoneNumber": phoneNumber,
            "email": email,
        };
        var errorStr = '<ul>'
        var isError = false;
        if (roleName == '') {
            isError = true
            errorStr += `<li>Select a Rolet</li>`
        }
        if (name == '') {

            isError = true
            errorStr += `<li>Name is required</li>`
        }
        if (phoneNumber == '') {
            isError = true
            errorStr += `<li>Mobile No is required</li>`
        } else if (phoneNumber.length != 10) {
            isError = true
            errorStr += `<li>Mobile No is not valid</li>`
        } else {
            contactNoGiven = true
        }

        if (email !== '') {
            //check email format
            var emailReg = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
            if (!emailReg.test(String(email).toLowerCase())) {

                isError = true
                errorStr += `<li>Please enter valid email</li>`
            }
        }
        if (!contactNoGiven) {
            errorStr += `</ul>`
            if (isError) {
                toastr.error(errorStr)
                return
            }
        } else {
            // let check_url = `${api_path}Auth/ContactNoExistCheck/${phoneNumber}`
            let check_url =
                `https://dev-def-pumps-api.inspirigenceworks.co.in/api/Auth/ContactNoExistCheck/${phoneNumber}`
            let fetchRes = fetch(check_url);
            fetchRes.then(res =>
                res.json()).then(d => {
                if (d) {
                    console.log(d);
                    isError = true
                    errorStr += `<li>Mobile No already exists</li>`
                    errorStr += `</ul>`
                    if (isError) {
                        toastr.error(errorStr)
                        return
                    }
                } else {
                    if (localStorage.getItem("userInfo") == null) {
                        const userInfo = []
                        userInfo.push(thisUserInfo)
                        localStorage.setItem("userInfo", JSON.stringify(userInfo))
                    } else {
                        const userInfo = JSON.parse(localStorage.getItem("userInfo"))
                        const existingUser = userInfo.filter(user => user.phoneNumber == phoneNumber)
                        if (existingUser.length > 0) {

                            //Delete AND Push as new
                            const exceptionUsers = userInfo.filter(user => user.phoneNumber !== phoneNumber)
                            exceptionUsers.push(thisUserInfo)
                            localStorage.setItem("userInfo", JSON.stringify(exceptionUsers))
                            return
                        }
                        userInfo.push(thisUserInfo)
                        localStorage.setItem("userInfo", JSON.stringify(userInfo))

                    }
                    populateUserList()
                }
            })
        }
    }

    function phoneNumberExist(phoneNumber) {
        let url = `{{ env('API_RESOURCE_URL') }}Auth/ContactNoExistCheck/${phoneNumber}`
        //console.log(url)
        let fetchRes = fetch(url);
        // fetchRes is the promise to resolve
        // it by using.then() method
        var result
        fetchRes.then(res =>
            res.json()).then(d => {
            console.log(d)
            result = d
        })
        return result
    }

    function phoneNumberExistOrNot(phoneNumber) {
        let url = `{{ route('companyadmin.wizard.check_user_contactNo', ':no') }}`
        url = url.replace(':no', phoneNumber)
        console.log(url);
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                console.log(data.status);
                return data.status
            },
            error: function(xhr, status, error) {
                return false
            }
        });



    }

    function storeUserIntoOffice(el) {
        console.log(el.innerHTML);
        el.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
        el.classList.add("pe-none")
        // return
        stepComplete()

    }

    function callPostPayload() {
        let officeInfo = JSON.parse(localStorage.getItem("officeInfo"))
        let godownInfo = JSON.parse(localStorage.getItem("godownInfo"))
        let productInfo = JSON.parse(localStorage.getItem("productInfo"))
        let stockInfo = JSON.parse(localStorage.getItem("stockInfo"))
        let userInfo = JSON.parse(localStorage.getItem("userInfo"))
        let payloadInfo = JSON.parse(localStorage.getItem("payloadInfo"))
        let step = localStorage.getItem('step')



        const payload = {
            step: step,
            officeInfo: officeInfo,
            godownInfo: godownInfo,
            productInfo: productInfo,
            stockInfo: stockInfo,
            userInfo: userInfo
        }
        let encoded_payloaded = btoa(JSON.stringify(payload))

        var formData = new FormData($('#formPayload')[0])

        formData.append('payload', encoded_payloaded);
        formData.append('step', step);
        var submit_url = "{{ route($routeRole . '.wizard.store_payload') }}";

        $.ajax({
            type: "POST",
            url: submit_url,
            data: formData,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {
            console.log(data);
            if (!data.status) {
                // toastr.error(data.message);
            } else {
                // toastr.success(data.message);
                // if (step == 'complete'){

                // }
                if (data.step == 'office' || data.step == 'create_office') {
                    stepGodown()
                }
                if (data.step == 'godown') {
                    stepProduct()
                }
                if (data.step == 'product') {
                    stepInvoice()
                }
                if (data.step == 'invoice') {
                    stepUser()
                }
                if (data.step === 'deleted') {
                    localStorage.removeItem("step")
                    localStorage.removeItem("officeInfo")
                    localStorage.removeItem("godownInfo")
                    localStorage.removeItem("productInfo")
                    localStorage.removeItem("stockInfo")
                    localStorage.removeItem("userInfo")
                    // document.querySelector('.btn_sales').classList.removeClass('d-none')

                    document.querySelector('.complete-deleted-success').classList.remove('d-none')
                    document.querySelector('.shadow-anim').classList.add('d-none')
                    document.querySelector('.wizard-box').classList.add('border-box-none')
                    document.querySelectorAll('.progress-step').forEach(((element) => {
                        element.classList.add('pe-none')
                    }))
                    SalesOfficeId = data.officeId
                }
                //  return;
                //  setTimeout(() => {
                //                 }, 1000);
            }

        }).fail(function(data) {
            toastr.error(data.message);
        });
        return;
        // console.log(encoded_payloaded);
        // console.log(atob(encoded_payloaded));
        // console.log(JSON.parse(atob(encoded_payloaded)));
    }



    function LoadSales(id) {
        if (wizardOfficeId == '') {
            wizardOfficeId = id
        }
        if (wizardOfficeId == '') {
            toastr.error("Office Initialize failed")
            return
        }

        let url = "{{ route('companyadmin.sales.index_create', [':id']) }}";
        url = url.replace(':id', wizardOfficeId);
        location.replace(url);

    }

    function ajaxGet(url, section_modal) {
        $.ajax({
            url: url,
            method: "GET",
            success: function(response) {

                if (response.status) {

                    $(`#${section_modal}`).html(response.html);

                    loadStepData(section_modal)
                }
                // toastr.error('something went wrong');
                //return;

            }
        });
    }

    function handleClickGetStarted(el) {

        el.innerHTML =
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ${el.innerHTML}`
        el.classList.add("pe-none")
        stepOffice()
    }

    function handleClickStoreOffice(el) {
        el.innerHTML =
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ${el.innerHTML}`
        el.classList.add("pe-none")
        storeOffice()
    }

    function handleClickStoreGodown(el) {
        el.innerHTML =
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ${el.innerHTML}`
        el.classList.add("pe-none")
        storeGodownIntoOffice()
    }

    function handleClickStoreProduct(el) {
        el.innerHTML =
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ${el.innerHTML}`
        el.classList.add("pe-none")
        storeProductIntoOffice()
    }

    function handleClickStoreInvoice(el) {
        el.innerHTML =
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ${el.innerHTML}`
        el.classList.add("pe-none")
        storeInvoiceNoIntoOffice()
    }

    function loadStepData(section_modal) {
        // console.log("one continue" + step);

        // step = localStorage.getItem('step')
        if (['modal', 'welcome'].includes(step)) {
            stepCount.innerHTML = ""
            const getStartedBtn = document.querySelector('.get-started')
            getStartedBtn.style = "opacity:1"
            getStartedBtn.innerHTML = getStartedBtntext
            welcomeInfo()
        } else if (['office', 'create_office'].includes(step)) {
            stepCount.innerHTML = "1/"
            $('.modal_section').addClass('d-none');
            $('#stepOffice').removeClass('d-none');



            $('#step-office').addClass('progress-step-active');
            $('#step-godown').removeClass('progress-step-active');
            $('#step-product').removeClass('progress-step-active');
            $('#step-invoice').removeClass('progress-step-active');
            $('#step-user').removeClass('progress-step-active');

            $('#step-office').addClass('current-step');

            step = "create_office"
            localStorage.setItem("step", step);
            // $('#spinner').addClass('d-none')
            let officeData = JSON.parse(localStorage.getItem('officeInfo'));


            if (officeData) {
                console.log("Loading Step Data")
                $("#officeName").val(officeData.officeName)
                $("#officeTypeId").val(officeData.officeTypeId)
                $("#officeEmail").val(officeData.officeEmail)
                $("#officeContactNo").val(officeData.officeContactNo)
                $("#gstTypeId").val(officeData.gstTypeId)
                $("#gstNumber").val(officeData.gstNumber)
                $("#masterOfficeId").val(officeData.masterOfficeId)
                $("#officeAddress").val(officeData.officeAddress)
                $("#registeredAddress").val(officeData.registeredAddress)
                $("#latitude").val(officeData.latitude)
                $("#longitude").val(officeData.longitude)
            }
            var btnOfficeStore = document.querySelector('.btn-office-store')
            btnOfficeStore.innerHTML = saveBtntext
            btnOfficeStore.classList.remove("pe-none")
        } else if (['godown'].includes(step)) {
            stepCount.innerHTML = "2/"
            $('.modal_section').addClass('d-none');
            $('#stepGodown').removeClass('d-none');
            $('#step-office').addClass('progress-step-active');
            $('#step-godown').addClass('progress-step-active');
            $('#step-product').removeClass('progress-step-active');
            $('#step-invoice').removeClass('progress-step-active');
            $('#step-user').removeClass('progress-step-active');
            $('#step-godown').addClass('current-step');

            $(`#${section_modal}`).removeClass('d-none'); //
            officeInfo()
            var btnGodownStore = document.querySelector('.btn-godown-store')
            btnGodownStore.innerHTML = saveBtntext
            btnGodownStore.classList.remove("pe-none")
        } else if (['product'].includes(step)) {
            stepCount.innerHTML = "3/"
            $('.modal_section').addClass('d-none');
            $('#stepProduct').removeClass('d-none');
            $('#step-office').addClass('progress-step-active');
            $('#step-godown').addClass('progress-step-active');
            $('#step-product').addClass('progress-step-active');
            $('#step-invoice').removeClass('progress-step-active');
            $('#step-user').removeClass('progress-step-active');
            $('#step-product').addClass('current-step');

            $(`#${section_modal}`).removeClass('d-none'); //
            officeInfo()
            var btnProductStore = document.querySelector('.btn-product-store')
            btnProductStore.innerHTML = saveBtntext
            btnProductStore.classList.remove("pe-none")
        } else if (['invoice'].includes(step)) {
            stepCount.innerHTML = "4/"
            $('#step-office').addClass('progress-step-active');
            $('#step-godown').addClass('progress-step-active');
            $('#step-product').addClass('progress-step-active');
            $('#step-invoice').addClass('progress-step-active');
            $('#step-user').removeClass('progress-step-active');
            $('.progress-step').removeClass('current-step');
            $('#step-invoice').addClass('current-step');

            $('.modal_section').addClass('d-none')
            $(`#stepInvoice`).removeClass('d-none');
            let officeData = JSON.parse(localStorage.getItem('officeInfo'));

            if (officeData.invoiceNo !== null) {

                $("#stepInvoice #invoiceNo").val(officeData.invoiceNo)
                $("#stepInvoice #fiscalYearId").val(officeData.fiscalYearId)

                officeInfo()
            }
            var btnInvoiceStore = document.querySelector('.btn-invoice-store')
            btnInvoiceStore.innerHTML = saveBtntext
            btnInvoiceStore.classList.remove("pe-none")
        } else if (['user'].includes(step)) {
            stepCount.innerHTML = "5/"
            $('.modal_section').addClass('d-none');
            $('#stepUser').removeClass('d-none');
            $('#step-office').addClass('progress-step-active');
            $('#step-godown').addClass('progress-step-active');
            $('#step-product').addClass('progress-step-active');
            $('#step-invoice').addClass('progress-step-active');
            $('#step-user').addClass('progress-step-active');
            $('.progress-step').removeClass('current-step');
            $('#step-user').addClass('current-step');
            // $('#spinner').addClass('d-none')
            $(`#${section_modal}`).removeClass('d-none');
            officeInfo()
            var btnUserStore = document.querySelector('.btn-user-store')
            btnUserStore.innerHTML = saveBtntext
            btnUserStore.classList.remove("pe-none")
        } else if (['complete'].includes(step)) {
            stepCount.innerHTML = " "
            $('.modal_section').addClass('d-none');
            $('#stepComplete').removeClass('d-none');
            $('#step-office').addClass('progress-step-active');
            $('#step-godown').addClass('progress-step-active');
            $('#step-product').addClass('progress-step-active');
            $('#step-invoice').addClass('progress-step-active');
            $('#step-user').addClass('progress-step-active');
            $('.progress-step').removeClass('current-step');
            // $('#step-user').addClass('current-step');
            // $('#spinner').addClass('d-none')
            $(`#${section_modal}`).removeClass('d-none');
            officeInfo()
            callPostPayload()


        } else {

            officeInfo()
            // console.log("OUTSIDE: Loading Step Data", step)
        }
    }

    function countchar(sender, component, max) {

        //console.log(sender);

        var len = $(sender).val().length;
        if (len >= max) {
            $('#' + component + '-count-char').text(len + '/' + max);
            $('#' + component + '-count-char').css('color', '#0689bd');
        } else {
            var ch = max - len;
            $('#' + component + '-count-char').text(len + '/' + max);
            $('#' + component + '-count-char').css('color', ' #0689bd');
        }

    }

    function makeFirstSale() {
        var route = `{{ route('companyadmin.sales.index_create', ':id') }}`
        route = route.replace(':id', SalesOfficeId)
        window.location.href = route;
    }
</script>
