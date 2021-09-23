<br/>
<form action="./edit" method="post" enctype="multipart/form-data">
    <div class="card">
        <div class="card-header">
            Projects
        </div>
        <div class="card-body">
            <div class="form-group">
              <label for="txtID">ID:</label>
              <input readonly type="text" class="form-control" value="<?php echo $project['id']; ?>" name="txtID" id="txtID" placeholder="Id of project">
            </div>

            <div class="form-group">
              <label for="txtName">Name:</label>
              <input type="text" class="form-control" value="<?php echo $project['name']; ?>" name="txtName" id="txtName" placeholder="Project name">
            </div>

            <div class="form-group">
              <label for="">Image:</label>
              <br/>
              <img class="img-thumbnail" src="img/<?php echo $project['image']; ?>" width="100" /> 
              <br/>
              <input type="file" class="form-control" name="txtImage" id="txtImage" placeholder="Select the image">
            </div>
        </div>
        <div class="card-footer text-muted">
            <button type="submit" name="" id="" class="btn btn-success" btn-lg btn-block>Modify</button>
            <a class="btn btn-danger" href="./" role="button">Cancel</a>
        </div>
    </div>
</form>