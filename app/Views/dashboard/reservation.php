<?= $this->extend('dashboard/layouts/main'); ?>
<?= $this->section('head') ?>
<style>
    .gold {
        font-size: 5vw;
        text-transform: uppercase;
        line-height: 1;
        text-align: center;
        background: linear-gradient(90deg, rgba(186, 148, 62, 1) 0%, rgba(236, 172, 32, 1) 20%, rgba(186, 148, 62, 1) 39%, rgba(249, 244, 180, 1) 50%, rgba(186, 148, 62, 1) 60%, rgba(236, 172, 32, 1) 80%, rgba(186, 148, 62, 1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shine 3s infinite;
        background-size: 200%;
        background-position: left;

    }

    @keyframes shine {
        to {
            background-position: right
        }

    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<!-- Modal  -->
<div class="modal fade text-left" id="reservationModal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
            </div>
            <div class="modal-footer" id="modalFooter">
            </div>
        </div>
    </div>
</div>
<section class="section">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">List reservation</li>
            </ol>
        </nav>
        <!-- DataTbales  -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary text-center">List reservation Package</h5>
                <a class="btn btn-success" onclick="showReservationModal()" data-bs-toggle="modal" data-bs-target="#reservationModal"> add <i class="fa fa-plus"></i> </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-border" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <?php $no = 1; ?>
                            <tr>
                                <th>No</th>
                                <th>Request Package Name</th>
                                <th>Username</th>
                                <th>Request date</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $reservation) : ?>
                                <?php
                                $reservationId = $reservation['id'];
                                $packageName = $reservation['package_name'];
                                $username = $reservation['username'];
                                $requestDate = $reservation['request_date'];
                                $reservationIdStatus = $reservation['id_reservation_status'];
                                $reservationStatus = $reservation['status'];
                                $dateNow = date("Y-m-d");
                                $depositDate = $reservation['deposit_date'];
                                $paymentDate = $reservation['payment_accepted_date'];
                                $refundDate = $reservation['refund_date'];


                                $proggres = "";
                                if ($reservationIdStatus == 1) {
                                    $proggres = "Check Reservation!";
                                } else if ($reservationIdStatus == 2 && $depositDate == null) {
                                    $proggres = "Waiting payment document";
                                } else if ($reservationIdStatus == 2 && $depositDate != null) {
                                    $proggres = "Check Payment!";
                                } else if ($reservationIdStatus == 3 && $paymentDate == null &&  $refundDate == null) {
                                    $proggres = "Canceled";
                                } else if ($reservationIdStatus == 3 && $paymentDate != null &&  $refundDate == null) {
                                    $proggres = "Canceled, refund user money!";
                                } else if ($reservationIdStatus == 3 && $paymentDate != null &&  $refundDate != null) {
                                    $proggres = "Canceled, money returned";
                                } else if ($reservationIdStatus == 4) {
                                    $proggres = "Transaction Success";
                                }
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $packageName; ?></td>
                                    <td><?= $username; ?></td>
                                    <td>
                                        <?= $requestDate; ?>
                                    </td>
                                    <td>
                                        <span class="<?php if ($reservationIdStatus == "1") {
                                                            echo "badge bg-warning";
                                                        } elseif ($reservationIdStatus == "2") {
                                                            echo "badge bg-primary";
                                                        } else if ($reservationIdStatus == "4") {
                                                            echo "badge bg-success";
                                                        } else {
                                                            echo "badge bg-danger";
                                                        } ?>"> <?= $reservationStatus; ?></span>
                                    </td>
                                    <td>
                                        <?= $proggres; ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-outline-success btn-sm " title="confirm" data-bs-toggle="modal" data-bs-target="#reservationModal" onclick="showInfoReservation('<?= $reservationId ?>')">
                                            <i class="fa fa-info"></i>
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--container-fluid -->
</section>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="<?= base_url('assets/js/extensions/form-element-select.js'); ?>"></script>
<script>
    new DataTable("#dataTable")
    let photo, pond, galleryValue

    function showInfoReservation(id) {
        let statusData = JSON.parse('<?= json_encode($statusData) ?>')
        let result
        let reservationStatus, reservationInfo
        $.ajax({
            url: `<?= base_url('api'); ?>/reservation/${id}`,
            type: "GET",
            async: false,
            contentType: "application/json",
            success: function(response) {
                result = JSON.parse(response)

            },
            error: function(err) {
                console.log(err.responseText)
            }
        });

        console.log(result)
        reservationStatus = result['id_reservation_status']
        if (reservationStatus == '1' && result['item_costum'] == '1') {
            console.log("masuk sinikahhh")
            reservationInfo =
                `<a class ="btn btn-outline-danger m-1" onclick="cancelReservation('${id}')"> Cancel  </a>
               <a class ="btn btn-outline-success m-1" onclick="confirmCostumReservation('${id}')"> Confirm</a>
               <a class ="btn btn-outline-primary m-1" onclick="previewPackage('${result['id_package']}')"> preview</a>`
            reservationPrice = '<input class="form-input" title="input the costume package price" id="inputPriceReservation" type="number"></input>'
        } else if (reservationStatus == '1') {
            reservationInfo =
                `<a class ="btn btn-outline-danger m-1" onclick="cancelReservation('${id}')"> Cancel  </a>
               <a class ="btn btn-outline-success m-1" onclick="confirmReservation('${id}')"> Confirm</a>`
            reservationPrice = rupiah(result['total_price'])

        } else {
            reservationInfo = ''
            reservationPrice = rupiah(result['total_price'])
        }


        $('#modalTitle').html("Reservation Info")
        if (result['id_package'] != null) {
            $('#modalBody').html(`
        <div class="p-2">
               
                <div id="userRating">
    
                </div>
                <div id="userTicket">
                
                </div>
                <div id="userRefund">
    
                </div>
                <div  id="userPayment">
    
                </div>
                <div class="mb-2 shadow-sm p-4 rounded">
                    <p class="text-center fw-bold text-dark"> Reservation Information </p>
                    <table class="table table-borderless text-dark ">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Request By</td>
                                <td>${result['username']}</td>
                            </tr>
                            
                            <tr>
                                <td class="fw-bold">Request Package </td>
                                <td>${result['item_name']}</td>
                            </tr>
                                                
                            <tr>
                                <td class="fw-bold">Request Date</td>
                                <td>${result['request_date']}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total people</td>
                                <td>${result['number_people']}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Costum package</td>
                                <td class="${result['item_costum'] == '1' ? 'badge bg-success' : ''}">${result['item_costum'] == '1' ? 'yes' : 'no'}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Additional Information</td>
                                <td>${result['comment']!= null ? result['comment'] : '-'}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Price </td>
                                <td >${reservationPrice}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold"> </td>
                                <td>${reservationInfo}</td>
                            </tr>           
                        </tbody>
                    </table>
                </div> 
                <div id="previewMap">
                   
                </div>   
                <div class="shadow-sm p-4 rounded">
                     <p class="text-center fw-bold text-dark"> Reservation Status </p>
                     <fieldset class="form-group mb-4">
                        <label for="statusReservation" class="mb-2"> Status reservation </label>
                        <select class="form-select" id="statusReservation" required>
                                
                      </fieldset>
                </div>
            </div>
        `)
        } else if (result['id_homestay'] != null) {
            $('#modalBody').html(`
            <div class="p-2">
                    <div id="userRating">
        
                    </div>
                    <div  id="userPayment">
        
                    </div>
                    <div class="mb-2 shadow-sm p-4 rounded">
                        <p class="text-center fw-bold text-dark"> Reservation Information </p>
                        <table class="table table-borderless text-dark ">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Request By</td>
                                    <td>${result['username']}</td>
                                </tr>
                                
                                <tr>
                                    <td class="fw-bold">Request Package </td>
                                    <td>${result['item_name']}</td>
                                </tr>
                                                    
                                <tr>
                                    <td class="fw-bold">Request Date</td>
                                    <td>${result['request_date']}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total people</td>
                                    <td>${result['number_people']}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Costum package</td>
                                    <td class="${result['package_costum'] == '1' ? 'badge bg-success' : ''}">${result['package_costum'] == '2' ? 'no' : 'yes'}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Additional Information</td>
                                    <td>${result['comment']!= null ? result['comment'] : '-'}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Price </td>
                                    <td >${rupiah(result['total_price'])}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold"> </td>
                                    <td>${reservationInfo}</td>
                                </tr>           
                            </tbody>
                        </table>
                    </div>    
                    <div class="shadow-sm p-4 rounded">
                        <p class="text-center fw-bold text-dark"> Reservation Status </p>
                        <fieldset class="form-group mb-4">
                            <label for="statusReservation" class="mb-2"> Status reservation </label>
                            <select class="form-select" id="statusReservation" required>
                                    
                        </fieldset>
                    </div>
                </div>
            `)
        }


        // button status
        $("#statusReservation").html(`<option value="${result['id_reservation_status']}"> ${result['status']} ( current status )</option>`)
        for (i in statusData) {
            if (statusData[i].id != result['id_reservation_status']) {
                $("#statusReservation").append(`
                <option  value="${statusData[i].id}">  ${statusData[i].status} </option>
                `)
            }
        }
        $("#statusReservation").on("change", function() {
            let statusReservation = $("#statusReservation").val()
            changeReservationStatus(id, statusReservation)

        })

        // user payment
        if (reservationStatus == 2 && result['proof_of_deposit'] != null) {
            let depositDate = result['deposit_date']
            let deposit = result['deposit']
            let proofDeposit = result['proof_of_deposit']

            $("#userPayment").addClass("mb-2 shadow-sm p-4 rounded")
            $("#userPayment").html(`
                <p class="text-center fw-bold text-dark"> Payment Information </p>
                <p> Deposit on : ${depositDate} </p>
                <p> Deposit : ${rupiah(deposit)} </p>
                <div class="mb-2">
                    <img class="img-fluid img-thumbnail rounded" src="${baseUrl + '/media/photos/reservation/' + proofDeposit }" width="100%">
                </div>
               
            `)

            if (result['id_reservation_status'] == '4') {
                $("#userPayment").append(`
                <div class="text-end">
                <span class="badge bg-success"> paid </span>
                </div>
                `)
            } else {
                $("#userPayment").append(`
                <div class="text-end">
                <a class="btn btn-success" onclick="acceptReservation('${id}')"> Accept payment</a>
                </div>
                `)
            }
        }
        // refund
        if (reservationStatus == 3 && result['proof_of_deposit'] != null) {
            let deposit = result['deposit']
            let proofRefund = result['proof_of_refund']
            $("#userRefund").addClass("mb-2 shadow-sm p-4 rounded")
            $("#userRefund").html(`<a class="btn btn-outline-primary" onclick="addRefundBody('${id}','${deposit}','${proofRefund}')">Refund</a>`)

        }

        // user rating
        if (reservationStatus == 5 && result['rating'] != null) {
            let rating = result['rating']
            let updatedRating = result['updated_at']
            let review = result['review'] != null ? result['review'] : ''
            console.log(result['rating'])
            $("#userRating").addClass("mb-2 shadow-sm p-4 rounded")
            $("#userRating").html(`
                <p class="text-center fw-bold text-dark"> Rated And Reviewed </p>
                <p> Rated on : ${updatedRating} </p>
                <div class="star-containter mb-3 text-start">
                <i class="fa-solid fa-star fs-10" id="star-1" ></i>
                <i class="fa-solid fa-star fs-10" id="star-2" ></i>
                <i class="fa-solid fa-star fs-10" id="star-3" ></i>
                <i class="fa-solid fa-star fs-10" id="star-4" ></i>
                <i class="fa-solid fa-star fs-10" id="star-5" ></i>
                </div>
                <p> ${review} </p>
            `)
            setStar(rating)
        }
        $('#modalFooter').html(``)
    }
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(number);
    }

    function setStar(star) {
        $("#star-rating").val(star)
        switch (star) {
            case '1':
                $("#star-1").addClass('star-checked')
                $("#star-2,#star-3,#star-4,#star-5").removeClass('star-checked')
                break
            case '2':
                $("#star-1,#star-2").addClass('star-checked')
                $("#star-3,#star-4,#star-5").removeClass('star-checked')
                break
            case '3':
                $("#star-1,#star-2,#star-3").addClass('star-checked')
                $("#star-4,#star-5").removeClass('star-checked')
                break
            case '4':
                $("#star-1,#star-2,#star-3,#star-4").addClass('star-checked')
                $("#star-5").removeClass('star-checked')
                break
            case '5':
                $("#star-1,#star-2,#star-3,#star-4,#star-5").addClass('star-checked')
                break
        }
    }

    function addRefundBody(id, deposit, proofRefund) {
        let userDeposit = parseInt(deposit)
        let refund = userDeposit / 2
        $(`#userRefund`).html(`<a class="btn btn-outline-primary" onclick="cancelRefundBody('${id}','${userDeposit}','${proofRefund}')">Cancel refund</a>`)
        $(`#userRefund`).append(`
                <p class="text-center fw-bold text-dark"> Upload Your Refund </p>
                <p ></p>
                <p>Note <br><span class="text-danger">*</span> Make sure you refund total : (50% *${userDeposit}) <br><span class="text-danger">*</span> Total refund:<span class="text-primary">${rupiah(refund)} </span></p>
                <div class="form-group mb-4">
                    <label for="gallery" class="form-label"> Upload Proof of Refund <span class="text-danger">*</span></label>
                    <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery">
                </div>
                <div class="text-end">
                    <a class="btn btn-success" onclick="saveRefund('${id}')" > Refund</a>
                </div>
           
        `)
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImageExifOrientation,
            FilePondPluginImagePreview,
            FilePondPluginImageResize,
            FilePondPluginMediaPreview,
        );
        // Get a reference to the file input element
        photo = document.querySelector('input[id="gallery"]');

        // Create a FilePond instance
        pond = FilePond.create(photo, {
            maxFileSize: '1920MB',
            maxTotalFileSize: '1920MB',
            imageResizeTargetHeight: 720,
            imageResizeUpscale: false,
            credits: false,
        });
        console.log(typeof proofRefund)
        if (proofRefund != "null") {
            console.log("masuk")
            pond.addFiles(
                `<?= base_url('media/photos/refund') ?>/${proofRefund}`
            );
        }
        pond.setOptions({
            server: {
                timeout: 3600000,
                process: {
                    url: '<?= base_url("upload/photo") ?>',
                    onload: (response) => {
                        galleryValue = response
                        console.log("processed:", response);
                        return response
                    },
                    onerror: (response) => {
                        console.log("error:", response);
                        return response
                    },
                },
                revert: {
                    url: '<?= base_url("upload/photo") ?>',
                    onload: (response) => {
                        console.log("reverted:", response);
                        return response
                    },
                    onerror: (response) => {
                        console.log("error:", response);
                        return response
                    },
                },
            }
        })
    }

    function cancelRefundBody(id, deposit, proofRefund) {
        let userDeposit = parseInt(deposit)
        $(`#userRefund`).html(`<a class="btn btn-outline-primary" onclick="addRefundBody('${id}','${deposit}','${proofRefund}')">Add refund</a>`)
    }

    function saveRefund(id_user, id_package, request_date) {
        let proofRefund = galleryValue
        if (proofRefund == null) {
            Swal.fire(
                'Please input the proof of refund',
                '',
                'warning'
            )
        } else {
            let requestData = {
                refund_by: '<?= user()->id ?>',
                proof_of_refund: proofRefund
            }
            $.ajax({
                url: `<?= base_url('api'); ?>/reservation/${id}`,
                type: "PUT",
                data: requestData,
                async: false,
                contentType: "application/json",
                success: function(response) {
                    Swal.fire(
                        'Booking updated',
                        '',
                        'success'
                    ).then(() => {
                        window.location.reload()
                    });
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            });
        }

    }



    function previewPackage(id_package) {
        console.log(id_package)
        $("#previewMap").html(`
        <div class="card-body">
            <div id="buttonDay" class="mb-1">
            </div>
            <div class="googlemaps" id="googlemaps" style="min-height: 60vh;">
            </div>
        </div>`)
        initMap()
        let result
        $.ajax({
            url: `<?= base_url('api/package'); ?>/${id_package}`,
            type: "GET",
            async: false,
            contentType: "application/json",
            success: function(response) {
                console.log("runing")
                result = JSON.parse(response)
            },
            error: function(err) {
                console.log("failed")
                console.log(err.responseText)
            }
        });
        console.log(result.package_day)
        let buttonDay = ''

        let no = 1
        result.package_day.forEach(element => {
            buttonDay += `<a class="btn btn-outline-primary btn-sm" onclick="getObjectsByPackageDayId('${element.day}')">Day ${no}</a>`
            no++
        });
        $("#buttonDay").html(buttonDay)

        // getObjectsByPackageDayId('')

    }
    // Star map
    let latBefore = ''
    let lngBefore = ''


    function getObjectsByPackageDayId(id_day) {
        $.ajax({
            url: `<?= base_url('api'); ?>/objects/package_day/${id_day}`,
            type: "GET",
            async: false,
            contentType: "application/json",
            success: function(response) {
                let objects = response['data']
                getObjectById(objects)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        });
    }

    function getObjectById(objects = null) {
        let objectNumber = 1
        let flightPlanCoordinates = []
        clearMarker()
        clearRadius()
        clearRoute()
        objects.forEach(object => {
            let id_object = object['id_object']

            let URI = "<?= base_url('api') ?>";

            if (id_object.charAt(0) == 'R') {
                URI = URI + '/rumahGadang/' + `${id_object}`
            } else if (id_object.charAt(0) == 'E') {
                URI = URI + '/event/' + `${id_object}`
            } else if (id_object.charAt(0) == 'C') {
                URI = URI + '/culinaryPlace/' + `${id_object}`
            } else if (id_object.charAt(0) == 'W') {
                URI = URI + '/worshipPlace/' + `${id_object}`
            } else if (id_object.charAt(0) == 'S') {
                URI = URI + '/souvenirPlace/' + `${id_object}`
            } else if (id_object.charAt(0) == 'A') {
                URI = URI + '/atraction/' + `${id_object}`
            }


            currentUrl = '';
            $.ajax({
                url: URI,
                type: "GET",
                async: false,
                dataType: 'json',
                success: function(response) {
                    let data = response.data
                    currentUrl = currentUrl + data.id
                    // flightPlanCoordinates.push(new google.maps.LatLng(data.lat, data.lng))
                    showObjectOnMap(objectNumber, data.id, data.lat, data.lng)
                    boundToObject()

                }
            })
            objectNumber++
        })
        // flightPath(flightPlanCoordinates)
    }


    // Display marker for loaded object
    function showObjectOnMap(objectNumber, id, lat, lng, anim = true) {

        google.maps.event.clearListeners(map, 'click');
        let pos = new google.maps.LatLng(lat, lng);
        let marker = new google.maps.Marker();
        let icon = `https://raw.githubusercontent.com/Concept211/Google-Maps-Markers/master/images/marker_red${objectNumber}.png`;

        markerOption = {
            position: pos,
            icon: icon,
            animation: google.maps.Animation.DROP,
            map: map,
        }
        marker.setOptions(markerOption);
        if (!anim) {
            marker.setAnimation(null);
        }
        marker.addListener('click', () => {
            infoWindow.close();
            objectInfoWindow(id);
            infoWindow.open(map, marker);
        });
        markerArray[id] = marker;
        if (objectNumber == 1) {
            latBefore = lat
            lngBefore = lng
        } else {
            routeAll(lat, lng)
        }
    }

    function routeAll(lat, lng) {
        google.maps.event.clearListeners(map, 'click')

        let start, end;
        start = new google.maps.LatLng(latBefore, lngBefore);
        end = new google.maps.LatLng(lat, lng)
        let request = {
            origin: start,
            destination: end,
            travelMode: 'DRIVING'
        };
        directionsService.route(request, function(result, status) {
            if (status == 'OK') {
                directionsRenderer = new google.maps.DirectionsRenderer({
                    suppressMarkers: true
                })
                directionsRenderer.setDirections(result);
                // showSteps(result);
                directionsRenderer.setMap(map);
                routeArray.push(directionsRenderer);
            }
        });
        boundToRoute(start, end);
    }

    // End map

    function cancelReservation(id) {
        let requestData = {
            id_reservation_status: 3,
            canceled_at: "true",
            canceled_by: '<?= user()->id ?>'
        }

        $.ajax({
            url: `<?= base_url('api'); ?>/reservation/${id}`,
            type: "PUT",
            data: requestData,
            async: false,
            contentType: "application/json",
            success: function(response) {
                Swal.fire(
                    'Booking canceled',
                    '',
                    'success'
                ).then(() => {
                    window.location.reload()
                });
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })

    }

    function confirmReservation(id) {

        let requestData = {
            id_reservation_status: 2,
            confirmed_at: "true",
            confirmed_by: '<?= user()->id ?>'
        }

        $.ajax({
            url: `<?= base_url('api'); ?>/reservation/${id}`,
            type: "PUT",
            data: requestData,
            async: false,
            contentType: "application/json",
            success: function(response) {
                Swal.fire(
                    'Booking confirmed',
                    '',
                    'success'
                ).then(() => {
                    window.location.reload()
                });
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })

    }


    function confirmCostumReservation(id) {
        // check if it costum package or not
        let inputPriceCostum = $("#inputPriceReservation").val()
        if (!inputPriceCostum) {
            return swal.fire("please input the price")
        }

        let requestData = {
            id_reservation_status: 2,
            confirmed_at: "true",
            confirmed_by: '<?= user()->id ?>',
            total_price: inputPriceCostum
        }

        $.ajax({
            url: `<?= base_url('api'); ?>/reservation/${id}`,
            type: "PUT",
            data: requestData,
            async: false,
            contentType: "application/json",
            success: function(response) {
                Swal.fire(
                    'Booking confirmed',
                    '',
                    'success'
                ).then(() => {
                    window.location.reload()
                });
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })

    }

    function acceptReservation(id) {
        let requestData = {
            id_reservation_status: 4,
            payment_accepted_date: "true",
            payment_accepted_by: '<?= user()->id ?>'
        }

        $.ajax({
            url: `<?= base_url('api'); ?>/reservation/${id}`,
            type: "PUT",
            data: requestData,
            async: false,
            contentType: "application/json",
            success: function(response) {
                Swal.fire(
                    'Reservation accepted',
                    '',
                    'success'
                ).then(() => {
                    window.location.reload()
                });
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })

    }

    function changeReservationStatus(id, status, paymentDate = null) {

        let requestData = {
            id_reservation_status: status, //status
            payment_date: paymentDate
        }

        $.ajax({
            url: `<?= base_url('api'); ?>/reservation/${id}`,
            type: "PUT",
            data: requestData,
            async: false,
            contentType: "application/json",
            success: function(response) {
                Swal.fire(
                    'Reservation updated',
                    '',
                    'success'
                ).then(() => {
                    window.location.replace(baseUrl + '/dashboard/reservation/')
                });
            },
            error: function(err) {
                console.log(err.responseText)
            }
        });
    }
</script>
<script>
    function showReservationModal() {
        <?php if (in_groups('admin')) : ?>
            $('#modalTitle').html("Reservation")
            $('#modalBody').html(`
            <label for="id_user" class="mb-2">User</label>
                    <select class="form-select" id="id_user" required>
                                    <?php if ($userData) : ?>
                                        <?php $no = 0; ?>       
                                        <?php foreach ($userData as $user) : ?>
                                           
                                    <option value="<?= esc($user->id); ?>" <?= ($no == 0) ? 'selected' : ''; ?>>  <?= esc($user->username); ?></option>
                                        
                                            <?php $no++; ?>       
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="">User not found</option>
                                    <?php endif; ?>
                     </select>
            <label for="id_package" class="mb-2"> Package name </label>
                    <select class="form-select" id="id_package" required>
                        <?php if ($packageData) : ?>
                           <?php $no = 0; ?>       
                           <?php foreach ($packageData as $package) : ?>
                                           
                             <option value="<?= esc($package->id); ?>" <?= ($no == 0) ? 'selected' : ''; ?>>  <?= esc($package->name); ?></option>
                                
                           <?php $no++; ?>       
                           <?php endforeach; ?>
                        <?php else : ?>
                            <option value="">Package not found</option>
                        <?php endif; ?>
                     </select>
                        <?php if ($packageData) : ?>
                            <?php $no = 0; ?>       
                            <?php foreach ($packageData as $package) : ?>
                                <input type="hidden" value="<?= esc($package->capacity); ?>" id="capacity_of_package<?= esc($package->id); ?>" required >   
                             <?php $no++; ?>       
                            <?php endforeach; ?>
                        <?php endif ?>
            <div class="form-group mb-2">
                <label for="reservation_date" class="mb-2">Reservation date </label>
                <input type="date" id="reservation_date" class="form-control" required >
            </div>
            <div class="form-group mb-2">
                <label for="number_people" class="mb-2"> Number of people </label>
                <input type="number" id="number_people" class="form-control" required >
            </div>
            <div class="form-group mb-2">
                <label for="comment" class="mb-2"> Comment </label>
                <input type="text" id="comment" class="form-control"  >
            </div>
            <div class="form-group mb-2">
                <label for="status" class="mb-2"> Status reservation </label>
                <select class="form-select" id="status" required>
                            <?php if ($statusData) : ?>
                            <?php $no = 0; ?>       
                            <?php foreach ($statusData as $status) : ?>
                                            
                                <option value="<?= esc($status->id); ?>" <?= ($no == 1) ? 'selected' : ''; ?>>  <?= esc($status->status); ?></option>
                                    
                            <?php $no++; ?>       
                            <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">Package not found</option>
                            <?php endif; ?>
            </div>
            `)
            $('#modalFooter').html(`<a class="btn btn-success" onclick="makeReservation()"> Make reservation </a>`)
        <?php endif; ?>
    }

    function makeReservation() {
        let userId = $("#id_user").val()
        let packageId = $("#id_package").val()
        let status = $("#status").val()
        let capacityOfPackage = $(`#capacity_of_package${packageId}`).val()
        let reservationDate = $("#reservation_date").val()
        let numberPeople = $("#number_people").val()
        let comment = $("#comment").val()
        let numberCheckResult = checkNumberPeople(numberPeople, capacityOfPackage)
        let dateCheckResult = checkIsDateExpired(reservationDate)
        let sameDateCheckResult = "true"
        if (reservationDate) {
            sameDateCheckResult = checkIsDateDuplicate(userId, reservationDate)
        }

        if (!reservationDate) {
            Swal.fire('Please select reservation date', '', 'warning');
        } else if (numberPeople <= 0) {
            Swal.fire('Need 1 people at least', '', 'warning');
        } else if (numberCheckResult == false) {
            Swal.fire('Out of capacity, maksimal ' + `${capacityOfPackage}` + ' people', '', 'warning');
        } else if (dateCheckResult == false) {
            Swal.fire('Cannot Reserve, out of date, maksimal H-1 reservation', '', 'warning');
        } else if (sameDateCheckResult == "true") {
            Swal.fire('Already chose the same date! please select another date', '', 'warning');
        } else {
            <?php if (in_groups('admin')) : ?>
                let requestData = {
                    reservation_date: reservationDate,
                    id_user: userId,
                    id_package: packageId,
                    id_reservation_status: status, // pending status
                    number_people: numberPeople,
                    comment: comment
                }
                $.ajax({
                    url: `<?= base_url('web/reservation/create'); ?>`,
                    type: "POST",
                    data: requestData,
                    async: false,
                    contentType: "application/json",
                    success: function(response) {
                        Swal.fire(
                            'Success to make reservation request',
                            '',
                            'success'
                        ).then(() => {
                            window.location.replace(baseUrl + '/dashboard/reservation/')
                        });

                    },
                    error: function(err) {
                        console.log(err.responseText)
                    }
                });
            <?php endif; ?>
        }
    }

    function checkNumberPeople(numberPeople, capacityOfPackage) {
        let packageCapacity = parseInt(capacityOfPackage)
        let peopleNumberRequest = parseInt(numberPeople)

        if (peopleNumberRequest > packageCapacity) {
            return false
        } else {
            return true
        }
    }

    function checkIsDateExpired(reservation_date) {
        let result

        let today = new Date();
        let dd = String(today.getDate()).padStart(2, '0');
        let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        let yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        if (reservation_date > today) {
            result = true
        } else {
            result = false
        }
        return result
    }

    function checkIsDateDuplicate(user_id, reservation_date) {
        let result
        $.ajax({
            url: `<?= base_url('web') ?>/check/${user_id}/${reservation_date}`,
            type: "GET",
            async: false,
            success: function(response) {
                result = response
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
        return result
    }
</script>
<?= $this->endSection() ?>