
<!DOCTYPE html>
<html lang="es">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>APP | CPCC</title>
        <!-- base:css -->
        <link rel="stylesheet" href="vendors/typicons/typicons.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="plugins/sweetalert/sweetalert2.min.css">
        <link rel="stylesheet" href="plugins/select2/select2.min.css">
        <!-- endinject -->
        <!-- plugin css for this page -->
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="css/vertical-layout-light/style.css">
        <!-- endinject -->
        <link rel="shortcut icon" href="images/favicon.png" />
        <style>
            #proBanner{
                display: none;
            }
        </style>
    </head>
    <body>
        <?php
        session_start();
        ?>
        <input type="text" id="id_rol_usuario"  value="<?= $_SESSION['rol'];?>">
        <input type="text" id="id_usuario_activo"  value="<?= $_SESSION['id_usuario'];?>">

        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex justify-content-center">
                    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                        <a class="navbar-brand brand-logo" href="#">APP CPCC</a>
                        <a class="navbar-brand brand-logo-mini" href="index.php"><img style="width: 80%;" src="images/blanco-logo.png" alt="logo"/></a>
                        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                            <span class="typcn typcn-th-menu"></span>
                        </button>
                    </div>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <ul class="navbar-nav mr-lg-2">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
                                
                                <span class="nav-profile-name"><?=$_SESSION['nombre_completo'];?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                               
                                <a class="dropdown-item" href="controlador/cerrarSesion.php">
                                    <i class="typcn typcn-eject text-primary"></i>
                                    Cerrar Sesion
                                </a>
                            </div>
                        </li>
                        <li class="nav-item nav-user-status dropdown">
                            <p class="mb-0">Bienvenido/a</p>
                        </li>
                    </ul>
                 
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="typcn typcn-th-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <nav class="navbar-breadcrumb col-xl-12 col-12 d-flex flex-row p-0">
                <div class="navbar-links-wrapper d-flex align-items-stretch">
                    <div class="nav-link">
                        <a href="javascript:;"><i class="typcn typcn-calendar-outline"></i></a>
                    </div>
                    <div class="nav-link">
                        <a href="javascript:;"><i class="typcn typcn-mail"></i></a>
                    </div>
                    <div class="nav-link">
                        <a href="javascript:;"><i class="typcn typcn-folder"></i></a>
                    </div>
                    <div class="nav-link">
                        <a href="javascript:;"><i class="typcn typcn-document-text"></i></a>
                    </div>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <ul class="navbar-nav mr-lg-2">
                        <li class="nav-item ml-0">
                            <h4 class="mb-0">Escritorio</h4>
                        </li>
                       
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-search d-none d-md-block mr-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." aria-label="search" aria-describedby="search">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="search">
                                        <i class="typcn typcn-zoom"></i>
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_settings-panel.html -->
              
                <div id="right-sidebar" class="settings-panel">
                    <i class="settings-close typcn typcn-times"></i>
                    <ul class="nav nav-tabs" id="setting-panel" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="setting-content">
                        <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                            <div class="add-items d-flex px-3 mb-0">
                                <form class="form w-100">
                                    <div class="form-group d-flex">
                                        <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                        <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                                    </div>
                                </form>
                            </div>
                            <div class="list-wrapper px-3">
                                <ul class="d-flex flex-column-reverse todo-list">
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox">
                                                Team review meeting at 3.00 PM
                                            </label>
                                        </div>
                                        <i class="remove typcn typcn-delete-outline"></i>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox">
                                                Prepare for presentation
                                            </label>
                                        </div>
                                        <i class="remove typcn typcn-delete-outline"></i>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox">
                                                Resolve all the low priority tickets due today
                                            </label>
                                        </div>
                                        <i class="remove typcn typcn-delete-outline"></i>
                                    </li>
                                    <li class="completed">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox" checked>
                                                Schedule meeting for next week
                                            </label>
                                        </div>
                                        <i class="remove typcn typcn-delete-outline"></i>
                                    </li>
                                    <li class="completed">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox" checked>
                                                Project review
                                            </label>
                                        </div>
                                        <i class="remove typcn typcn-delete-outline"></i>
                                    </li>
                                </ul>
                            </div>
                            <div class="events py-4 border-bottom px-3">
                                <div class="wrapper d-flex mb-2">
                                    <i class="typcn typcn-media-record-outline text-primary mr-2"></i>
                                    <span>Feb 11 2018</span>
                                </div>
                                <p class="mb-0 font-weight-thin text-gray">Creating component page</p>
                                <p class="text-gray mb-0">build a js based app</p>
                            </div>
                            <div class="events pt-4 px-3">
                                <div class="wrapper d-flex mb-2">
                                    <i class="typcn typcn-media-record-outline text-primary mr-2"></i>
                                    <span>Feb 7 2018</span>
                                </div>
                                <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
                                <p class="text-gray mb-0 ">Call Sarah Graves</p>
                            </div>
                        </div>
                        <!-- To do section tab ends -->
                        <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
                            <div class="d-flex align-items-center justify-content-between border-bottom">
                                <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
                                <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal">See All</small>
                            </div>
                            <ul class="chat-list">
                                <li class="list active">
                                    <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span class="online"></span></div>
                                    <div class="info">
                                        <p>Thomas Douglas</p>
                                        <p>Available</p>
                                    </div>
                                    <small class="text-muted my-auto">19 min</small>
                                </li>
                                <li class="list">
                                    <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
                                    <div class="info">
                                        <div class="wrapper d-flex">
                                            <p>Catherine</p>
                                        </div>
                                        <p>Away</p>
                                    </div>
                                    <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                                    <small class="text-muted my-auto">23 min</small>
                                </li>
                                <li class="list">
                                    <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
                                    <div class="info">
                                        <p>Daniel Russell</p>
                                        <p>Available</p>
                                    </div>
                                    <small class="text-muted my-auto">14 min</small>
                                </li>
                                <li class="list">
                                    <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
                                    <div class="info">
                                        <p>James Richardson</p>
                                        <p>Away</p>
                                    </div>
                                    <small class="text-muted my-auto">2 min</small>
                                </li>
                                <li class="list">
                                    <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span class="online"></span></div>
                                    <div class="info">
                                        <p>Madeline Kennedy</p>
                                        <p>Available</p>
                                    </div>
                                    <small class="text-muted my-auto">5 min</small>
                                </li>
                                <li class="list">
                                    <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span class="online"></span></div>
                                    <div class="info">
                                        <p>Sarah Graves</p>
                                        <p>Available</p>
                                    </div>
                                    <small class="text-muted my-auto">47 min</small>
                                </li>
                            </ul>
                        </div>
                        <!-- chat tab ends -->
                    </div>
                </div>
                <!-- partial -->
                <!-- partial:partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
