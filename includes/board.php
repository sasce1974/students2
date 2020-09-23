
<div class="text-center"><h3><?php print $board->name; ?> Board</h3></div>
    <table class="table table-striped">
        <tr>
            <form method="post" action="/board/<?php print $board->id; ?>/student/store">
                <td>New student</td>
                <td colspan="2">
                    <input type="text" name="name" placeholder="Insert Student Name"
                           class="form-control"  value="">
                </td>
                <td>
                    <button type="submit" class="btn btn-outline-secondary">Create</button>
                </td>
            </form>
        </tr>
        <tr><th>id</th><th>Name</th><th>Average grade</th><td>Delete student</td></tr>
<?php
    $user = new User();
    foreach($users as $student){
?>
        <tr>
            <td><?php print $student->id; ?></td>
            <td><a href="/board/<?php print $board->id; ?>/student/<?php print $student->id; ?>"><?php print $student->name; ?></a></td>
            <td><?php print round($user->averageGrade($student->id), 2); ?></td>
            <td><form method="post" action="/board/<?php print $board->id; ?>/student/<?php print $student->id; ?>/destroy">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
<?php } ?>
    </table>
    <div class="text-center">
<?php
        if($board->id == 1){
            print "<a href=\"/board/1/export\" class=\"btn btn-primary\">Export to JSON</a>";
        }else{
            print "<a href=\"/board/2/export\" class=\"btn btn-primary\">Export to XML</a>";
        }
?>
    </div>