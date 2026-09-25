




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


    


   <style>
    .attendance-table-wrapper {
        max-height: 70vh;
        overflow-y: auto;
        position: relative;
    }

    .attendance-table thead th {
        white-space: nowrap;
        vertical-align: middle;
    }

    .attendance-table tbody td {
        vertical-align: middle;
        white-space: nowrap;
    }

    /* Keep the top navigation above the table */
    .page-header {
        position: relative;
        z-index: 1050;
    }

    /* Keep sticky table header below the dropdown */
    .attendance-table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* Dropdown should appear above the table */
    .page-header .dropdown {
        position: relative;
        z-index: 1100;
    }

    .page-header .dropdown-menu {
        z-index: 1200;
    }
</style>

    <div class="container mt-5">

      <div class="d-flex justify-content-between align-items-center mb-4 page-header">

        <!-- Left -->
        <h1 class="mb-0">HSBC SAP Proxy</h1>

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

            <p class="text-danger" ><strong>Notes:</strong>
            <br>
            <span class="text-dark">Once the payment is released from SAP, it must be processed within 24 hours. If you attempt to process the payment after 24 hours from the SAP release time, the payment will be rejected.
</span>
 </p>


        <div class="table-responsive attendance-table-wrapper">

    <table class="table table-bordered table-hover table-striped align-middle text-center attendance-table mb-0">

        <thead class="table-primary sticky-top">
            <tr>
                <th>#</th>
                <th>Beneficiary Name</th>
                <th>Account No</th>
                <th>Bank Name</th>
                <th>IFSC</th>
                <th>Amount</th>
                <th>Transaction Type</th>
                <th>Message ID</th>
                <th>Reference</th>
                <th>Company Name</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($toprocess as $index => $payment)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td class="text-start">
                        {{ $payment['Beneficiary_Name'] ?? '-' }}
                    </td>

                    <td>
                        {{ $payment['Beneficiary_Account_No'] ?? '-' }}
                    </td>

                    <td class="text-start">
                        {{ $payment['Beneficiary_Bank_Name'] ?? '-' }}
                    </td>

                    <td>
                        {{ $payment['IFSC_Code'] ?? '-' }}
                    </td>

                    <td class="fw-bold text-end">
                        ₹ {{ number_format((float)($payment['Amount'] ?? 0), 2) }}
                    </td>

                    <td>
                        <span class="badge bg-info text-dark">
                            {{ $payment['Transaction_type'] ?? '-' }}
                        </span>
                    </td>

                    <td>
                        <small>
                            {{ $payment['Message_Id'] ?? '-' }}
                        </small>
                    </td>

                    <td>
                        {{ $payment['Id_Ref'] ?? '-' }}
                    </td>

                    <td class="text-start">
                        {{ $payment['Company_Name'] ?? '-' }}
                    </td>

                    <td>
                        <div class="d-flex justify-content-center gap-2">

                            {{-- Trigger Now --}}
                          <form action="{{ route('hsbc.postquee') }}" method="POST">
    @csrf


                               <input type="hidden"
                                       name="payment_index"
                                       value="{{ $index }}">

                                <button type="submit"
                                        class="btn btn-sm btn-success"
                                        onclick="return confirm('Are you sure you want to trigger this payment?')">

                                    <i class="bi bi-play-fill"></i>
                                    Trigger Now

                                </button>

                            </form>


                            {{-- Reject --}}
                            <form action="{{ route('hsbc.rjctquee') }}" method="POST">

                                @csrf

                            <input type="hidden"
                                       name="payment_index"
                                       value="{{ $index }}">

                                <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to reject this payment?')">

                                    <i class="bi bi-x-circle"></i>
                                    Reject

                                </button>

                            </form>

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="11" class="text-center py-4">
                        No payments available in the queue.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>
    </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
