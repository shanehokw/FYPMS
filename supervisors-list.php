<?php
require_once 'header.php';
?>

<div class="position-relative">
    <div class="position-absolute top-0 start-50 translate-middle-x my-3">
        <h1 class="mt-5 mb-1 fw-bold">List of ICT Supervisors</h1>
        <div class="mb-5 fst-italic">Click on supervisor names to view their profile.</div>
        <div class="table-responsive">
            <table class="table table-striped" style="width:80rem;">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Research Area(s)</th>
                        <th scope="col">Email</th>
                        <th scope="col">Quota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $supervisorDetailsList = getAllSupervisors($con);

                    if (!empty($supervisorDetailsList)) {
                        // get current semester
                        $thisYear = date('Y');
                        $thisMonth = date('n');

                        // if within April and September, set semester as 4, else set as 9
                        $semesterMonth = ($thisMonth >= 4 && $thisMonth < 9) ? 4 : 9;
                        $thisSemester = $thisYear . "0" . $semesterMonth;
                        $quota = getSupervisorStudentQuota($con, $thisSemester);

                        foreach ($supervisorDetailsList as $supervisorDetails) {
                            echo
                            '<tr>
                                <td><a href="profile.php?id=' . $supervisorDetails["supervisorID"] . '">';
                            echo $supervisorDetails["name"] == "" ? $supervisorDetails['supervisorID'] : $supervisorDetails['name'];
                            echo '</a></td><td>';
                            echo $supervisorDetails["research_areas"] == "" ? "Not set yet." : $supervisorDetails['research_areas'];
                            echo '</td><td>';
                            echo $supervisorDetails["email"] == "" ? "Not set yet." : $supervisorDetails["email"];
                            echo '</td>';

                            $studentCount = countStudentsForSupervisor($con, $supervisorDetails["supervisorID"]);

                            // if a quota had not yet been set for the semester print 'no quota set yet', else print the current student count and quota
                            echo (!$quota) ? '<td>No quota set yet</td>' : '<td>' . $studentCount . ' / ' . $quota . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">No supervisors yet.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>