<?php

require 'includes/init.php';

Auth::requireLogin();

$conn = require 'includes/db.php';


// Checking Teacher Access to each classroom. If the teacher is teaching the class then access granted. Else redirect to classrooms.php
// if (Auth::isTeacher()) {
//     $teacher_classes = TeacherCourses::getTeacherClassesByTeacherId($conn, $_SESSION['user_id']);
//
//     $data_id = array();
//
//     foreach ($teacher_classes as $teacher_class) {
//         array_push($data_id, $teacher_class['class_id']);
//     }
//
//     $get_id = $_SESSION['user_id'];
//
//     if (in_array($get_id, $data_id, true)) {
//     } else {
//         // Url::redirect("/main/classrooms.php");
//     }
//     // var_dump($teacher_classes);
//     var_dump($data_id);
// }



if (Auth::isTeacher()) {
    $classes = Classes::getAllClassesForTeacherOnly($conn, $_SESSION['user_id']);
} elseif (Auth::isStudent()) {
    $classes = Classes::getAllClassesForStudentOnly($conn, $_SESSION['user_id']);
} else {

    $classes = Classes::getAllClasses($conn);
}




$courses = Course::getAllCourses($conn);

$teachers = Teacher::getAllTeachers($conn);

$class_edit = Classes::getByClassID($conn, $_GET["class_id"]);

$class_id = $_POST["class_id"];




$count =  Classes::countStudentsInClassByID($conn, $class_id);



require 'header.php';

require 'sidebar.php';

require 'data.php';
?>






<div id="layoutSidenav_content">



	<main>



		<!-- Create new Classroom -->
		<script type="text/javascript">
			$(document).ready(function(){
				$("#class_course_id").change(function(){
					var aid = $("#class_course_id").val();
					$.ajax({
						url: 'data.php',
						method: 'post',
						data: 'aid=' + aid
					}).done(function(teachers){
						console.log(teachers);
						teachers = JSON.parse(teachers);
						$('#dropdownClassTeacher').empty();
						teachers.forEach(function(teacher){
							$('#dropdownClassTeacher').append('<option name="class_course_id" value="'+ teacher.tc_teacher_id +'">' + teacher.teacher_lastname + ' ' + teacher.teacher_firstname +'</option>')
						})
					})
				})
			})
		</script>



    	<!-- Modal Add Class-->
    	<div class="modal fade" id="add_class_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      	<div class="modal-dialog " role="document">
        	<div class="modal-content">
	          	<div class="modal-header">
	            	<h5 class="modal-title" id="exampleModalLabel">Δημιουργία νέου Τμήματος</h5>
	            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              	<span aria-hidden="true">&times;</span>
	            	</button>
	          	</div>

	          	<form class="needs-validation" action="class/class-actions.php" method="post" novalidate>
		          	<div class="modal-body">
		                <div class="alert alert-primary" role="alert">
		                  	Εισάγετε κωδικό και όνομα τμήματος και επιλέξτε μάθημα και καθηγητή.
		                </div>

		                <div class="form-row">
		                    <div class="form-group col-md-6">
		                		<label for="inputClassCode">Κωδικός Τμήματος</label>
		                		<input type="text" name="class_code" class="form-control" id="inputClassCode" required>
		                	</div>
		             		<div class="form-group col-md-6">
		        				<label for="inputClassName">Όνομα Τμήματος</label>
		                    	<input type="text" name="class_name" class="form-control" id="inputClassName" required>
		                	</div>
		                </div>

		            	<div class="form-group">
		             		<label for="inputClassDescription">Περιγραφή</label>
		     				<input type="text" class="form-control" name="class_description" id="inputClassDescription" placeholder="Περιγραφή" required>
		                </div>

		                <div class="form-row">
		                    <div class="form-group col-md-12">
		         				<label for="inputClassCourse">Επιλέξτε Μάθημα</label>
		                        <select  name="class_course_id" id="class_course_id" class="form-control" required>
		                        	<option  value="" >Επιλέξτε...</option>
		                              	<?php
                                            $courses = loadCourses($conn);
                                            foreach ($courses as $course) {
                                                echo "<option id='".$course['course_id']."' value='".$course['course_id']."'>".$course['course_code']." | ".$course['course_title']."</option>";
                                            }
                                        ?>
		                        </select>
		                 	</div>

		                    <div class="form-group col-md-12">
		                    	<label for="inputClassTeacher">Επιλέξτε Καθηγητή</label>
		                        <select name="class_teacher_id" id="dropdownClassTeacher" class="form-control">
		                           	<option  required disabled>Επιλέξτε...</option>
		                        </select>
		                    </div>
		                </div>
		          	</div>

		          	<div class="modal-footer">
		            	<button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
		            	<button type="submit" name="add_class" class="btn btn-success border-dark"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
		          	</div>
	          	</form>
        	</div>
      	</div>
    	</div>
		<!-- End modal Add Class -->


		<div class="container-fluid">
					<div class="row row-breadcrumb">
		                <div class="col p-0 m-0">
		                    <div class="card-breadcrumb  py-1">

		                        <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-chalkboard-teacher"></i>  Τμήματα </h3>

		                        <!-- <ol class="breadcrumb m-2 border-bottom-radius-7"> -->
		                            <ol class="breadcrumb m-3 ">
		                            <li class="breadcrumb-item"><a class="text-info" href="index.php">Αρχική</a></li>
		                            <li class="breadcrumb-item active">Τμήματα</li>
		                        </ol>
		                    </div>
		                </div>
		            </div>



