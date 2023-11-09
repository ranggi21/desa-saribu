<?= $this->extend('profile/index'); ?>
<?= $this->section('styles') ?>
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/pages/form-element-select.css'); ?>">
<style>
    .filepond--root {
        width: 100%;
    }

    .background-effect {
        font-family: 'Bodoni Moda', serif;
        background-image: url('<?= base_url('media/photos/landing-page/ticket.jpg') ?>');
        background-size: cover;
        background-position-y: 20%;
    }

    .gold {
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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Reservation</h3>
            <span id="multipleButton">
                <!-- <a title="Print multiple reservation" class="btn btn-primary" onclick="openMultipleCheckOut()"> <i class="fa-solid fa-print"></i> Print in Group </a> -->
            </span>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-border" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-start"> #</th>
                            <th class="text-start"> Item name / ID </th>
                            <th class="text-start"> Reservation date </th>
                            <th class="text-start"> Number of people </th>
                            <th class="text-start"> Status </th>
                            <th class="text-start"> Progress </th>
                            <th class="text-center  checkSingle"> Action </th>
                            <th class="text-center  d-none checkAll"> Action</th>
                            <th class="text-center"> Rate / review </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php if ($data != null) : ?>

                            <?php foreach ($data as $item) : ?>
                                <?php
                                $reservationId = $item['id'];
                                $packageName = $item['package_name'];
                                $requestDate = $item['request_date'];
                                $numberPeople = $item['number_people'];
                                $reservationIdStatus = $item['id_reservation_status'];
                                $statusReservation = $item['status'];
                                $rating = $item['rating'];
                                $review = $item['review'];
                                $dateNow = date("Y-m-d");
                                $depositDate = $item['deposit_date'];

                                $proggres = "";
                                if ($reservationIdStatus == 1) {
                                    $proggres = "Please wait admin to confirm your reservation";
                                } else if ($reservationIdStatus == 2 && $depositDate == null) {
                                    $proggres = "Please upload your payment document";
                                } else if ($reservationIdStatus == 2 && $depositDate != null) {
                                    $proggres = "Document Uploaded! Please Wait admin to check your payment";
                                } else if ($reservationIdStatus == 3) {
                                    $proggres = "Sorry, your reservation is not accepted";
                                } else if ($reservationIdStatus == 4) {
                                    $proggres = "Transaction success, Print your ticket by <a class='btn btn-outline-success btn-sm ' title='confirm' data-bs-toggle='modal' data-bs-target='#reservationModal' onclick='showInfoReservation(`$reservationId`)'> click here </a>";
                                }

                                ?>
                                <tr>
                                    <td class="text-start"> <?= $no; ?> </td>
                                    <td class="text-start"> <?= $packageName; ?>/<?= $reservationId ?></td>
                                    <td class="text-start"> <?= $requestDate; ?> </td>
                                    <td class="text-start"> <?= $numberPeople; ?> </td>
                                    <td class="text-start">
                                        <span class="badge bg-<?php if ($reservationIdStatus == 1) {
                                                                    echo "warning";
                                                                } else if ($reservationIdStatus == 2) {
                                                                    echo "primary";
                                                                } else if ($reservationIdStatus == 3) {
                                                                    echo "danger";
                                                                } else if ($reservationIdStatus == 4) {
                                                                    echo "success";
                                                                }; ?>">
                                            <?= $statusReservation ?>
                                        </span>
                                    </td>
                                    <td class="text-start">
                                        <?= $proggres ?>
                                    </td>

                                    <td class="text-center checkSingle">

                                        <a class="btn btn-outline-success btn-sm " title="confirm" data-bs-toggle="modal" data-bs-target="#reservationModal" onclick="showInfoReservation('<?= $reservationId ?>')">
                                            <i class="fa fa-info"></i>
                                        </a>

                                    </td>
                                    <td class="d-none text-center checkAll">
                                        <input type="checkbox" <?= $reservationIdStatus == 2 && $requestDate > $dateNow ? '' : 'disabled' ?> name="idPackage[]" value="<?= $reservationId ?>">
                                    </td>
                                    <td class="text-center" id="action<?= $reservationId ?>">
                                        <?php if ($reservationIdStatus == 4 && $rating == null && $requestDate < $dateNow) : ?>
                                            <a title="rate package" class="btn " data-bs-toggle="modal" data-bs-target="#reservationModal" onclick="openModalRatingReservation('<?= $reservationId ?>')"> <i class="fa fa-star text-warning"></i></a>
                                        <?php elseif ($reservationIdStatus == 4 && $rating != null && $requestDate < $dateNow) : ?>
                                            <a title="rate package" class="btn " data-bs-toggle="modal" data-bs-target="#reservationModal" onclick="openInfoRating('<?= $rating ?>','<?= $review ?>','<?= $item['updated_at']; ?>')"> <i class="fa fa-check text-primary"></i></a>
                                        <?php else : ?>

                                        <?php endif; ?>


                                    </td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
    let photo, pond, galleryValue

    function showInfoReservation(id) {
        let result
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
        let buttonDelete =
            result['id_reservation_status'] == '1' ? `<a class="btn btn-outline-danger" onclick="deleteReservation('${id}')"> Abort reservation</a>` : '';

        $('#modalTitle').html("Reservation Info")
        if (result['id_package'] != null) {
            $('#modalBody').html(`
            <div class="p-2">
                <div id="userRating">
                </div>

                <div id="userTicket">
                </div>
                
                <div id="userDeposit">
                </div>
                <div class="mb-2 shadow-sm p-4 rounded">
                    <p class="text-center fw-bold text-dark"> Reservation Information </p>
                    <table class="table table-borderless text-dark ">
                        <tbody>
                            <tr>
                                <td class="fw-bold">${buttonDelete}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Your reservation status</td>
                                <td>${result['status']}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Request By</td>
                                <td>${result['username']}</td>
                            </tr>
                            
                            <tr>
                                <td class="fw-bold">Package name </td>
                                <td>${result['item_name']}</td>
                            </tr>
                                                
                            <tr>
                                <td class="fw-bold">Date</td>
                                <td>${result['request_date']}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total people</td>
                                <td>${result['number_people']}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Costum package</td>
                                <td class="${result['item_costum'] == '1' ? 'badge bg-success' : ''}">${result['item_costum'] == '2' ? 'no' : 'yes'}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Additional Information</td>
                                <td>${result['comment']!= null ? result['comment'] : '-'}</td>
                            </tr>
                                        
                        </tbody>
                    </table>
                </div>
            
            </div>
            `)
        } else if (result['id_homestay'] != null) {
            $('#modalBody').html(`
            <div class="p-2">
                <div id="userRating">
                </div>

                <div id="userTicket">
                </div>
                
                <div id="userDeposit">
                </div>
                <div class="mb-2 shadow-sm p-4 rounded">
                    <p class="text-center fw-bold text-dark"> Reservation Information </p>
                    <table class="table table-borderless text-dark ">
                        <tbody>
                            <tr>
                                <td class="fw-bold">${buttonDelete}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Your reservation status</td>
                                <td>${result['status']}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Request By</td>
                                <td>${result['username']}</td>
                            </tr>
                            
                            <tr>
                                <td class="fw-bold">Homestay name </td>
                                <td>${result['item_name']}</td>
                            </tr>                  
                            <tr>
                                <td class="fw-bold">Date</td>
                                <td>${result['request_date']} </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Until</td>
                                <td>${result['request_date_end'] != null ? result['request_date_end'] : ''}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total people</td>
                                <td>${result['number_people']}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Homestay status</td>
                                <td class="${result['item_costum'] == '1' ? 'badge bg-success' : ''}">${result['item_costum'] == '2' ? 'Not Available' : 'Available'}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Additional Information</td>
                                <td>${result['comment']!= null ? result['comment'] : '-'}</td>
                            </tr>
                                        
                        </tbody>
                    </table>
                </div>
            
            </div>
            `)
        }


        // user payment
        if (result['id_reservation_status'] == '2') {
            let proofDeposit = result['proof_of_deposit']
            let deposit = result['deposit']
            $("#userDeposit").addClass("mb-2 shadow-sm p-4 rounded")
            $("#userDeposit").html(`
                <p class="text-center fw-bold text-dark"> Upload Your Payment </p>
                <p>Note <span class="text-danger">*</span> Before uploading proof of deposit, make sure the payment amount is the same as the invoice, please print the invoice to see the deposit amount</p>
                <div class="text-start mb-4">
                    <a class="btn btn-primary" onclick="openInvoice('${id}')" > <i class="fa fa-print"> </i> print invoice</a>
                </div>
                <div class="form-group mb-4">
                   <label for="deposit" class="mb-2"> Deposit <span class="text-danger">*</span></label>
                   <div class="input-group">
                   <span class="input-group-text">Rp </span>
                      <input type="number" id="deposit" class="form-control" name="deposit" placeholder="deposit" aria-label="deposit" value="${deposit}" aria-describedby="deposit" required>
                   </div>
                </div>
                <div class="form-group mb-4">
                    <label for="gallery" class="form-label"> Upload Proof of Deposit <span class="text-danger">*</span></label>
                    <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery">
                </div>
                <div class="text-end">
                    <a class="btn btn-success" onclick="saveDeposit('${id}')" > save</a>
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
            if (proofDeposit != null) {
                pond.addFiles(
                    `${baseUrl}/media/photos/reservation/${proofDeposit}`
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

        // user tiket
        if (result['id_reservation_status'] == '4' && result['payment_date'] != null) {
            $("#userTicket").addClass("background-effect mb-2 shadow-sm p-4 rounded border border-warning")
            $("#userTicket").css('height', '250px');
            $("#userTicket").html(`
                <a class="btn" onclick="printTicket('${id}')">
                    <h1 class=" gold text-center fw-bold text-dark"> Print Your Ticket Here </h1>
                </a>
            `)
        }
        // user rating
        if (result['rating'] != null) {
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

    function saveDeposit(id) {
        let deposit = $("#deposit").val()
        console.log(deposit)
        let proofDeposit = galleryValue
        let requestData = {
            deposit: deposit,
            proof_of_deposit: proofDeposit
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
                    window.location.reload()
                });
            },
            error: function(err) {
                console.log(err.responseText)
            }
        });

    }


    function printTicket(id) {
        console.log(id)
        $.ajax({
            url: '<?= base_url("web/pdf/ticket-data") ?>',
            type: "POST",
            dataType: "json",
            data: {
                id_reservation: [id]
            },
            success: function(response) {
                window.open('<?= base_url('web/pdf/ticket'); ?>' + '/' + JSON.stringify(response));
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    function openInfoRating(rating, review, updated_at) {

        $('#modalTitle').html("Thanks for rating and reviewed")
        $('#modalBody').html(`
            <p>  ${updated_at} </p>
            <div class="star-containter mb-3 text-start">
            <i class="fa-solid fa-star fs-10" id="star-1" ></i>
            <i class="fa-solid fa-star fs-10" id="star-2" ></i>
            <i class="fa-solid fa-star fs-10" id="star-3" ></i>
            <i class="fa-solid fa-star fs-10" id="star-4" ></i>
            <i class="fa-solid fa-star fs-10" id="star-5" ></i>
            </div>
            <p>  ${review} </p>
        `)
        setStar(rating)
        $("#modalFooter").html()
    }

    function openModalRatingReservation(reservationId) {
        let url = `<?= base_url('web/reviewPackage') ?>`
        $('#modalTitle').html("Please rate and review")
        $("#modalBody").html(`
        <?php if (in_groups('user')) : ?>
            <form class="form form-vertical" action="${url}" method="post" onsubmit="checkStar(event);">
                <div class="form-body">
                    <div class="star-containter mb-3 text-center">
                        <i class="fa-solid fa-star fs-4" id="star-1" onclick="setStar('1');"></i>
                        <i class="fa-solid fa-star fs-4" id="star-2" onclick="setStar('2');"></i>
                        <i class="fa-solid fa-star fs-4" id="star-3" onclick="setStar('3');"></i>
                        <i class="fa-solid fa-star fs-4" id="star-4" onclick="setStar('4');"></i>
                        <i class="fa-solid fa-star fs-4" id="star-5" onclick="setStar('5');"></i>
                        <input type="hidden" id="star-rating" value="0" name="rating">
                        <input type="hidden" value="<?= user()->id ?>" name="id_user">
                        <input type="hidden" value="${reservationId}" name="id_reservation">
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a review here" id="floatingTextarea" style="height: 150px;" name="review"></textarea>
                            <label for="floatingTextarea">Leave a review here</label>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end mb-3">
                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                    </div>
                </div>
            </form>
        <?php endif; ?>
        `)
        $('#modalFooter').html()

    }
    // Validate if star rating picked yet
    function checkStar(event) {
        const star = document.getElementById('star-rating').value;
        if (star == '0') {
            event.preventDefault();
            Swal.fire('Please put rating star');
        }
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


    function showModalDelete(id) {
        console.log(id)
        $('#modalTitle').html("Abort reservation")
        $('#modalBody').html(`Are you sure delete this reservation?`)
        $('#modalFooter').html(`<a class="btn btn-danger" onclick="deleteReservation('${id}')"> Delete </a>`)
    }

    function deleteReservation(id_reservation) {
        $.ajax({
            url: `<?= base_url('api/reservation') ?>/${id_reservation}`,
            type: "DELETE",
            async: false,
            contentType: "application/json",
            success: function(response) {

                Swal.fire(
                    'Reservation deleted',
                    '',
                    'success'
                ).then(() => {
                    window.location.replace("<?= base_url('web/reservation') ?>" + "/" + "<?= user()->id ?>")
                });
            },
            error: function(err) {
                console.log(err.responseText)
            }
        });
    }

    function openMultipleCheckOut() {
        $("#multipleButton").html(`
        <a title="closeAll" class="btn btn-danger" onclick="closeMultipleCheckOut()"><i class="fa fa-x"></i> Cancel Group </a>
        <a title="Print All" class="btn btn-primary" onclick="openInvoice()"><i class="fa fa-print"></i> Print selected</a>
        `)
        $(".checkAll").removeClass("d-none")
        $(".checkSingle").addClass("d-none")
    }

    function closeMultipleCheckOut() {
        $("#multipleButton").html(`
        <a title="Print multiple reservation" class="btn btn-primary" onclick="openMultipleCheckOut()"><i class="fa-solid fa-print"></i> Print in Group </a>
        `)
        $(".checkAll").addClass("d-none")
        $(".checkSingle").removeClass("d-none")
    }

    function openInvoice(single = null) {
        let invoiceRequest

        single != null ?
            invoiceRequest = [single] :
            invoiceRequest = $('input[name="idPackage[]"]:checked').map(function() {
                return this.value; // $(this).val()
            }).get();


        if (invoiceRequest.length > 0) {
            $.ajax({
                url: '<?= base_url("web/pdf/invoice-data") ?>',
                type: "POST",
                dataType: "json",
                data: {
                    id_reservation: invoiceRequest
                },
                success: function(response) {

                    window.open('<?= base_url('web/pdf/invoice'); ?>' + '/' + JSON.stringify(response));
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })
        } else {
            Swal.fire(
                'Please select 1 reservation at least!',
                '',
                'error'
            )
        }

    }
</script>


<?= $this->endSection() ?>