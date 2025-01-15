<?php
if(isset($_SESSION['id_user'])){
    $query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE id_user='$_SESSION[id_user]'")
    or die('error'.mysqli_error($mysqli));
    $data = mysqli_fetch_assoc($query);
}?>

<section class="content-header">
    <h1>
        <i class="cil-user"></i> Perfil de usuarios
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i></a>Inicio</li>
        <li class="breadcrumb-item active">Perfil de usuarios</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!--Agregar mensajes de error-->
            <?php 
                if(empty($_GET['alert'])){
                    echo "";
                }
                elseif($_GET['alert']==1){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Éxito!</strong> El usuario se ha editado correctamente.
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
                elseif($_GET['alert']==2){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> Asegúrese de que el archivo ingresado sea una imagen.
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
                elseif($_GET['alert']==3){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> El archivo debe ser menor de 1MB.
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
                elseif($_GET['alert']==4){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> Asegúrese de que el tipo de archivo es: *.jpg *.jpeg *.png.
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
            ?>

            <div class="card">
                <div class="card-body">
                    <form class="row g-3" method="POST" action="?module=form_perfil" enctype="multipart/form-data">
                        <input type="hidden" name="id_user" value="<?php echo $data['id_user'] ?>">

                        <div class="col-md-2">
                            <?php
                                if($data['foto']==""){ ?>
                                    <img class="img-thumbnail" src="images/user/user-default.png" alt="User Default" style="height:100px; width:100px;">
                            <?php }else{ ?>
                                    <img class="img-thumbnail" src="images/user/<?php echo $data['foto']; ?>" alt="User Image" style="height:100px; width:100px;">
                            <?php }
                            ?>
                        </div>

                        <div class="col-md-8">
                            <h2><?php echo $data['name_user'] ?></h2>
                        </div>

                        <hr>

                        <div class="col-md-12">
                            <label class="form-label">Nombre de usuario: <?php echo $data['username'] ?></label>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Email: <?php echo $data['email'] ?></label>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Teléfono: <?php echo $data['telefono'] ?></label>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Permisos de acceso: <?php echo $data['permisos_acceso'] ?></label>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Status: <?php echo $data['status'] ?></label>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" name="Modificar">Modificar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>