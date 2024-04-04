<?php
include_once('header.php');
include_once('class/connection.php');
$con = new Connect(); 
$conn = $con->getConnection();
$stmt = $conn->prepare("SELECT 
b.*, 
a.*,
p.*,
ba.*,
g.*
FROM book b
LEFT JOIN author a ON b.author_id = a.id
LEFT JOIN publisher p ON b.Publisher_id = p.id
LEFT JOIN book_attribute ba ON b.Book_id = ba.Book_id  
LEFT JOIN genre g ON b.genre_id = g.id");
$stmt->execute();
$result = $stmt->get_result();
$bookId = $_GET['id'];
$booksArray = [];
while($row = $result->fetch_assoc()) {
  $booksArray[] = $row; 
}
$userid=null;
if(isset($_SESSION['user_id'])){
    $userid=$_SESSION['user_id'];
}

$sql = "SELECT pdf FROM file WHERE Book_id='$bookId'";
$result = $conn2->query($sql);
if($result!=null){
    $book_name = $result->fetch_assoc()['pdf'];
/* $book_name='books/'.$book_name;
$base64=base64_encode(file_get_contents($book_name)); */
$base64=$book_name;
$base64JSON = json_encode($base64);
}
$user_idJSON = json_encode($userid);
$booksJSON = json_encode($booksArray);
?>
        <main class="bookdesmain">
            <img src="" alt="" class="BookIMG">
            <div class="bookdesmain1">
            <h2 class="BookTitle"></h2>
            <h4 class="BookAuthor"></h4>
            <div class="Product_Details">
                <h3>Book Details</h3>
                    <div>Publisher &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="Publisher"></span></div>
                    <div>Publish Date &nbsp;&nbsp;<span class="Publish_Date"></span></div>
                    <div>Pages &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="Pages"></span></div>
                    <div>Language&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="Language"></span></div>
                    <button class="download">Download</button>
            </div>
            
            <div>
            <h3 class="Book_Description">Book Description</h3>
            <p class="BookDescription"></p>
            </div>
            </div>
            
        </main>
        <div class="RelatedBooks">
            <h2 style="margin-left: 30px;">EDITOR'S CHOICE (<a href="book.php" class="books">view all</a>)</h2>
            <div class="RelatedBooks1" >
            </div>
        </div>
<?php
include_once('footer.php');
?>
<script>
  var booksArray = <?php echo $booksJSON; ?>;
  var user_id = <?php echo $user_idJSON; ?>;
  var base64 = <?php echo $base64JSON; ?>;
  const bookId = new URLSearchParams(window.location.search).get('id');
    var BOOKgenre;
    var BOOKtitle;
    openBookDes(bookId)
function openBookDes(id) {
    var BookTitle=document.querySelector('.BookTitle')
    var BookIMG=document.querySelector('.BookIMG')
    var BookDescription=document.querySelector('.BookDescription')
    var Publisher=document.querySelector('.Publisher')
    var Publish_Date=document.querySelector('.Publish_Date')
    var Pages=document.querySelector('.Pages')
    var Language=document.querySelector('.Language')
    var BookAuthor=document.querySelector('.BookAuthor')
    booksArray.forEach(e=>{
        if(e.Book_id==id){
            BookTitle.innerHTML=e.Title
            BookIMG.src=e.image
            BookDescription.innerHTML=e.Description
            Publisher.innerHTML=e.Publisher
            Publish_Date.innerHTML=e.Publish_Date
            Pages.innerHTML=e.Pages
            Language.innerHTML=e.Language
            BookAuthor.innerHTML="By "+e.author
            BOOKgenre=e.genre
            BOOKtitle=e.Title
        }
    })
  
} 
var box1=[];
var RelatedBooks1=document.querySelector('.RelatedBooks1')
for(let i=0;i<booksArray.length;i++){
    if(booksArray[i].genre==BOOKgenre&&bookId!=booksArray[i].Book_id){
        var a=document.createElement('div')
        a.id=booksArray[i].Book_id
        var b=document.createElement('div')
        var c=document.createElement('Img')
        c.src=booksArray[i].image
        b.appendChild(c)
        a.classList.add('box')
        c.style.height='100%'
        c.style.width='100%'
        b.style.height='11em'
        b.style.width='8em'
        b.style.marginTop='1em'
        a.appendChild(b)
        var cont=document.createElement('div')
        var title=document.createElement('h3')
        var BookAuthor=document.createElement('div')
        BookAuthor.innerHTML=booksArray[i].author
        BookAuthor.classList.add('.price')
        const str = booksArray[i].Title;
        const index = str.indexOf(":");
        const sliced = str.substring(0, index); 
        title.innerHTML=sliced
        cont.appendChild(title)
        cont.appendChild(BookAuthor)
        a.appendChild(cont)
        RelatedBooks1.appendChild(a)
        box1.push(a)
    }
}

var download=document.querySelector('.download')
download.addEventListener('click',(e)=>{
    if(user_id){
        if(download.style.color!='black'){
            let a = document.createElement('a');
        a.href = 'data:application/pdf;base64,' + base64;
        var str = BOOKtitle;
        var index = str.indexOf(":");
        var sliced = str.substring(0, index);
        a.download = sliced+'.pdf';
  
  document.body.appendChild(a);
  a.click();
  a.remove();
  download.innerHTML='Downloaded'
  download.style.backgroundColor='grey'
  download.style.color='black'
        }
    }
    else{
        alert('Please login to download')
    }
})
const aboutus=document.querySelector('.aboutus')
  aboutus.classList.remove('ABOUTUS')
  const BOOKS=document.querySelector('.books')
  BOOKS.classList.add('BOOKS')
  const home=document.querySelector('.home')
  home.classList.remove('HOME')
</script>