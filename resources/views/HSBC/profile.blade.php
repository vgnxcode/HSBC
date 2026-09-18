


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
        <h1 class="mb-0">HSBC Users</h1>



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



        <hr>
        {{-- <table id="dataTable" class="table table-sm table-responsive-sm table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Emp id</th>
                    <th>Email</th>                   
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($data as $item)                
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->emp_id }}</td>
                        <td>{{ $item->email }}</td>                
                       
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}



        @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

        <table id="dataTable" class="table table-sm table-responsive-sm table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Emp ID</th>
            <th>Email</th>
            <th>Password</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $item)
            <tr>
                <form action="{{ route('authuser.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <input type="text"
                               name="name"
                               value="{{ $item->name }}"
                               class="form-control form-control-sm">
                    </td>

                    <td>
                        <input type="text"
                               name="emp_id"
                               value="{{ $item->emp_id }}"
                               class="form-control form-control-sm">
                    </td>

                    <td>
                        <input type="email"
                               name="email"
                               value="{{ $item->email }}"
                               class="form-control form-control-sm">
                    </td>

                    <td>
                        <input type="password"
                               name="password"
                               placeholder="Leave blank to keep current"
                               class="form-control form-control-sm">
                    </td>

                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_at }}</td>

                    <td>
                        <button type="submit" class="btn btn-sm btn-primary">
                            Update
                        </button>
                    </td>
                </form>
            </tr>
        @endforeach
    </tbody>
</table>
    </div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
