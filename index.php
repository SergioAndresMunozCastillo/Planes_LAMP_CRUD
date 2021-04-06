<!DOCTYPE html>
    <head>
        <title>PHP CRUD</title>
        <script>"https://code.jquery.com/jquery-2.1.3.min.js"</script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php require_once 'process.php'; ?>

        <?php 
            if (isset($_SESSION['message'])):
        ?>

        <div class="alert alert-<?=$_SESSION['msg_type']?>">

                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
        </div>
        <?php endif ?>
        <?php 
        
            $mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));
            $result = $mysqli->query("SELECT * FROM planes") or die($mysqli->error);
        ?>
    <div class="container">
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>

        <?php 
            while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $row['id']; ?>"
                            class="btn btn-info">Edit</a>
                        
                        <a href="index.php?delete=<?php echo $row['id']; ?>"
                            class="btn btn-danger">Delete</a>
                    </td>
                </tr>
        <?php endwhile;?>
            </table>

        </div>

        <br>
        <br>
        <form action="process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="d-flex flex-column justify-content-center align-content-center">
        <div class="p-2 align-center">
            <label>Name</label>
        </div>
        <div class="p-2">
            <input type="text" name="name" class="form-control" id="autoSizingInput" value="<?php echo $name ?>" placeholder="Enter your name">
        </div>
            <label>Location</label>
            <input type="text" name="description" class="form-control" value="<?php echo $description ?>" placeholder="Enter your location">

            <label>Image</label>
            <input type="file" name="fileToUpload" id="fileToUpload">

        <?php if($update == true):?>

            <button type="submit" name="update" class="btn btn-info">Update</button>
        <?php else: ?>
            <button type="submit" name="save" class="btn btn-primary">Save</button>
        <?php endif; ?>

            

        </div>
        </form>
    </div>
    </body>