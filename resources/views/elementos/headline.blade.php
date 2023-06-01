<div id="headline" class="headline"></div>
<script>
    @if(count($cabecera)!=0)
    $('#headline').html(`<?php
    echo utf8_encode($cabecera[0]->contenido)

    ?>`);
      @endif
    </script>