<?php
                        if($_SESSION['rol'] == "ADMINISTRADOR"){


                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="typcn typcn-device-desktop menu-icon"></i>
                                <span class="menu-title">Escritorio</span>

                            </a>
                        </li>



                        <?php
                        }
                        ?>

                        <li class="nav-item">
                            <a class="nav-link" onclick="mostrarListarCurso(); return false;" href="#">
                                <i class="typcn typcn-book menu-icon"></i>
                                <span class="menu-title">Curso</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="mostrarListarProyecto(); return false;" href="#">
                                <i class="typcn typcn-briefcase menu-icon"></i>
                                <span class="menu-title">Proyecto</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" onclick="mostrarListarEspecialidad(); return false;" href="#">
                                <i class="typcn typcn-th-small-outline menu-icon"></i>
                                <span class="menu-title">Especialidad</span>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="controlador/cerrarSesion.php" aria-expanded="false" >
                                <i class="typcn typcn-document-text menu-icon"></i>
                                <span class="menu-title">Cerrar Sesion</span>
                            </a>
                        </li>
                        
                        
                    </ul>
                </nav>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper" id="contenido-principal">


                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->
                    <footer class="footer">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 <a href="https://www.brasipar.com/" class="text-muted" target="_blank">BRASIPAR</a>. Luis Guzman & Valdir Dadalt.</span>
                                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center text-muted">Desarrollado para <a href="#" class="text-muted" target="_blank">CPCC</a> todos los derechos</span>
                                </div>
                            </div>    
                        </div>        
                    </footer>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->

        <!-- base:js -->
        <script src="vendors/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page-->
        <script src="vendors/chart.js/Chart.min.js"></script>
        <script src="plugins/chartjs/chart.js"></script>
        <!-- End plugin js for this page-->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/hoverable-collapse.js"></script>
        <script src="js/template.js"></script>
        <script src="js/settings.js"></script>
        <script src="js/todolist.js"></script>
        <script src="plugins/select2/select2.min.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="js/dashboard.js"></script>
        <script src="plugins/sweetalert/sweetalert2.min.js"></script>
        <script src="vista/util.js"></script>
        <script src="vista/usuario.js"></script>
        <script src="vista/registro_medidas.js"></script>
        <script src="vista/curso.js"></script>
        <script src="vista/proyecto.js"></script>

        <script src="vista/especialidad.js"></script>


        <!-- End custom js for this page-->
    </body>
    
<!--    <script src="js/darkreader.min.js"></script>
    <script>
                    // Activa dark mode
                    DarkReader.enable({
                        brightness: 100,
                        contrast: 90,
                        sepia: 10
                    });
                    // Para desactivar:
                    // DarkReader.disable();
    </script>-->

    <script>
        window.onload = function (evt) {
             let contenido = dameContenido("paginas/usuario/dash.php");
             $("#contenido-principal").html(contenido);
             console.clear();
            
        }
    </script>

</html>

