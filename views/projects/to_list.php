<br/>
<a class="btn btn-primary" href="./create">Add new project</a>
<br/><br/>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($projects as $project) { ?>
            <tr>
                <td><?php echo $project['id']; ?></td>
                <td><?php echo $project['name']; ?></td>
                <td>
                    <img class="img-thumbnail" src="img/<?php echo $project['image']; ?>" width="100" />   
                </td>
                <td>
                    <form action="./edit" class="d-inline" method="get">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $project['id']; ?>" />
                        <button type="submit" class="btn btn-info">Edit</button>
                    </form>
                    |
                    <form action="./delete" class="d-inline" method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $project['id']; ?>" />
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>