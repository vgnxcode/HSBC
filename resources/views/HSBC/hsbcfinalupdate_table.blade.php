<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HSBC API Hits</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!-- Bootstrap icon CSS -->
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
/>
<!-- Fontawesine icon CSS -->
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
/>
    <!-- DataTables and jQuery CSS/JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

        <!-- Left -->
        <h1 class="mb-0">HSBC API Hits</h1>

        <!-- Right -->
        <div class="dropdown">

            <button
                class="btn btn-light dropdown-toggle"
                type="button"
                id="userDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                Hi, {{ session('hsbcuser_name') ?? 'User' }}

            </button>

            <ul class="dropdown-menu dropdown-menu-end"
                aria-labelledby="userDropdown">



                 <li>
                    <a class="dropdown-item" href="{{ route('hsbc.paymentquee') }}">
                        <i class="bi bi-bank me-2"></i>
                        Payment
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>


                 <li>
                    <a class="dropdown-item" href="{{ route('hsbc.report') }}">
                        <i class="bi bi-map me-2"></i>
                        Report
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>



                <li>
                    <a class="dropdown-item" href="{{ route('hsbc.profile') }}">
                        <i class="bi bi-person me-2"></i>
                        Profile
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <form action="{{ route('hsbc.logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </button>
                    </form>
                </li>

            </ul>

        </div>

    </div>








        {{-- <h1 class="mb-4">HSBC API Hits</h1>
        {{ session('hsbcuser_name') ?? 'NOT SET' }} --}}
       {{-- <a class="btn btn-sm btn-dark text-light" href="https://hsbc.vgn.in/api/hsbc/hsbc_getdatafromsap" target="_blank">Trigger now</a> --}}
       <p class="text-danger" ><strong>Notes:</strong> <br>
            <span class="text-dark">After sending the payment, if the status is not displayed, kindly click the **Get Status** button to retrieve the status of the payment that has not yet been received.This Feature only works for last 24hr.
</span>
       </p>
       <button type="button" class="btn btn-sm btn-primary" onclick="location.reload()">
    <i class="fa fa-refresh"></i> Get Status
