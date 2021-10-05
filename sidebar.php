

<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
        <div class="nav">
          <div class="sb-sidenav-menu-heading">Core</div>
          <a class="nav-link" href="<?= basedir ?>index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-school "></i></div>
            Αρχική
          </a>
          <!-- <div class="sb-sidenav-menu-heading">Interface</div>
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            Layouts
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
          </a>
          <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link" href="layout-static.html">Static Navigation</a>
              <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
            </nav>
          </div>
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
            Pages
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
          </a> -->
          <!-- <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                Authentication
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="login.html">Login</a>
                  <a class="nav-link" href="register.html">Register</a>
                  <a class="nav-link" href="password.html">Forgot Password</a>
                </nav>
              </div>
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                Error
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="401.html">401 Page</a>
                  <a class="nav-link" href="404.html">404 Page</a>
                  <a class="nav-link" href="500.html">500 Page</a>
                </nav>
              </div>
            </nav>
          </div> -->
          <div class="sb-sidenav-menu-heading">ΧΡΗΣΤΕΣ</div>
          <?php if (Auth::isAdmin() || Auth::isSecretary() ) : ?>
          <a class="nav-link" href="<?= basedir ?>teachers.php">
            <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
            Καθηγητές
          </a>
      <?php elseif (Auth::isTeacher()): ?>
          <a class="nav-link" href="<?= basedir ?>teachers.php">
            <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
            Το προφίλ μου
          </a>
      <?php endif; ?>

            <?php if (Auth::isAdmin() || Auth::isSecretary() || Auth::isTeacher()) : ?>
          <a class="nav-link" href="<?= basedir ?>student.php">
            <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
            Μαθητές
          </a>
      <?php else: ?>
          <a class="nav-link" href="<?= basedir ?>student.php">
            <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
            Το προφίλ μου
          </a>
      <?php endif; ?>

          <div class="sb-sidenav-menu-heading">ΕΚΠΑΙΔΕΥΣΗ</div>
          <a class="nav-link" href="<?= basedir ?>courses.php">
            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
            Μαθήματα
          </a>

          <a class="nav-link" href="<?= basedir ?>classrooms.php">
            <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            Τμήματα
          </a>

          <!-- <div class="sb-sidenav-menu-heading">ΟΙΚΟΝΟΜΙΚΑ</div>
          <a class="nav-link" href="<?= basedir ?>payment.php">
            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
            Πληρωμές
          </a> -->
        </div>
      </div>
      <div class="sb-sidenav-footer">
        <div class="small"> &nbsp</div>

        &nbsp
      </div>
    </nav>
  </div>
