<div class="d-flex justify-content-center">
    <h3>
        <a href="/board/<?php print $board->id; ?>">
            <?php print $board->name; ?>
        </a>
    / </h3>
<h3><?php print $student->name; ?></h3>
</div>
<table class="table table-striped">
    <tr>
        <form method="post" action="/student/<?php print $student->id; ?>/grade/store">
            <td class="text-right"><h5>Insert New Grade</h5></td>
            <td>
                <input type="number" min="1" max="10" name="grade"
                       class="form-control">
            </td>
            <td><button type="submit" class="btn btn-outline-success">Insert</button></td>
        </form>
    </tr>
    <tr>
        <th class="text-center">Grade</th>
        <th>Added</th>
        <th>Delete</th>
    </tr>
    <?php
    $user = new User();
    $grades = $user->grades($student->id);
    foreach($grades as $grade){
        ?>
    <tr>
        <td class="text-center"><?php print $grade['grade']; ?></td>
        <td><?php print date('d.m.Y', strtotime($grade['created_at'])); ?></td>
        <td><form action="/student/grade/<?php print $grade['id']; ?>/destroy" method="post">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </td>
    </tr>
<?php } ?>
    <tr class="font-weight-bold">
        <?php
        if($board->id == 1){
            $ag = $user->averageGrade($student->id)
        ?>
        <td class="text-right">Average Grade:</td>
        <td><?php print round($ag, 2); ?></td>
        <td><?php print $ag < 7 ?
                '<div class="text-danger">Failed</div>' :
                '<div class="text-success">Passed</div>'; ?>
        </td>
        <?php }else{
            $hg = $user->maxGrade($student->id);
            ?>
        <td class="text-right">Highest Grade:</td>
        <td><?php print $hg; ?></td>
        <td>
            <?php
            if(count($user->grade($student->id)) > 2 && $hg >= 8){
                print 'Passed';
            }else{
                print 'Failed';
            }
            ?>
        </td>
        <?php } ?>
    </tr>
</table>
