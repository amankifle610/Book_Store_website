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
        <main>
            <div class="homepageMain">
                <div class="homepagediv">
                    <span class="span1">Today a <br>Reader, <br>Tomorrow a <br>Leader. <br></span>
                    <?php
                    if(isset($_SESSION['user_id'])){
                        
                    }
                    else{
                        echo "<div class='buttondiv'><button class='signupBut'>Sign up</button></div>";
                    }
                    ?>
                    
                </div>
            <div class="homepagediv3">
                <div class="Bimg Bookimage1"></div>
                <div class="Bimg Bookimage2"></div>
                <div class="Bimg Bookimage3"></div>
                <div class="Bimg Bookimage4"></div>
                <div class="Bimg Bookimage5"></div>
            </div>
            </div>
            <div class="homepageMain1">
            <h2>BEST SELLING</h2>
            <span style="color: gray;">1000+ books are published by different authors everyday</span>
            <br>
            <a href="book.php" style="color: orangered;">View all &nbsp;&#8594;</a>
            <i class="fa fa-solid fa-chevron-left"></i>
            <div class="homepageMain1Div">
                <div class="box" id="book1">
                    <div class="Bookimage" style="background-image: url(img/book1.jpg);"></div>
                    <div class="content">
                        <h1>Atomic Habits</h1>
                        <div class="price">James Clear</div>
                        <span class="star1">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    </div>
                </div>
                <div class="box" id="book2">
                    <div class="Bookimage" style="background-image: url(img/book2.jpg);"></div>
                    <div class="content">
                        <h1>The 48 Laws of Power</h1>
                        <div class="price">Robert Greene</div>
                        <span class="star1">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    </div>
                </div>
                <div class="box" id="book3">
                    <div class="Bookimage" style="background-image: url(img/book3.jpg);"></div>
                    <div class="content">
                        <h1>When the Moon Hatched</h1>
                        <div class="price">Sarah A. Parker</div>
                        <span class="star1">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    </div>
                </div>
                <div class="box" id="book4">
                    <div class="Bookimage" style="background-image: url(img/book4.jpg);"></div>
                    <div class="content">
                        <h1>Oath and Honor</h1>
                        <div class="price">Liz Cheney</div>
                        <span class="star1">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    </div>
                </div>
                <div class="box" id="book5">
                    <div class="Bookimage" style="background-image: url(img/book5.jpg);"></div>
                    <div class="content">
                        <h1>The Orphans of Davenport</h1>
                        <div class="price">Marilyn Brookwood</div>
                        <span class="star1">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    </div>
                </div>
                <div class="box" id="book6">
                    <div class="Bookimage" style="background-image: url(img/book6.jpg);"></div>
                    <div class="content">
                        <h1>Killers of the Flower Moon</h1>
                        <div class="price">David Grann</div>
                        <span class="star1">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    </div>
                </div>
                <div class="box" id="book7">
                    <div class="Bookimage" style="background-image: url(img/book7.jpg);"></div>
                    <div class="content">
                        <h1>The Beast You Are</h1>
                        <div class="price">Paul Tremblay</div>
                        <span class="star1">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    </div>
                </div>
            </div>
            <i class="fa fa-solid fa-chevron-right"></i>
            </div>
            <div class="homepageMain1Genre">
                <h2 style="display: inline-block; margin-top: 30px; margin-left: 20px;">BROWSE GENRES&nbsp;&nbsp;</h2>
                <span>(<a href="book.php" class="books">view all</a>)</span>
                <div class="homepageMain1DivGenre">
                    <div class="genre">
                        <p class="pGenre"><span>ROMANCE</span></p>
                    </div>
                    <div class="genre1">
                        <p class="pGenre"><span>ADVENTURE</span></p>
                    </div>
                    <div class="genre2">
                        <p class="pGenre"><span>THRILLER</span></p>
                    </div>
                    <div class="genre3">
                        <p class="pGenre"><span>BIOGRAPHY</span></p>
                    </div>
                    <div class="genre4">
                        <p class="pGenre"><span>HORROR</span></p>
                    </div>
                    <div class="genre5">
                        <p class="pGenre"><span>CHILDREN</span></p>
                    </div>
                    <div class="genre6">
                        <p class="pGenre"><span>SCIENTIFIC</span></p>
                    </div>
                    <div class="genre7">
                        <p class="pGenre"><span>NON-FICTIONAL</span></p>
                    </div>
                </div>
            </div>
            <div class="homepageMain1NewRelease">
                <h2>NEW RELEASE</h2>
                <div class="homepageMain1DivNewRelease" >
                </div>
            </div>
        </main>
        <a name="contactus"></a>
