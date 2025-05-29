<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register - AN-Nadwah </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

 <!-- Favicon -->
    <link rel="icon" href="assets_home/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="16x16" href="assets_home/favicon_io/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets_home/favicon_io/favicon-32x32.png">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets_home/favicon_io/apple-touch-icon.png">

    <!-- Android Chrome Icons -->
    <link rel="icon" type="image/png" sizes="192x192" href="assets_home/favicon_io/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets_home/favicon_io/android-chrome-512x512.png">

    <!-- Manifest (optional, for PWA support) -->
    <link rel="manifest" href="assets_home/favicon_io/site.webmanifest">

  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <!-- End Logo -->
              <div class="card mb-3">

                <div class="card-body">

                   <div class="pt-4 pb-2">
                    <div class="d-flex justify-content-center align-items-center">
                      <img width="200px"  src="{{asset('assets_home/img/logo/logo1.png')}}" alt="Logo AN-Nadwah" class="mt-4">
                    </div>
                    <h5 class="card-title text-center pb-0
                    fs-4">Silahkan Daftar </h5>

                  </div>

                  <form class="row g-3 needs-validation" novalidate method="post" action="{{route('register')}}">
                    @method('POST')
                    @csrf
                    <div class="col-12">
                      <label for="yourName" class="form-label">Nama :</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Mohon, masukan nama</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email :</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Masukan email yang valid</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password :</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Mohon masukan password</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">Saya setuju <a href="#">Kebijakan dan
                            Peraturan</a></label>
                        <div class="invalid-feedback">Kamu harus setuju sebelum mendaftar.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn button-tambah w-100" type="submit">Buat Akun</button>
                    </div>
                    <!-- <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="pages-login.html">Log in</a></p>
                    </div> -->
                  </form>

                </div>
              </div>

              <!-- <div class="credits"> -->
              <!-- All the links in the footer should remain intact. -->
              <!-- You can delete the links only if you purchased the pro version. -->
              <!-- Licensing information: https://bootstrapmade.com/license/ -->
              <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
              <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div> -->

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>