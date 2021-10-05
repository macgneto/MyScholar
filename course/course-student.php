<?php

require '../includes/init.php';

$conn = require '../includes/db.php';

if (isset($_GET['id'])) {
    $course = Course::getByCourseID($conn, $_GET['id']);
} else {
    $course = null;
}

$student_ids = array_column($course -> getCourseStudents($conn), 'student_id');

$students = Student::getAllStudents($conn);

require '../header.php';

require '../sidebar.php';?>

<div id="layoutSidenav_content">

  <main>

        <div class="container-fluid">
        <h1 class="mt-4">Καρτέλα Μαθήματος - Μαθητών</h1>
          <ol class="breadcrumb mb-4 breadcrumb-shadow">
            <li class="breadcrumb-item"><a href="<?= basedir ?>index.php">Αρχική</a></li>
            <li class="breadcrumb-item"><a href="<?= basedir ?>courses.php">Μαθήματα</a></li>
            <li class="breadcrumb-item active">Καρτέλα Μαθήματος - Μαθητών</li>
          </ol>

          <br>
          <div class="card mb-4 border-grey">
            <div class="card-header">
                <i class='fas fa-book-open'></i>
                &nbsp;&nbsp;<strong>Καρτέλα Μαθήματος - Μαθητών: </strong> <?= ($course-> course_code);?>&nbsp;|&nbsp&nbsp;<?= htmlspecialchars($course-> course_title); ?>&nbsp;
            </div>

            <div class="card-body bg-light border-bottom-0">

                <div class="form-row">
                  <div class="form-group col-md-4 ">
                    <label for="inputCourseCode">Κωδικός Μαθήματος</label>
                    <div class="form-control">
                        <?= ($course-> course_code);?>
                    </div>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="inputCourseName">Τίτλος Μαθήματος</label>
                    <div class="form-control">
                      <?= ($course-> course_title);?>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-9 ">
                    <label for="courseCode">Περιγραφή Μαθήματος</label>
                    <div class="form-control">
                        <?= ($course-> course_description);?>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputPassword4">Ακαδημαϊκό Έτος</label>
                        <div class="form-control">
                          <?php if ($course -> course_year == "2018 - 2019") {
    echo '2018 - 2019';
} ?>
                          <?php if ($course -> course_year == "2019 - 2020") {
    echo '2019 - 2020';
} ?>
                          <?php if ($course -> course_year == "2020 - 2021") {
    echo '2020 - 2021';
} ?>
                          <?php if ($course -> course_year == "2021 - 2022") {
    echo '2021 - 2022';
} ?>
                          <?php if ($course -> course_year == "2022 - 2023") {
    echo '2022 - 2023';
} ?>
                          <?php if ($course -> course_year == "2023 - 2024") {
    echo '2023 - 2024';
} ?>
                          <?php if ($course -> course_year == "2024 - 2025") {
    echo '2024 - 2025';
} ?>
                          <?php if ($course -> course_year == "2025 - 2026") {
    echo '2025 - 2026';
} ?>
                        </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-3 ">
                    <label for="inputCourseCostHour">Κόστος ανα ώρα</label>
                    <div class="form-control">
                        <i display="block">€ </i><?= ($course-> course_cost_hour_student);?>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputCourseCostMonth">Κόστος ανα μήνα</label>
                    <div class="form-control">
                      <i display="block">€ </i><?= ($course-> course_cost_month_student);?>
                    </div>
                  </div>
                </div>

              </div>



        <div class="card-footer">

                          <div class="col-sm-12 text-center">

                            <!-- <a class="btn btn-primary" href="course-edit.php?id=<?= $course -> course_id; ?>"><i class="fas fa-edit"></i>  Επεξεργασία</a>&nbsp -->

                            <a class="btn btn-secondary border-dark" href="../courses.php"><i class="fas fa-chevron-circle-left"></i>  Πίσω</a>
                          </div>

                    </div>


      </div>










      <div class="card mb-4 border-grey">
        <div class="card-header">
          <i class="fas fa-table mr-1 fa-user-graduate"></i>
          Μαθητές
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

              <thead>

                <tr>
                  <th class="text-center align-middle">A/A</th>
                  <th class="text-center align-middle">Επίθετο</th>
                  <th class="text-center align-middle">Όνομα</th>
                  <th class="text-center align-middle">Email</th>
                  <th class="text-center align-middle">Κινητό</th>
                  <th class="text-center align-middle">Φύλλο</th>
                  <th class="text-center align-middle">Κατάσταση</th>
                </tr>
              </thead>



              <tbody>
                <?php if (empty($students)): ?>
                  <tr>
                    <td colspan="6" align="center"><b>Δεν βρέθηκαν Μαθητές</b></td>
                  </tr>

                <?php else: ?>
                  <?php $aa = 0; ?>
                  <?php foreach ($students as $student) : ?>
                    <?php if (in_array($student['student_id'], $student_ids)) : ?>
                    <tr>
                      <td width="40px" align="center"><?php echo $aa = $aa + 1;  ?></td>
                      <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_lastname"]); ?></a></td>
                      <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_firstname"]); ?></a></td>
                      <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_email"]); ?></a></td>
                      <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_mobile"]); ?></a></td>
                      <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_gender"]); ?></a></td>
                      <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_status"]); ?></a></td>
                    </tr>

                      <?php endif; ?>

                  <?php endforeach; ?>

                  <?php endif; ?>

              </tbody>

            </table>
          </div>
        </div>
      </div>






      </main>












      <?php

      require '../footer.php';

?>
