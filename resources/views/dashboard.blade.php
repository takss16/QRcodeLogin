
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <title>MCC Vitality Tracker</title>
    <link href="{{asset ('img/logo.png')}}" rel="icon">
</head>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
      </svg>
    <div class="text-center">
        <div class="row justify-content-center">
            <div class="col-4 text-center">
                @if(session('error'))
                    <div id="myAlert" class="alert alert-danger d-flex align-items-center justify-content-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div class="col-8">
                            {{ session('error') }}
                        </div>
                    </div>
                @elseif (session('success'))
                <div id="myAlert" class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    <div class="col-8">
                        {{ session('success') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row my-5 g-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card bg-dark bg-opacity-25">
                    <div class="card-body m-xl-4">
                        <div class="text-center">
                            <img src="{{ asset('img/logo.png') }}" class="logo">
                            <h2 class="fw-bold text-danger">MABALACAT CITY COLLEGE</h2>
                        </div>
                        <hr>
                        <button type="button" class="btn btn-danger w-100 m-1" data-bs-toggle="modal" data-bs-target="#form-modal" {{ $vitalsExist && $vitalExistLastMonth ? 'disabled' : '' }}>
                            <i class="fa-solid fa-circle-plus me-2"></i>
                            Add New Record
                        </button>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-secondary w-100 m-1">
                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
                                Logout
                            </button>
                        </form>
                        <hr>
                        <div class="w-100">
                            <form action="{{ route('dashboard', ['employee_id' => $encryptedEmployeeId]) }}" method="GET">
                                @csrf
                                <label for="show-records" class="form-label">Show Records</label>
                                <select class="form-select form-select-lg mb-3" id="show-records" name="selectedYear" >
                                    <option>Please Select Year</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ request('selectedYear') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fa-solid fa-filter me-2"></i>
                                    Filter Vitality Records
                                </button>
                            </form>
                        </div>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-9">
                <div class="row row-cols-1 row-cols-xl-3 g-4">
                    @if($vitals->count() > 0)
                        @foreach($vitals->sortBy(function ($vital) {
                            return DateTime::createFromFormat('F', $vital->month)->format('n');
                        }) as $vital)
                            <div class="col">
                                <div class="card h-100 {{ $vital->month == now()->format('F') && $vital->year == now()->year ? 'border-danger' : '' }}">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit-modal-{{ $vital->id }}"
                                                    {{ $vital->month == now()->format('F') && $vital->year == now()->year ? '' : 'style=display:none;' }}>
                                                    Edit
                                                 </a>
                                                 <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#remove-modal-{{ $vital->id }}">Remove</a>
                                            </div>
                                            <div class="modal fade" id="remove-modal-{{ $vital->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                  <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                      <h1 class="modal-title fs-5 text-white fw-bold" id="exampleModalLabel">Remove Record</h1>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h3>Are you sure?</h3>
                                                        <p>Do you really want to delete this item? This process cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        @if(isset($vital))
                                                            <form action="{{ route('vitals.destroy', ['vital' => $vital->id]) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                    <i class="fa-solid fa-circle-xmark me-2"></i>Close
                                                                </button>

                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fa-solid fa-trash me-2"></i>Confirm Action
                                                                </button>
                                                            </form>
                                                        @else
                                                            <p>No vital record found.</p>
                                                        @endif
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="edit-modal-{{ $vital->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                          <h1 class="modal-title fs-5 text-white fw-bold" id="exampleModalLabel">Edit Record for <b>{{ $vital->month }}, {{ $vital->year }}</b></h1>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('vitals.update', ['vital' => $vital->id]) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" inputmode="numeric" class="form-control" name="pulse_rate" value="{{ $vital->pulse_rate }}" placeholder="Pulse Rate" required>
                                                                    <label for="pulse-rate">Pulse Rate</label>
                                                                </div>

                                                                <div class="form-floating mb-3">
                                                                    <input type="number" inputmode="numeric" class="form-control" name="body_temperature" value="{{ $vital->body_temperature }}" placeholder="Body Temperature" required>
                                                                    <label for="body-temperature">Body Temperature (in degree celsius)</label>
                                                                </div>

                                                                <div class="form-floating mb-3">
                                                                    <input type="number" inputmode="numeric" class="form-control" name="respiratory_rate" value="{{ $vital->respiratory_rate }}" placeholder="Respiratory Rate" required>
                                                                    <label for="respiratory-rate">Respiratory Rate</label>
                                                                </div>

                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" name="bp" value="{{ $vital->bp }}" placeholder="Blood Pressure" required>
                                                                    <label for="blood-pressure">Blood Pressure</label>
                                                                </div>

                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" name="bmi" value="{{ $vital->bmi }}" placeholder="Body Mass Index" required>
                                                                    <label for="body-mass-index">Body Mass Index</label>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark me-2"></i>Close</button>
                                                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-floppy-disk me-2"></i>Save changes</button>
                                                            </div>
                                                        </form>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="card-title fw-bold text-danger">{{ $vital->month }}</h5>
                                        <p class="card-text">
                                            <ul class="list-unstyled ms-2">
                                                <li>
                                                    <i class="fa-solid fa-fw fa-bed-pulse me-2"></i>
                                                    <span class="text-muted">Pulse Rate: </span>
                                                    <span class="badge rounded-pill text-bg-danger float-end">{{ $vital->pulse_rate }} BPM</span>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-fw fa-temperature-three-quarters me-2"></i>
                                                    <span class="text-muted">Body Temperature: </span>
                                                    <span class="badge rounded-pill text-bg-danger float-end">{{ $vital->body_temperature }} °C</span>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-fw fa-heart-pulse me-2"></i>
                                                    <span class="text-muted">Respiratory Rate: </span>
                                                    <span class="badge rounded-pill text-bg-danger float-end">{{ $vital->respiratory_rate }}  BPM</span>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-fw fa-droplet me-2"></i>
                                                    <span class="text-muted">Blood Pressure: </span>
                                                    <span class="badge rounded-pill text-bg-danger float-end">{{ $vital->bp }} </span>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-fw fa-person me-2"></i>
                                                    <span class="text-muted">Body Mass Index: </span>
                                                    <span class="badge rounded-pill text-bg-danger float-end">{{ $vital->bmi}} </span>
                                                </li>
                                            </ul>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No vitals recorded yet.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="form-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5 text-white fw-bold" id="exampleModalLabel">Add New Record</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vitals.store', ['employee_id' => $employee->employee_id]) }}" method="post">
                        @csrf
                        <select class="form-select form-select-lg mb-3" id="show-records" name="month">
                            <option disabled selected>Select Month</option>
                            @foreach (range(1,12) as $month)
                                @if ($month <= date('n'))
                                    <option value="{{ date("F", mktime(0, 0, 0, $month, 1)) }}" >{{ date("F", mktime(0, 0, 0, $month, 1)) }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="form-floating mb-3">
                            <input type="number" inputmode="numeric" class="form-control" id="pulse-rate" name="pulse_rate" placeholder="Pulse Rate" required>
                            <label for="pulse-rate">Pulse Rate</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" inputmode="numeric" class="form-control" id="body-temperature" name="body_temperature" placeholder="Body Temperature" required>
                            <label for="body-temperature">Body Temperature (in degree Celsius)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" inputmode="numeric" class="form-control" id="respiratory-rate" name="respiratory_rate" placeholder="Respiratory Rate" required>
                            <label for="respiratory-rate">Respiratory Rate</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="blood-pressure" name="bp" placeholder="Blood Pressure" required>
                            <label for="blood-pressure">Blood Pressure</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="body-mass-index" name="bmi" placeholder="Body Mass Index" required>
                            <label for="body-mass-index">Body Mass Index</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fa-solid fa-circle-xmark me-2"></i>Close
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var alert = document.getElementById('myAlert');
            function closeAlert() {
                $('.alert').alert('close');
            }
            setTimeout(closeAlert, 3000);
        });
    </script>
</body>
</html>