<?php
include_once('footer.php')
?>
<script>
    var booksArray = <?php echo $booksJSON; ?>;
var homepageMain1Div=document.querySelector('.homepageMain1Div')
 var chevronright=document.querySelector('.fa-chevron-right')
chevronright.addEventListener('click',()=>{
    homepageMain1Div.scrollBy({left: 210,behavior: 'smooth'})
})
var chevronleft=document.querySelector('.fa-chevron-left')
chevronleft.addEventListener('click',()=>{
    homepageMain1Div.scrollBy({left: -200,behavior: 'smooth'})
})
var box1=[]
var homepageMain1DivNewRelease=document.querySelector('.homepageMain1DivNewRelease')
for(let i=0;i<booksArray.length;i++){
    if(booksArray[i].New_release==1){
    var a=document.createElement('div')
    a.id=booksArray[i].Book_id
    var b=document.createElement('div')
    var c=document.createElement('Img')
    c.src=booksArray[i].image
    b.appendChild(c)
    a.classList.add('box')
    a.classList.add('box1')
    c.style.height='100%'
    c.style.width='100%'
    b.style.height='20em'
    b.style.width='13em'
    b.style.marginTop='1em'
    a.appendChild(b)
    var cont=document.createElement('div')
    var title=document.createElement('h3')
    var price=document.createElement('div')
    price.innerHTML=booksArray[i].author
    title.style.fontSize="2em"
    price.style.fontSize="1.5em"
    price.classList.add('.price')
        const str = booksArray[i].Title;
        const index = str.indexOf(":");
        const sliced = str.substring(0, index); 
        title.innerHTML=sliced
    cont.appendChild(title)
    cont.appendChild(price)
    a.appendChild(cont)
    homepageMain1DivNewRelease.appendChild(a)
    box1.push(a)
    }
}

var BOOKID;
var box=document.querySelectorAll('.box')
Array.from(box).forEach(e=>{
    e.addEventListener('click',()=>{
        BOOKID=e.id
        window.location.href = 'bookdes.php?id='+BOOKID;
    })
})
box1.forEach(element => {
    element.addEventListener('click',()=>{
        BOOKID=element.id
        window.location.href = 'bookdes.php?id='+BOOKID;
    })
});
if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href)
}
var signupMain1=document.querySelector('.signupMain1')
var but=document.querySelector('.signupBut')
if(but){
    but.addEventListener('click' ,()=>{
    signupMain1.style.display='flex'
})
}
var pGenre=document.querySelectorAll('.pGenre')
Array.from(pGenre).forEach(e=>{
    e.addEventListener('click',()=>{
        var genre=e.firstElementChild.innerHTML;
        window.location.href = 'book.php?Genre='+genre;
    })
})
const aboutus=document.querySelector('.aboutus')
  aboutus.classList.remove('ABOUTUS')
  const BOOKS=document.querySelector('.books')
  BOOKS.classList.remove('BOOKS')
  const home=document.querySelector('.home')
  home.classList.add('HOME')

/*     var y=[];
    for(let w=0;w<5;w++){
        let x=Math.round(Math.random()*booksArray.length);
    while(y.includes(x)){
            x=Math.round(Math.random()*booksArray.length)
    }
    y.push(x)
    } */
    var q=0
    var Bimg=document.querySelectorAll('.Bimg')
     Array.from(Bimg).forEach(e=>{
        e.style.backgroundImage='url('+booksArray[q].image+')';
        e.id=booksArray[q].Book_id;
        q++;
     e.addEventListener('click',()=>{
        window.location.href = 'bookdes.php?id='+e.id;
     })
 }) 
</script>