</button>
       
       <hr>
        <table id="dataTable" class="table table-sm table-responsive-sm table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Beneficiary_Name</th>
                    <th>Beneficiary_Account_No</th>
                    <th>Beneficiary_Bank_Name</th>
                    <th>IFSC_Code</th>
                    <th>Amount</th>
                    <th>Transaction_type</th>
                    <th>Company_Account_No</th>
                    <th>Company_Name</th>
                    <th>Message ID</th>
                    <th>Hit Status</th>
                    <th>Reference ID</th>
                    <th>Status Code</th>
                    <th>Description</th>
                    <th>EncDec</th>
                    <th>Reversal Code</th>
                    <th>UTR No</th>
                    <th>Message Source</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($data as $item)                
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                         <td>{{ $item->Beneficiary_Name }}</td>
                         <td>{{ $item->Beneficiary_Account_No }}</td>
                         <td>{{ $item->Beneficiary_Bank_Name }}</td>
                         <td>{{ $item->IFSC_Code }}</td>
                         <td>{{ $item->Amount }}</td>
                         <td>{{ $item->Transaction_type }}</td>
                         <td>{{ $item->Company_Account_No }}</td>
                         <td>{{ $item->Company_Name }}</td>
                        <td>{{ $item->msgid }}</td>
                        <td>{{ $item->hit_status }}</td>
                        <td>{{ $item->referenceId }}</td>
                        <td>{{ $item->statusCode }}</td>
                        <td>{{ $item->description }}</td>
                        @if($item->statusCode == 'RJCT' && $item->encdec_data !=null)
                            <td>
                                <button data-msg_id="{{ $item->msgid }}" data-id="{{ $item->id }}" class="encdec btn btn-danger btn-sm text-light">
                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                </button>
                            </td>
                         @else
                            <td>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </td> 
                         @endif
                        <td>{{ $item->Reversal_Code }}</td>
                        <td>{{ $item->UTR_NO }}</td>
                        <td>{{ $item->Message_Source }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/assets/libs/openpgp/dist/openpgp.min.js" ></script>
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
<script>

var openpgp = window.openpgp;
 openpgp.initWorker({ path:'/assets/libs/openpgp/dist/openpgp.worker.js' });





// put keys in backtick (``) to avoid errors caused by spaces or tabs
const pubkey = `-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: BCPG v@RELEASE_NAME@

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
ox+b4Rsktmj/mL+QHiVs4XjtD2d49Q==
=tf90
-----END PGP PUBLIC KEY BLOCK-----`;

const privkey = `-----BEGIN PGP PRIVATE KEY BLOCK-----

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
uyb1NnA8KTtgHvkaJw==
=/DX9
-----END PGP PRIVATE KEY BLOCK-----`; //encrypted private key
const passphrase = `vGn@1942`; //what the privKey is encrypted with
$(document).on("click",".encdec",function(){

    var row=$(this);
    var id=$(this).attr("data-id");  
    var msg_id=$(this).attr("data-msg_id");  
    // alert(id+msg_id);  
    $.post('/api/hsbc/hsbcfinalencdec', {_token:"{{csrf_token()}}",id: id,'msgid': msg_id }, function(data){
        //alert(data);
        // console.log(data);
        console.log("ready!");
        var sapdata = data;
        // console.log(sapdata);
        
         
    var regex = /\"{([^}]*)}\"/g;
    var matches = [];
    var match;
    let resultArray = []; // This array will store the results

    while ((match = regex.exec(sapdata)) !== null) {
        // Push the entire match (which is "{\"...\"}")
        matches.push(match[0]);
    }

    // Define decrypt function
    const decryptFunction = async (encrypted, passphrase, privkey) => {
        const privKeyObj = (await openpgp.key.readArmored(privkey)).keys[0];
        await privKeyObj.decrypt(passphrase);
        const encryptedMessage = await openpgp.message.readArmored(encrypted);
        const options = {
            message: encryptedMessage, // Encrypted message object
            privateKeys: [privKeyObj], // Private key to decrypt
        };
        const decrypted = await openpgp.decrypt(options);
        return decrypted.data;
    };

    matches.forEach(function (item) {
        const key = '\\\"responseBase64\\\":\\\"';
        const startIndex = item.indexOf(key) + key.length;
        const result = item.substring(startIndex);
        const finalresult = result.replace(/\\"}"$/, "");
        const encryptedMessage = atob(finalresult); // Decode base64

        // Decrypt and store the message
        decryptFunction(encryptedMessage, passphrase, privkey)
            .then((decryptedMessage) => {
                // Push decrypted message to resultArray
                resultArray.push(decryptedMessage);

                // Once all messages are decrypted, update the DOM
                if (resultArray.length === matches.length) {
                    if (resultArray.length > 0) {
                        resultArray.forEach(function (message) {
                            // console.log("All decrypted messages:", message);
                            var parser = new DOMParser();
                            var xmlDoc = parser.parseFromString(message, "text/xml");
                            var rmsgid = $(xmlDoc).find("OrgnlMsgId").text();

                            // Reject
                            var GrpSts = $(xmlDoc).find("GrpSts").text();
                            var error_code = $(xmlDoc).find("Cd").text();
                            var AddtlInf = $(xmlDoc).find("AddtlInf").text();

                            // Accept
                            var statuscode = $(xmlDoc).find("TxSts").text();
                            var rpaymentdate = $(xmlDoc).find("ReqdExctnDt").text();

                            // console.log(rmsgid);
                            // console.log(statuscode);
                            // console.log(GrpSts);
                            // console.log(rpaymentdate);
                            // console.log(error_code + "-" + AddtlInf);

                            $.post('/api/hsbc/hsbcfinalupdate_decrypt', {
                                _token: "{{ csrf_token() }}",
                                statuscode: statuscode,
                                GrpSts: GrpSts,
                                rmsgid: rmsgid,
                                rpaymentdate: rpaymentdate,
                                error_code: error_code,
                                AddtlInf: AddtlInf
                            })
                            .done(function(finaldata) {
                                console.log(finaldata);
                                window.location.reload(); //Reload on success
                            })
                            .fail(function(xhr, status, error) {
                                console.error("Error:", error);
                                window.location.reload(); // Reload on error
                            });

                        });
                    }
                }
            })
            .catch((error) => {
                console.error("Error decrypting message:", error);
            });
    });
       
    


    });//ajax end
 
 });
</script>
</body>
</html>
