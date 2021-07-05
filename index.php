<?php
// INSERT INTO `inotes` (`SL.no.`, `Title`, `Description`, `Timestamp`) VALUES (NULL, 'Prithul', 'good boy', current_timestamp());
$insert=false;
$update=false;
$delete=false;
$severname="localhost";
 $username="root";
 $passward="";
 $database="notes";


$conn = mysqli_connect($severname,$username,$passward,$database);


if(!$conn){
    die("oops!!!failed to connect<br>".mysqli_connect_error());
}
// echo $_POST['slnoedit'];
// echo $_GET['update'];
// exit();
if (isset($_GET['delete'])) {
  $sno=$_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `inotes` WHERE `inotes`.`SL.no.` ='$sno';";
  $result=mysqli_query($conn,$sql);
}
if($_SERVER['REQUEST_METHOD']=='POST'){
  if (isset( $_POST['slnoedit'])){
    $sno=$_POST["slnoedit"];
    $title = $_POST["titleedit"];
  $description = $_POST["descriptionedit"];
  $sql = "UPDATE `inotes` SET `Title` = '$title', `Description` = '$description' WHERE `inotes`.`SL.no.` = $sno;";
  $result=mysqli_query($conn,$sql);
  if($result){
    // echo "Record has been created succesfully<br>";
    $update=true;
}
else{
    echo "Record has not been updated succesfully,becuse the error is---->>>".mysqli_error($conn);
 }
} 
  else {
    
    $title = $_POST["title"];
    $description = $_POST["description"];
    $sql = "INSERT INTO `inotes` (`Title`, `Description`) VALUES ('$title','$description');";
    $result=mysqli_query($conn,$sql);
    if($result){
        // echo "Record has been created succesfully<br>";
        $insert=true;
    }
    else{
        echo "Record has not been created  created succesfully,becuse the error is---->>>".mysqli_error($conn);
     }
  } 
   

}
?>





<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    

  <title>iNotes - Notes taking made easy</title>
  
  <style>
  h1{
    text-align: center;
  
  }

  </style>
</head>

<body>

<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Modal
</button> -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="/phptuts/CRUD/index.php" 
        method="post">
      <div class="modal-body">
        <input type="hidden" name="slnoedit" id="slnoedit">
          <div class="mb-3">
            <label for="title" class="form-label">Note title</label>
            <input type="text" name="titleedit" class="form-control" id="titleedit" aria-describedby="emailHelp">
    
          </div>
          <div class="formtextarea">
            <label for="Textarea2">Note description</label>
            <textarea class="form-control" id="descriptionedit" name="descriptionedit" rows="3"></textarea>
          </div>
    
          <button type="submit" class="btn btn-primary my-4">Update Note</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
        </form>
    </div>
  </div>
</div>
<h1>
  Welcome to
  <small class="text-muted">iNote Application</small>
</h1>

<?php

if($insert){
  echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!!!</strong> Your note has been <strong>inserted</strong> successfuly.
  <button type='button' class='btn-close' data-bs-dismiss=alert' aria-label='Close'></button>
</div>";
}
elseif ($update) {
  echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!!!</strong> Your note has been<strong> updated</strong> successfuly.
  <button type='button' class='btn-close' data-bs-dismiss=alert' aria-label='Close'></button>
</div>";
}
elseif ($delete) {
  echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!!!</strong> Your note has been<strong> deleted</strong> successfuly.
  <button type='button' class='btn-close' data-bs-dismiss=alert' aria-label='Close'></button>
</div>";
}
?>



  <div class="container my-4">
    <h2>Add a note</h2>
    <form action="/phptuts/CRUD/index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note title</label>
        <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp">

      </div>
      <div class="formtextarea">
        <label for="Textarea2">Note description</label>
        <textarea class="form-control" id="Textarea2" name="description" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-primary my-4">Add Note</button>
    </form>
  </div>


  <div class="container">

    

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sl.No.</th>
          <th scope="col">Title</th>
          <th scope="col">Descriptions</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php

        $sql="SELECT * FROM `inotes`";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
          $Slno=0;
          while($row=mysqli_fetch_assoc($result)){
            $Slno=$Slno+1;
              echo"<tr>
              <th scope='row'>".$Slno."</th>
              <td>".$row['Title']."</td>
              <td>".$row['Description']."</td>
              <td><button class='delete btn btn-sm btn-primary' id=d".$row['SL.no.'].">Delete</button> <button class='edit btn btn-sm btn-primary' id=".$row['SL.no.'].">Edit</button>
            </tr>";
            
              
          }
      }



        ?>
        
      </tbody>
    </table>











  </div>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>
  <script>
   edits = document.getElementsByClassName('edit');
   Array.from(edits).forEach((element)=>{
     element.addEventListener("click",(e)=>{
       console.log("edit ",);
       tr=e.target.parentNode.parentNode;
       title=tr.getElementsByTagName("td")[0].innerText;
       description=tr.getElementsByTagName("td")[1].innerText;
       console.log(title, description);
       titleedit.value=title;
       descriptionedit.value=description;
       slnoedit.value=e.target.id;
       console.log(e.target.id)
       $('#editModal').modal('toggle');


   })

   })
  


   deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/phptuts/CRUD/index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })



  //  deletes = document.getElementsByClassName('delete');
  //  Array.from(deletes).forEach((element)=>{
  //    element.addEventListener("click",(e)=>{
  //      console.log("delete ",);
  //      sno=e.target.id.substr(1,);
  //      if(confirm("Are you sure to delete this note?")){
  //        console.log("yes");
  //        window.location=`/phptuts/CRUD/index.php?delete=${sno}`;
  //      }
  //      else{
  //        console.log("no");
  //      }


  //  })

  //  })
  
    
  </script>  

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>