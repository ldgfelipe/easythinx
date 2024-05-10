  <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div style="background-image:url('./public/images/slider/slide1.png'); background-size:cover; width:100%; height:600px;  "></div>

            <div class="carousel-caption d-none d-md-block ">
                <h5>Banner 1</h5>
                <p>Some representative placeholder content for the first slide.</p>
              </div>

          </div>
          <div class="carousel-item">
            <div style="background-image:url('./public/images/slider/slide2.png'); background-size:cover; width:100%; height:600px;  "></div>
            <div class="carousel-caption d-none d-md-block ">
                <h5>Banner 2</h5>
                <p>Some representative placeholder content for the first slide.</p>
              </div>
        </div>
          <div class="carousel-item">
            <div style="background-image:url('./public/images/slider/slide3.png'); background-size:cover; width:100%; height:600px;  "></div>
            <div class="carousel-caption d-none d-md-block ">
                <h5>Banner 3</h5>
                <p>Some representative placeholder content for the first slide.</p>
              </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>


  <script>

const myCarouselElement = document.querySelector('#myCarousel')
const carousel = new bootstrap.Carousel(myCarouselElement, {
  interval: 2000,
  wrap: false
})


  </script>