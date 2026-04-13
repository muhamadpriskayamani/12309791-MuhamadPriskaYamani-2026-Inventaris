<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - SMK Wikrama</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">

    <style>
        body {
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hero {
            flex: 1;
        }

        .custom-btn {
            background-color: #3b82f6;
            color: white;
            border-radius: 6px;
            transition: 0.3s;
        }

        .custom-btn:hover {
            background-color: #2563eb;
            color: white;
        }

        .hero-text {
            max-width: 700px;
        }

        .hero-img {
            max-width: 700px;
        }

        .box-img {
            height: 250px;
        }

        .bg-dark-blue {
            background-color: #050a30;
        }

        .bg-warning-custom {
            background-color: #f9a825;
        }

        .bg-soft-blue {
            background-color: #c5cae9;
        }
    </style>
</head>

<body>

    <nav class="d-flex justify-content-between align-items-center px-5 py-4">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="60px">
        <a href="/login" class="btn custom-btn px-4 py-2">
            Login
        </a>
    </nav>

    <main class="hero">
        <div class="container text-center py-5">
            <h1 class="display-5 fw-bold text-dark mb-3">
                Inventory Management of <br> SMK Wikrama
            </h1>

            <p class="text-secondary fs-5 mb-5 hero-text mx-auto">
                Management of incoming and outgoing items at SMK Wikrama Bogor.
            </p>

            <div class="hero-img mx-auto">
                <img src="{{ asset('assets/img/landing.png') }}" class="img-fluid" alt="Inventory" style="width: 500px">
            </div>
        </div>

        <div class="container text-center py-5">
            <h2 class="fs-2 fw-semibold text-dark mb-2">
                Our System Flow
            </h2>

            <p class="text-secondary fs-6 mb-4">
                Our inventory system workflow
            </p>

            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 text-center h-100">
                        <div class="card-body p-0">
                            <div
                                class="box-img bg-dark-blue d-flex align-items-center justify-content-center rounded-3 mb-3">
                                <img src="{{ asset('assets/img/1.png') }}" class="img-fluid" alt="Inventory"
                                    style="width: 150px">
                            </div>
                            <h5 class="fw-semibold">Items Data</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 text-center h-100">
                        <div class="card-body p-0">
                            <div
                                class="box-img bg-warning-custom d-flex align-items-center justify-content-center rounded-3 mb-3">
                                <img src="{{ asset('assets/img/2.png') }}" class="img-fluid" alt="Inventory"
                                    style="width: 150px">
                            </div>
                            <h5 class="fw-semibold">Management Technician</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 text-center h-100">
                        <div class="card-body p-0">
                            <div
                                class="box-img bg-soft-blue d-flex align-items-center justify-content-center rounded-3 mb-3">
                                <img src="{{ asset('assets/img/3.png') }}" class="img-fluid" alt="Inventory"
                                    style="width: 150px">
                            </div>
                            <h5 class="fw-semibold">Managed Lending</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 text-center h-100">
                        <div class="card-body p-0">
                            <div
                                class="box-img bg-success d-flex align-items-center justify-content-center rounded-3 mb-3">
                                <img src="{{ asset('assets/img/4.png') }}" class="img-fluid" alt="Borrow"
                                    style="width: 150px">
                            </div>
                            <h5 class="fw-semibold">All Can Borrow</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Wikrama" class="mb-3"
                        style="width: 50px;">
                    <p class="text-secondary mb-1">smkwikrama@sch.id</p>
                    <p class="text-secondary">001-7876-2876</p>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Our Guidelines</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Terms</a></li>
                        <li class="mb-2"><a href="#" class="text-danger text-decoration-none">Privacy policy</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Cookie
                                Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Discover</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Our address</h5>
                    <p class="text-secondary mb-0">Jalan Wangun Tengah</p>
                    <p class="text-secondary mb-0">Sindangsari</p>
                    <p class="text-secondary mb-4">Jawa Barat</p>

                    <div class="d-flex gap-3">
                        <a href="https://facebook.com" target="_blank" class="text-dark"><i
                                class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com" target="_blank" class="text-dark"><i
                                class="bi bi-twitter"></i></a>
                        <a href="https://instagram.com" target="_blank" class="text-dark"><i
                                class="bi bi-instagram"></i></a>
                        <a href="https://linkedin.com" target="_blank" class="text-dark"><i
                                class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
