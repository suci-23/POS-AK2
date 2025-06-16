<?php
$id_roles = isset($_SESSION['ID_ROLE']) ? $_SESSION['ID_ROLE'] : '';
$querymainmenu = mysqli_query($config, "SELECT DISTINCT menus.* FROM menus
                              JOIN role_menus ON menus.id = role_menus.id_menu 
                              JOIN roles ON roles.id = role_menus.id_roles
                              WHERE role_menus.id_roles = '$id_roles'
                              -- AND parent_id = 0 OR parent_id = ''
                              ORDER BY urutan ASC");

$rowmainmenu = mysqli_fetch_all($querymainmenu, MYSQLI_ASSOC);

?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- <li class="nav-item">
      <a class="nav-link collapsed" href="index.html">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li> -->
    <!-- End Dashboard Nav -->

    <?php foreach ($rowmainmenu as $mainmenu): ?>

    <?php
      $id_menu = $mainmenu['id'];
      //$parent_id = $mainmenu['parent_id'];
      $querysubmenu = mysqli_query($config, "SELECT DISTINCT menus.* FROM menus
                                  JOIN role_menus ON menus.id = role_menus.id_menu
                                  JOIN roles ON roles.id = role_menus.id_roles
                                  WHERE role_menus.id_roles = '$id_roles' AND
                                  parent_id = '$id_menu' ORDER BY urutan ASC");
      ?>

    <?php if (mysqli_num_rows($querysubmenu) > 0) : ?>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#menu-<?php echo $mainmenu['id'] ?>" data-bs-toggle="collapse"
        href="#">
        <i class="<?php echo $mainmenu['icon'] ?>"></i><span><?php echo $mainmenu['nm_menu'] ?></span><i
          class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="menu-<?php echo $mainmenu['id'] ?>" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <?php while ($rowsubmenu = mysqli_fetch_assoc($querysubmenu)): ?>
        <li>
          <a href="?page=<?php echo $rowsubmenu['url'] ?>">
            <i class="<?php echo $rowsubmenu['icon'] ?>"></i><span><?php echo $rowsubmenu['nm_menu'] ?></span>
          </a>
        </li>
        <?php endwhile ?>
      </ul>
    </li><!-- End Components Nav -->

    <?php elseif (!empty($mainmenu['url'])): ?>
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?php echo $mainmenu['url'] ?>">
        <i class="<?php echo $mainmenu['icon'] ?>"></i>
        <span><?php echo $mainmenu['nm_menu'] ?></span>
      </a>
    </li>
    <!-- End Dashboard Nav -->
    <?php elseif (!empty($mainmenu['url'])): ?>
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?php echo $mainmenu['url'] ?>">
        <i class="<?php echo $mainmenu['icon'] ?>"></i>
        <span><?php echo $mainmenu['nm_menu'] ?></span>
      </a>
    </li>
    <?php endif ?>
    <?php endforeach ?>


  </ul>

</aside>
<!-- End Sidebar-->