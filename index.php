<?php
require "init.php";
//static $i = 1;

?>

<!DOCTYPE html>
<html>

<head>
  <title>Import CSV File Into MYSQL Database using PHP</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  <br />
  <div class="container">
    <h2>Import CSV File into Database using PHP</a></h2>
    <br />

    <form method="POST" enctype='multipart/form-data'>
      <p>
        <label>Create DB</label>
        <input type="submit" name="creatdb" class="btn-info" value="create db" />
      </p>
    </form>
    <br>
    <form method="POST" enctype='multipart/form-data'>
      <p>
        <label>Please Select (.CSV) File)</label>
        <input type="file" name="file" />
        <input type="submit" name="import" class="btn-info" value="Import" />
      </p>
    </form>

    <form method="POST" enctype='multipart/form-data'>
      <p>
        <label>Reset All: </label>
        <input type="submit" name="reset" class="btn-danger" value="Rest All" />
      </p>
    </form>

    <br/>
    <label class="text-success"><?php echo $success_msg; ?></label>
    <label class="text-danger"><?php echo $error_msg; ?></label>

    <h3>Data From Database:</h3>
    <br/>

    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php
        for ($page = 1; $page <= $number_of_pages; $page++) {
          echo '<li class="page-item"><a href="?page=' . $page . '" class="page-link">' .  $page  . ' ' . '</a></li>';
        }
        ?>
      </ul>
    </nav>

    <div class="table-responsive">
      <!-- Table  -->
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">id</th>
            <th scope="col">client_id</th>
            <th scope="col">client</th>
            <th scope="col">deal_id</th>
            <th scope="col">deal</th>
            <th scope="col">hour</th>
            <th scope="col">accepted</th>
            <th scope="col">refused</th>
          </tr>
        </thead>
        <tbody>
          <?php

          if ($result) {
            while ($row = mysqli_fetch_array($result)) {  ?>
              <tr>
                <td class="serial"><?php echo $row['ID']; ?></td>
                <th><?php echo $row['client_id']; ?></th>
                <td><?php echo $row['client']; ?></td>
                <td><?php echo $row['deal_id']; ?></td>
                <td><?php echo $row['deal']; ?></td>
                <td><?php echo $row['hour']; ?></td>
                <td><?php echo $row['accepted']; ?></td>
                <td><?php echo $row['refused']; ?></td>
              </tr>
          <?php
            }
          } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>