<?php
session_start();
include_once('class/connection.php');
$con=new Connect;
$conn2=$con->getConnection();
$sql = "SELECT Book_id FROM book";
$result1 = $conn2->query($sql);
$bookLen=0;
while ($row = $result1->fetch_assoc()) {
    $bookLen++;
    }
$bookLen++;
$sql = "SELECT publisher FROM publisher";
$result = $conn2->query($sql);
$sql = "SELECT genre FROM genre";
$result2 = $conn2->query($sql);
$sql = "SELECT author FROM author";
$result3 = $conn2->query($sql);
if (isset($_POST['submit'])) {
    $title = $_POST["title"];
    if(!str_contains($title, ':')){
        $title=$title.':';
    }
    if($_POST["author1"]!=null){
        $author = $_POST["author1"];
    }
    else{
    $author = $_POST["author"];
    }
    $title_desc = $_POST["title_desc"];
    if($_POST["publisher1"]!=null){
        $publisher = $_POST["publisher1"];
    }
    else{
        $publisher = $_POST["publisher"];
    }
    $publish_date = $_POST["publish_date"];
    $page_no = $_POST["page_no"];
    $lang = $_POST["lang"];
    if($_POST["genre1"]!=null){
        $genre = $_POST["genre1"];
    }
    else{
    $genre = $_POST["genre"];
    }
    $bestselling = isset($_POST["bestselling"]) ? 1 : 0;
    $newrelease = isset($_POST["newrelease"]) ? 1 : 0;
    $pub=false;$gen=false;$aut=false;
    while ($row = $result->fetch_assoc()) {
        if($row['publisher']==$publisher){
            $pub=true;
        }
    }
    while ($row = $result2->fetch_assoc()) {
        if($row['genre']==$genre){
            $gen=true;
        }
    }
    while ($row = $result3->fetch_assoc()) {
        if($row['author']==$author){
            $aut=true;
        }
    }
    try {
        $conn2->autocommit(false);
    if(!$pub){
        $sql="insert into publisher(publisher)values('$publisher')";
        $res=$conn2->query($sql);
    }
    if(!$gen){
        $sql="insert into genre(genre)values('$genre')";
        $res=$conn2->query($sql);
    }
    if(!$aut){
        $sql="insert into author(author)values('$author')";
        $res=$conn2->query($sql);
    }
    $sql = "SELECT id FROM publisher WHERE publisher='$publisher'";
    $result = $conn2->query($sql);
    $publisher_id = $result->fetch_assoc()['id'];
    $sql = "SELECT id FROM genre WHERE genre='$genre'";
    $result2 = $conn2->query($sql);
    $genre_id = $result2->fetch_assoc()['id'];
    $sql = "SELECT id FROM author WHERE author='$author'";
    $result3 = $conn2->query($sql);
    $author_id = $result3->fetch_assoc()['id'];
    $id="book$bookLen";
    $escapedText = mysqli_real_escape_string($conn2, $title_desc);
    $sql = "INSERT INTO book (Book_id,Title, Description, Publisher_id, Publish_Date, Pages, Language, genre_id,author_id)
     VALUES ('$id','$title', '$escapedText', '$publisher_id', '$publish_date', '$page_no', '$lang', '$genre_id','$author_id')";
    $conn2->query($sql);


     if (isset($_FILES["img"])) {
        $img_name = $_FILES["img"]["name"];
        $img_tmp_name = $_FILES["img"]["tmp_name"];

        $img_data = file_get_contents($img_tmp_name);
        $base64_img = "data:image/jpeg;base64,".base64_encode($img_data);
        $sql1 = "INSERT INTO book_attribute (Best_selling, New_release, image,Book_id) VALUES ('$bestselling', '$newrelease', '$base64_img','$id')";
        $conn2->query($sql1);
    } 
    if (isset($_FILES["pdf"])) {
        $pdf_name = $_FILES["pdf"]["name"];
        $pdf_tmp_name = $_FILES["pdf"]["tmp_name"];

        $pdf_data = base64_encode(file_get_contents($pdf_tmp_name));
        
        $sql2 = "INSERT INTO file (pdf,Book_id) VALUES ('$pdf_data','$id')";
        $conn2->query($sql2);
    }
    $conn2->commit();

    $conn2->autocommit(true);
    header('location: admin.php');
} catch (Exception $e) {

    $conn2->rollBack();
    echo "Failed: " . $e->getMessage();
}

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
  <link rel="stylesheet" href="admin.css">

</head>
<body>
    <button class="logout"><a href="Homepage.php">Logout</a></button>
    <div class="info">
        <h2>Add New Book</h2>
        <form id="addBookForm" action="admin.php" method="post"  enctype="multipart/form-data">
            
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="author">Author:</label>
            <div class="Div">
            <select id="author" name="author" required>
                <?php
                  if ($result3->num_rows > 0) {
                  while ($row = $result3->fetch_assoc()) {
                    echo "<option value='" . $row['author'] . "'>" . $row['author'] . "</option>";
                    }
                    } else {
                        echo "<option value=''>No author Found</option>";
                     }
                 ?>
            </select>
            <input type="text" placeholder="Add new author" name="author1">
                </div>
            <label for="title_desc">Description:</label>
            <textarea id="title_desc" name="title_desc" rows="4" required></textarea>

            <label for="publisher">Publisher:</label>
            <div class="Div">
            <select id="publisher" name="publisher" required>
                <?php
                  if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['publisher'] . "'>" . $row['publisher'] . "</option>";
                    }
                    } else {
                        echo "<option value=''>No Publishers Found</option>";
                     }
                 ?>
            </select>
            <input type="text" placeholder="Add new publisher" name="publisher1">
                </div>
            <label for="publish_date">Publish Date:</label>
            <input type="date" id="publish_date" name="publish_date" required> 

            <label for="page_no">Page :</label>
            <input type="number" id="page_no" name="page_no" required>

            <label for="lang">language:</label>
                <select id="lang" name="lang" required>
                     <option value="English">English</option>
                     <option value="Spanish">Spanish</option>
                     <option value="French">French</option>   
                </select>

              <label for="genre">Genre:</label>
              <div class="Div">
              <select id="genre" name="genre" required>
                     <?php
                         if ($result2->num_rows > 0) {
                         while ($row = $result2->fetch_assoc()) {
                         echo "<option value='" . $row['genre'] . "'>" . $row['genre'] . "</option>";
                            }
                             } else {
                          echo "<option value=''>No Genres Found</option>";
                         }
                     ?>
                </select>
                <input type="text" placeholder="Add new genre" name="genre1">
                </div>
            
            <label for="bestselling">Bestselling:</label>
            <input type="checkbox" id="bestselling" name="bestselling" value="1">
            <label for="bestselling">Yes</label>
            
            <label for="newrelease">New Release:</label>
            <input type="checkbox" id="newrelease" name="newrelease" value="1">
            <label for="newrelease">Yes</label>
            
            <label for="img">Upload image:</label>
            <input type="file" id="img" name="img" accept="img/*">
            
            <label for="pdf">Upload PDF:</label>
            <input type="file" id="pdf" name="pdf" accept=".pdf">

            <input type="submit" name="submit">
        </form>
    </div>
</body>
</html>
<script>
    if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href)
}
</script>