<br>


<?php if (Auth::isAdmin() || Auth::isSecretary()) : ?>
<div class="">



    	<div class="card-body no-border">
            <button type="button" class="btn  btn-info  border-button " data-toggle="modal" data-target="#add_class_modal">
              	<i class="fas fa-plus-circle"></i>&nbsp&nbsp</i>Δημιουργία Τμήματος
            </button>
        </div>

</div>
<?php endif; ?>


      	<div class="card mb-4">


        	<div class="card-body">


          	<div class="table-responsive">
            	<table class="table table-bordered table-hover table-ocean bg-light full-gradient-bg-info  border-radius-7 " id="dataTable" width="100%" cellspacing="0">

	              	<thead>
						<div class="mb-2 text-info">
							<h6 class="text-center">
								<i class="fas fa-chalkboard-teacher"></i>
								<!-- <i class="fas fa-shapes"></i> -->
								Λίστα Τμημάτων
							</h6>
						</div>
	                	<tr>
		                  	<th class="text-center align-middle">A/A</th>
		                  	<th class="text-center align-middle">Κωδικός Τμήματος</th>
		                  	<th class="text-center align-middle">Τίτλος Τμήματος</th>
		                  	<th class="text-center align-middle">Κωδικός Μαθήματος</th>
		                  	<th class="text-center align-middle">Τίτλος Μαθήματος</th>
		                  	<th class="text-center align-middle">Διδάσκων</th>
		                  	<th class="text-center align-middle">Μαθητές</th>

		                  	<th class="text-center align-middle" width="100px">Ενέργειες</th>

	                	</tr>

	              	</thead>

              		<tbody>

	                	<?php if (empty($classes)): ?>
	                  		<tr>
	                    		<td colspan="6" align="center"><b>Δεν βρέθηκαν Τμήματα</b></td>
	                  		</tr>

	                	<?php else: ?>
	                  		<?php $aa = 0; ?>
	                  	<?php foreach ($classes as $class) : ?>


		        			<tr>
		                      	<td width="40px" class="text-center align-middle"><?php echo $aa = $aa + 1;  ?></td>
		                      	<td class="text-center align-middle"><?= htmlspecialchars($class["class_code"]); ?></td>
		                      	<td class="text-center align-middle"><?= htmlspecialchars($class["class_name"]); ?></td>
		                      	<td class="text-center align-middle"><a href="course/course-view.php?id=<?= $class["class_course_id"]; ?>" class="text-purple"><?= ($class["course_code"]); ?></a></td>
		                  		<td class="text-center align-middle"><a href="course/course-view.php?id=<?= $class["class_course_id"]; ?>" class="text-purple"><?= ($class["course_title"]); ?></a></td>
		                      	<td class="text-center align-middle"><a href="teacher/teacher-profile.php?id=<?= $class["class_teacher_id"]; ?>" class="text-success"><?= ($class["teacher_firstname"]);?>&nbsp<?= ($class["teacher_lastname"]); ?></a></td>
		                      	<td class="text-center align-middle"><?= $count_students = Classes::countStudentsInClassByID($conn, $class['class_id']); ?></td>
		                      	<td class="text-center align-middle" >

									<!-- Button HTML (to Trigger Modal Edit Classroom) -->
									<div class="box-body">
                                        <?php if (Auth::isStudent()) : ?>

                                        <?php else: ?>
										<a class="btn btn-white btn-sm button-rounded " href="class/class-view.php?id=<?= $class["class_id"]; ?>" role="button" data-toggle="tooltip" data-placement="top" title="Προβολή" ><i class="fas fa-eye text-info"></i></a>
                                    <?php endif; ?>
                                        <?php if (Auth::isAdmin() || Auth::isSecretary()) : ?>

										<span data-toggle="tooltip" data-placement="top" title="Επεξεργασία" >
										<button type="button" name="submit" value="<?= $class["class_id"];?>"
		   								class="btn btn-white btn-sm button-rounded mr-1" data-toggle="modal" data-target="#edit-class-modal-<?= $class["class_id"];?>"><i class="fas fa-edit text-orange"></i>
										</span>


										<!-- Delete button show only for admin -->
										    <?php if (Auth::isAdmin()) :?>
									        <button type="button" name="submit2" value="<?= $class["class_id"];?>"
	   								        class="btn btn-white btn-sm button-rounded" data-toggle="modal" data-target="#delete-class-modal-<?= $class["class_id"];?>"><i class="fas fa-trash text-danger"></i>
								            <?php endif; ?>


								<?php endif; ?>
								</div>


									<!-- Modal Edit Classroom-->
									<div class="modal fade" id="edit-class-modal-<?= $class["class_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  							<div class="modal-dialog " role="document">
									<div class="modal-content">

		      							<div class="modal-header">
		        							<h5 class="modal-title" id="exampleModalLabel">Επεξεργασία στοιχείων Τμήματος</h5>
		        							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          								<span aria-hidden="true">&times;</span>
		        							</button>
		      							</div>

		  								<form action="class/class-actions.php" method="post" class="needs-validation" novalidate>

			          						<div class="modal-body">

			           							<div class="alert alert-warning" role="alert">
			                  						Παρακάτω μπορείτε να διορθώσετε τα στοιχεία που επιθυμείτε. Οι αλλαγές που θα κάνετε θα αποθηκευτούν μόνιμα.
			                					</div>

			                					<div class="form-group">
			                						<input type="hidden" class="form-control" name="class_id" id="inputClassDescription" placeholder="Περιγραφή" value="<?= htmlspecialchars($class['class_id']);?>">
												</div>

												<div class="form-row">

													<div class="form-group col-md-6">
		                      							<label for="inputClassCode">Κωδικός Τμήματος</label>
		                      							<input type="text" name="class_code" class="form-control" id="inputClassCode" value="<?= htmlspecialchars($class['class_code']);?>" required>
		                      							<div class="invalid-feedback">
		                        							Το πεδίο δεν μπορεί να είναι κενό.
		                      							</div>
		                    						</div>
		                    						<div class="form-group col-md-6">
		                      							<label for="inputClassName">Όνομα Τμήματος</label>
		                      							<input type="text" name="class_name" class="form-control" id="inputClassName" value="<?= htmlspecialchars($class['class_name']);?>">
		                							</div>

		                    					</div>

		                    					<div class="form-group">
		                    						<label for="inputClassDescription">Περιγραφή</label>
		                    						<input type="text" class="form-control" name="class_description" id="inputClassDescription" placeholder="Περιγραφή" value="<?= htmlspecialchars($class['class_description']);?>">
		                    					</div>

												<div class="form-group">
		                    						<label for="inputClassDescription">Μάθημα</label>

													<?php foreach ($courses as $course):  ?>
													  	<?php if ($course['course_id'] == $class['class_course_id']) : ?>


															<input type="text" disabled class="form-control" name="course_title" id="inputClassName" placeholder="Περιγραφή" value="<?= $course["course_code"]. " | " .$course["course_title"]; ?>">

													  	<?php endif; ?>

															<?php endforeach; ?>



		                    					</div>



												<div class="form-group">
													<label for="inputClassDescription">Καθηγητής</label>
													<?php foreach ($teachers as $teacher):  ?>
													  	<?php if ($teacher['teacher_id'] == $class['class_teacher_id']) : ?>


													  	<input type="text" disabled class="form-control" name="teacher_name" id="inputClassName" placeholder="Περιγραφή" value="<?= $teacher["teacher_lastname"]. " " .$teacher["teacher_firstname"]; ?>">
													  	<?php endif; ?>

													<?php endforeach; ?>

												</div>






			          						</div>

			          						<div class="modal-footer">
			            						<button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
			            						<button type="submit" name="edit_class" class="btn btn-success border-dark" value="<?= $class["class_id"]; ?>"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
			          						</div>










		  								</form>
		    						</div>
		  							</div>
									</div>



























									<div class="modal fade" id="delete-class-modal-<?= $class["class_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  							<div class="modal-dialog " role="document">
									<div class="modal-content">

		      							<div class="modal-header">
		        							<h5 class="modal-title" id="exampleModalLabel">Διαγραφή Τμήματος</h5>
		        							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          								<span aria-hidden="true">&times;</span>
		        							</button>
		      							</div>

		  								<form action="class/class-actions.php" method="post" class="needs-validation" novalidate>

			          						<div class="modal-body">


												<input type="hidden" name="class_id" value="<?= $class["class_id"];?>">

												<div class="alert alert-danger" role="alert">
												  <h4 class="alert-heading">Επιβεβαίωση Διαγραφής</h4>
												  <p>Είστε σίγουροι οτι θέλετε να διαγράψετε το τμήμα με τα παρακάτω στοιχεία;</p>
												  <hr>
												  <p class="mb-0"><?= "Κωδικός τμήματος: " . $class['class_code'];?></p>
												  <p class="mb-0"><?= "Όνομα τμήματος: " . $class['class_name'];?></p>
												  <p class="mb-0"><?= "Περιγραφής τμήματος: " . $class['class_description'];?></p>
												</div>














			          						</div>

			          						<div class="modal-footer">
			            						<button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
			            						<button type="submit" name="delete_class" class="btn btn-success border-dark" value="<?= $class["class_id"]; ?>"><i class="fas fa-save"></i>&nbsp&nbspΕπιβεβαίωση</button>
			          						</div>










		  								</form>
		    						</div>
		  							</div>
									</div>

		                      	</td>

							</tr>

	                  	<?php endforeach; ?>

	                  	<?php endif; ?>

              		</tbody>

            	</table>
          	</div>
        	</div>

      	</div>

  		</div>




    </main>

<?php

require 'footer.php';

?>
