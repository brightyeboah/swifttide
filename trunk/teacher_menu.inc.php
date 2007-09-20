<?php
// Include configuration
include_once "configuration.php";
?>

<!--pq - 2007-02-22 - made consistent with the rest -->
<DIV id="menuSystem">
<TABLE id="mainTable">
	<tr>
		<td>
		<table>
			<tr>
			<?php
			    include_once "ez_sql.php";
				$nyear=$_SESSION['CurrentYear'];
				$cyear=$db->get_var("SELECT school_years_desc FROM school_years WHERE school_years_id=$nyear");
				?>
			   <td class ="year"><?php echo _ADMIN_MAINT_TABLES_MENU_YEAR?> <? echo $cyear; ?></td>
			</tr>
			<tr>
			   <td><hr></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
	<td><a href="teachers_menu.php" title="<?php echo _TEACHER_MENU_INC_PHP_MAIN?>"><?php echo _TEACHER_MENU_INC_PHP_MAIN_TEXT?></a></td>
	</tr>
	<tr>
	<td><a href="teacher_timetable.php" title="<?php echo _TEACHER_MENU_INC_PHP_TIMETABLE?>"><?php echo _TEACHER_MENU_INC_PHP_TIMETABLE_TEXT?></a></td>
	</tr>
	<tr>
	<td><a href="teacher_exams_1.php" title="<?php echo _TEACHER_MENU_INC_PHP_EXAMS?>"><?php echo _TEACHER_MENU_INC_PHP_EXAMS_TEXT?></a></td>
	</tr>
	<tr>
	<td><a href="teacher_speak.php" title="<?php echo _TEACHER_MENU_INC_PHP_SPEAK?>"><?php echo _TEACHER_MENU_INC_PHP_SPEAK_TEXT?></a></td>
	</tr>
	<tr>
	   <td><hr></td>
	</tr>
	<tr>
	<td>
	<a href="teacher_student_1.php" title="<?php echo _TEACHER_MENU_INC_PHP_STUDENTS?>"><?php echo _TEACHER_MENU_INC_PHP_STUDENTS_TEXT?></a></td>
	</tr>
	<tr>
	<td><a href="teacher_manage_attendance_1.php?studentid=<?echo $studentid; ?>" title="<?php echo _TEACHER_MENU_INC_PHP_ATTENDANCE?>"><?php echo _TEACHER_MENU_INC_PHP_ATTENDANCE_TEXT?></a></td>
	</tr>
	<tr>
	<td><a href="teacher_manage_discipline_1.php?studentid=<?echo $studentid; ?>" title="<?php echo _TEACHER_MENU_INC_PHP_DISCIPLINE?>"><?php echo _TEACHER_MENU_INC_PHP_DISCIPLINE_TEXT?></a></td>
	</tr>
	<tr>
	<td><a href="teacher_manage_grades_1.php?studentid=<?echo $studentid; ?>" title="<?php echo _TEACHER_MENU_INC_PHP_SINGLE?>"><?php echo _TEACHER_MENU_INC_PHP_SINGLE_TEXT?></a></td>
	</tr>
	<tr>
	<td><a href="grade_student_1.php" title="<?php echo _TEACHER_MENU_INC_PHP_BULK?>"><?php echo _TEACHER_MENU_INC_PHP_BULK_TEXT?></a></td>
	</tr>
	<tr>
	<td><a href="teacher_change_student_year.php" title="<?php echo _TEACHER_MENU_INC_PHP_YEAR?>"><?php echo _TEACHER_MENU_INC_PHP_YEAR_TEXT?></a></td>
	</tr>
				<tr>
			   <td><hr></td>
			</tr>
	<tr>
	<td><a href="teachers_homework.php" title="<?php echo _TEACHER_MENU_INC_PHP_HOMEWORK?>"><?php echo _TEACHER_MENU_INC_PHP_HOMEWORK_TEXT?></a></td>
	</tr>

	<tr>
	<td><a href="displayforum.php?forumid=SCHOOL&position=0&sort_by=date_posted&order=desc" title="<?php echo _TEACHER_MENU_INC_PHP_FORUM?>"><?php echo _TEACHER_MENU_INC_PHP_FORUM_TEXT?></a></td>
	</tr>
	<tr>
	<td><a href="teacher_chat.php" title="<?php echo _TEACHER_MENU_INC_PHP_CHAT?>"><?php echo _TEACHER_MENU_INC_PHP_CHAT_TEXT?></a></td>
	</tr>
			<tr>
			   <td><hr></td>
			</tr>
	<tr>
	<td><a href="teacher_change_password.php" title="<?php echo _TEACHER_MENU_INC_PHP_CHANGE?>"><?php echo _TEACHER_MENU_INC_PHP_CHANGE_TEXT?></a></td>
	</tr>
					<tr>
			   <td><hr></td>
			</tr>

	<tr>
	<td><a href="logout.php" title="<?php echo _TEACHER_MENU_INC_PHP_LOGOUT?>"><?php echo _TEACHER_MENU_INC_PHP_LOGOUT_TEXT?></a></td>
	</tr>
</div>
