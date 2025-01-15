<!--Menu lateral-->
<div class="sidebar sidebar-narrow-unfoldable border-end">
  <div class="sidebar-header border-bottom">
    <div class="sidebar-brand">
      <img src="images/favicon.ico" alt="sysweb" height="25px">
    </div>
  </div>

  <ul class="sidebar-nav">
    <li class="nav-title">Menú</li>

    <?php
    // Verificar el acceso del usuario
    $current_access = $_SESSION['permisos_acceso'];

    // Menú para Super Admin
    if ($current_access == 'Super Admin') {
    ?>
      <li class="<?php echo ($_GET["module"] == "start" ? "active" : ""); ?>">
        <a href="?module=start"><i class="fa fa-home"></i> Inicio</a>
      </li>

      <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="javascript:void(0)">
          <i class="fa fa-file-text"></i> Referenciales Generales
        </a>
        <ul class="nav-group-items">
          <li><a class="nav-link" href="?module=departamento"><i class="fa fa-circle-o"></i> Departamento</a></li>
          <li><a class="nav-link" href="?module=ciudad"><i class="fa fa-circle-o"></i> Ciudad</a></li>
        </ul>
      </li>

      <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="javascript:void(0)">
          <i class="fa fa-file-text"></i> Referenciales de Compra
        </a>
        <ul class="nav-group-items">
          <li><a class="nav-link" href="?module=deposito"><i class="fa fa-circle-o"></i> Depósito</a></li>
          <li><a class="nav-link" href="?module=proveedor"><i class="fa fa-circle-o"></i> Proveedor</a></li>
          <li><a class="nav-link" href="?module=producto"><i class="fa fa-circle-o"></i> Producto</a></li>
          <li><a class="nav-link" href="?module=tipo_producto"><i class="fa fa-circle-o"></i> Tipo de producto</a></li>
          <li><a class="nav-link" href="?module=u_medida"><i class="fa fa-circle-o"></i> Unidad de Medida</a></li>
        </ul>
      </li>

      <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="javascript:void(0)">
          <i class="fa fa-file-text"></i> Referenciales de Ventas
        </a>
        <ul class="nav-group-items">
          <li><a class="nav-link" href="?module=clientes"><i class="fa fa-circle-o"></i> Clientes</a></li>
        </ul>
      </li>

      <li class="<?php echo ($_GET['module'] == "user" || $_GET['module'] == "form_user" ? "active" : ""); ?>">
        <a href="?module=user"><i class="fa fa-user"></i> Administrar Usuarios</a>
      </li>

      <li class="<?php echo ($_GET['module'] == "password" ? "active" : ""); ?>">
        <a href="?module=password"><i class="fa fa-lock"></i> Cambiar Contraseña</a>
      </li>

    <?php
    // Menú para Compras
    } elseif ($current_access == 'Compras') {
    ?>
      <li class="<?php echo ($_GET["module"] == "start" ? "active" : ""); ?>">
        <a href="?module=start"><i class="fa fa-home"></i> Inicio</a>
      </li>

      <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="javascript:void(0)">
          <i class="fa fa-file-text"></i> Referenciales Generales
        </a>
        <ul class="nav-group-items">
          <li><a class="nav-link" href="?module=departamento"><i class="fa fa-circle-o"></i> Departamento</a></li>
          <li><a class="nav-link" href="?module=ciudad"><i class="fa fa-circle-o"></i> Ciudad</a></li>
        </ul>
      </li>

      <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="javascript:void(0)">
          <i class="fa fa-file-text"></i> Referenciales de Compra
        </a>
        <ul class="nav-group-items">
          <li><a class="nav-link" href="?module=deposito"><i class="fa fa-circle-o"></i> Depósito</a></li>
          <li><a class="nav-link" href="?module=proveedor"><i class="fa fa-circle-o"></i> Proveedor</a></li>
          <li><a class="nav-link" href="?module=producto"><i class="fa fa-circle-o"></i> Producto</a></li>
          <li><a class="nav-link" href="?module=tipo_producto"><i class="fa fa-circle-o"></i> Tipo de producto</a></li>
          <li><a class="nav-link" href="?module=u_medida"><i class="fa fa-circle-o"></i> Unidad de Medida</a></li>
        </ul>
      </li>

      <li class="<?php echo ($_GET['module'] == "password" ? "active" : ""); ?>">
        <a href="?module=password"><i class="fa fa-lock"></i> Cambiar Contraseña</a>
      </li>

    <?php
    // Menú para Ventas
    } elseif ($current_access == 'Ventas') {
    ?>
      <li class="<?php echo ($_GET["module"] == "start" ? "active" : ""); ?>">
        <a href="?module=start"><i class="fa fa-home"></i> Inicio</a>
      </li>

      <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="javascript:void(0)">
          <i class="fa fa-file-text"></i> Referenciales Generales
        </a>
        <ul class="nav-group-items">
          <li><a class="nav-link" href="?module=departamento"><i class="fa fa-circle-o"></i> Departamento</a></li>
          <li><a class="nav-link" href="?module=ciudad"><i class="fa fa-circle-o"></i> Ciudad</a></li>
        </ul>
      </li>

      <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="javascript:void(0)">
          <i class="fa fa-file-text"></i> Referenciales de Ventas
        </a>
        <ul class="nav-group-items">
          <li><a class="nav-link" href="?module=clientes"><i class="fa fa-circle-o"></i> Clientes</a></li>
        </ul>
      </li>

      <li class="<?php echo ($_GET['module'] == "password" ? "active" : ""); ?>">
        <a href="?module=password"><i class="fa fa-lock"></i> Cambiar Contraseña</a>
      </li>

    <?php } ?>
  </ul>
</div>
