<div class="loaderapp" style="position:fixed; z-index:999999999999999999999999; width:100%; max-width:100%; height:100%;top:0px; left:0px;">

        <div style="margin:10% auto; width:300px; max-width:100%; height:auto; position:relative; z-index:10; ">

            <img src="{{ env('APP_URL') }}/public/images/logo/logo.png"
            class="logotp" />
        </div>

        <div style="position:absolute; width:100%; height:100%; max-width:100%; background-color:#fff; top:0px; left:0px;"></div>


</div>
<script>
    $(window).ready(function(){
      $('.loaderapp').animate({
    opacity: 0,

  }, 3000, function() {
    // Animation complete.
    $('.loaderapp').css('display','none')
  });
    })
</script>
