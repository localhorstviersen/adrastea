<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= env('app.site.title') ?> - <?= $this->data['title'] ?></title>

    <!-- Stylesheets -->
    <link href="/assets/css/fontawesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/assets/css/datatables.min.css" rel="stylesheet">
</head>

<body id="page-top">

<div id="wrapper">
    <?= $this->renderSection('sidebar') ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?= $this->renderSection('topbar') ?>
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?= $this->data['title'] ?></h1>
                    <?= $this->renderSection('titleButtons') ?>
                </div>

                <?php if ( ! empty($this->data['errorForm'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->data['errorForm'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Adrastea 2020 - <?= date('Y') ?></span>
                </div>
            </div>
        </footer>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- JavaScript-->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/jquery.easing.js"></script>
<script src="/assets/js/sb-admin-2.min.js"></script>
<script src="/assets/js/chart.min.js"></script>
<script src="/assets/js/chart.min.js"></script>
<script src="/assets/js/datatables.min.js"></script>
<script src="/assets/js/sweetalert2.all.min.js"></script>

<script type="application/javascript">
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        width: '20%',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>

<?php if ( ! empty($this->data['successForm'])): ?>
    <script type="application/javascript">
        Toast.fire({icon: 'success', title: '<?= $this->data['successForm'] ?>'});
    </script>
<?php endif; ?>

<!-- Custom Javascript -->
<?= $this->renderSection('customJs') ?>
</body>
</html>