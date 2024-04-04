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


$booksArray = [];
while($row = $result->fetch_assoc()) {
  $booksArray[] = $row; 
}
$booksJSON = json_encode($booksArray);
?>
<main class="Booksmain">
  <h2 style="margin-top: 60px; font-size: 4em;">Books</h2>
  <a href="" class="all"></a><span class="all1"></span>
  <button class="sort">sort&nbsp;<i class="fa fa-solid fa-sort"></i></button>
  <div class="sort-options">
    <div class="sort-option title">Title</div>
    <div class="sort-option Genre">Genre</div>
    <div class="optionGenre">
      <div class="G Genre1">HORROR</div>
      <div class="G Genre2">FICTION</div>
      <div class="G Genre3">BIOGRAPHY</div>
      <div class="G Genre4">THRILLER</div>
      <div class="G Genre5">SELF-HELP</div>
      <div class="G Genre6">NON-FICTIONAL</div>
    </div>
  </div>
  <p class="NoBook">No book found</p>
  <div class="BooksmainAll">
    
  </div>
  <button class="next" style="background-color: grey;" disabled=true>next</button>
</main>
<?php
include_once('footer.php');
?>
<script>
  const gen = new URLSearchParams(window.location.search).get('Genre');
  const searchText = new URLSearchParams(window.location.search).get('text');
  var box=[];
  var all1=document.querySelector('.all1')
  var NoBook=document.querySelector('.NoBook')
  var all=document.querySelector('.all')
  var booksArray = <?php echo $booksJSON; ?>;
  var books=[]
  var BooksmainAll=document.querySelector('.BooksmainAll')
  var G=document.querySelectorAll('.G')
  var title=document.querySelector('.title')
  if(searchText){
    for(let i=0;i<booksArray.length;i++){
      if(booksArray[i].author==searchText){
        books.push(booksArray[i])
      }
    const str = booksArray[i].Title;
    const index = str.indexOf(":");
    const sliced = str.substring(0, index);
      if(sliced==searchText){
        books.push(booksArray[i])
      }
    }
    booksArray=books;
  }
  if(booksArray.length<=0){
      NoBook.style.display='block';
    }
  addChild(booksArray);

  function addChild(booksarray) {
    for(let i=0;i<booksarray.length;i++){
    var a=document.createElement('div')
    a.id=booksarray[i].Book_id
    var b=document.createElement('div')
    var c=document.createElement('Img')
    c.src=booksarray[i].image
    b.appendChild(c)
    a.classList.add('boxBooks')
    a.style.height='390px'
    c.style.height='100%'
    c.style.width='100%'
    b.style.height='17em'
    b.style.width='12em'
    a.appendChild(b)
    var cont=document.createElement('div')
    var title=document.createElement('h4')
    var author=document.createElement('div')
    title.style.fontSize='1.5em'
    author.style.fontSize='1.3em'
    author.style.textAlign= 'center';
    author.innerHTML=booksarray[i].author
    author.classList.add('.author')
    const str = booksarray[i].Title;
    const index = str.indexOf(":");
    const sliced = str.substring(0, index); 
    title.innerHTML=sliced
    cont.appendChild(title)
    cont.appendChild(author)
    a.appendChild(cont)
    BooksmainAll.appendChild(a)
    box.push(a)
}
  }
  title.addEventListener('click',()=>{
      var b=booksArray.sort((a,b)=>{
      if(a.Title>b.Title){
        return 1
      }
      else if(a.Title<b.Title){
        return -1
      }
      else{
        return 0
      }
    })
    if(b.length>0){
      NoBook.style.display='none';
    }
    all1.innerHTML=''
    for(let j=0;j<box.length;j++){
    box[j].style.visibility='visible'
} 
    for(let i=0;i<b.length;i++){
      box[i].id=b[i].Book_id
      box[i].firstElementChild.firstElementChild.src=b[i].image
      const str = b[i].Title;
      const index = str.indexOf(":");
      const sliced = str.substring(0, index); 
      box[i].lastElementChild.firstElementChild.innerHTML=sliced
      box[i].lastElementChild.firstElementChild.nextElementSibling.innerHTML=b[i].author
} 
})
/* var next=document.querySelector('.next')
next.addEventListener('click',()=>{
  next.disable='true'
  booksArray=<?php //echo $booksJSON; ?>.slice(11,20);
  for(let j=0;j<box.length;j++){
    box[j].style.visibility='visible'
} 
    for(let i=0;i<b.length;i++){
      box[i].id=booksArray[i].id
      box[i].firstElementChild.firstElementChild.src=booksArray[i].image
      box[i].lastElementChild.firstElementChild.innerHTML=booksArray[i].Title
      box[i].lastElementChild.firstElementChild.nextElementSibling.innerHTML=booksArray[i].author
} 
}) */
function createChild(n) {
  for(let j=0;j<n;j++){
    box[j].style.visibility='visible'
} 
  }
var BOOKID;
Array.from(box).forEach(e=>{
    e.addEventListener('click',()=>{
        BOOKID=e.id
        window.location.href = 'bookdes.php?id='+BOOKID;
    })
})
Array.from(G).forEach(e=>{
    e.addEventListener('click',()=>{
      genre(e.innerHTML);
      all1.innerHTML=' > '+e.innerHTML
      all.innerHTML='All'
    })
})
 function genre(GENRE){
   var b=booksArray.filter(e=>{
    return e.genre==GENRE
  })
    if(b.length<=0){
      NoBook.style.display='block';
      NoBook.style.color='red';
    }
    else{
      NoBook.style.display='none';
    }
  for(let j=0;j<box.length;j++){
    box[j].style.visibility='hidden'
} 
    createChild(b.length)
  for(let j=0;j<b.length;j++){
    box[j].id=b[j].Book_id
    box[j].firstElementChild.firstElementChild.src=b[j].image
    const str = b[j].Title;
    const index = str.indexOf(":");
    const sliced = str.substring(0, index); 
    box[j].lastElementChild.firstElementChild.innerHTML=sliced
    box[j].lastElementChild.firstElementChild.nextElementSibling.innerHTML=b[j].author
} 

}
  if(gen){
    genre(gen);
    all1.innerHTML=' > '+gen
    all.innerHTML='All'
  }
  const aboutus=document.querySelector('.aboutus')
  aboutus.classList.remove('ABOUTUS')
  const BOOKS=document.querySelector('.books')
  BOOKS.classList.add('BOOKS')
  const home=document.querySelector('.home')
  home.classList.remove('HOME')
</script>