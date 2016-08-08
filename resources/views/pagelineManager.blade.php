<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.2.0-rc2/css/bootstrap-rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

<link rel="stylesheet" type="text/css"
    href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  </head>
  <body>
    <section classs="contaner">
      <div class="row" style="position: relative;">
        <div class="col-md-2" style="position: fixed; right:10px;">
       <div class="form-group">
          <label for="exampleInputEmail1">العرض</label>
          <input type="text" class="form-control" id="width" value="345" >
        </div>
      </div>
       <div id="resizeDiv" class="col-md-7" style="width: 345px; text-align: center;float: right; right: 380px;">
        <h1>المصحف</h1>
        <?php 
              $bast=true; 
              $max = sizeof($words);
              $last = $words[$max-1]->ID;
              $anasID = 0;
             
        ?>
        @foreach ($words as $word)
        
        <!-- line numbaring 
          @if ($bast)
            {{ $word->l_ID }}- 
          @endif
          <?php $bast = false; 
            $num_padded = sprintf("%03d", $word->p_ID);
            ++$anasID;
          ?>
          -->
          <!-- show word -->
          <span id="{{ $word->ID }}" {{ ($word->p_ID == NULL)? ' ' : "style=font-family:QCF_P$num_padded;" }} class="word">{{ ($word->p_ID == NULL)? $word->madina : $word->madina }}</span>
          <!-- break -->
          @if($word->ID < $last)
            <!-- line break -->
            @if ($word->l_ID < $words[$anasID]->l_ID)

              <br> <?php $bast = true; ?>
            @endif

            <!-- page break -->
            @if ($word->p_ID < $words[$anasID]->p_ID)
            
              <br>========={{ $word->p_ID }}=========<br><?php $bast = true; ?>
            @endif

          @endif

       
        @endforeach
       </div>
       <div class="col-md-3" style="position: fixed; right:740px;">
        <form>
          <div class="form-group">
          <label for="exampleInputEmail1">الخط</label>
          <select class="form-control" id="font">
            <option value='QCF_BSML'>QCF_BSML</option>
          @for($i=497;$i<605;$i++)
           <option value='QCF_P<?php echo sprintf("%03d", $i); ?>'>QCF_P<?php echo sprintf("%03d", $i); ?></option>
           @endfor
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">من</label>
          <input type="text" class="form-control" id="from" name="from">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">إلى</label>
          <input type="text" class="form-control" id="to" name="to">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">سطر</label>
          <input type="text" class="form-control" id="line" name="line">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">صفحة</label>
          <input type="text" class="form-control" id="page" name="page">
        </div>
          <button class="btn btn-primary save">حفظ</button>
        </form>
       </div>
      </div>
    </section>

    
    <script type="text/javascript" src="{{ asset('assets/js/jquery.js') }}"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>

    <script type="text/javascript">
        function pad (str, max) {
          str = str.toString();
          return str.length < max ? pad("0" + str, max) : str;
        }
        $('.word').mousedown(function(event) {
            switch (event.which) {
                case 1:
                    if (event.ctrlKey) 
                      $("#from").val($(this).attr('id'));
                    else if (event.altKey) {
                      $("#to").val($(this).attr('id'));
                      save();
                   } else
                      $("#to").val($(this).attr('id'));
                    
                case 2:
                    
                    break;
                case 3:
                    
                    break;
                default:
                    alert('You have a strange Mouse!');
            } return false;
        });
        function save(){
          var from = $('#from').val();
          var to = $('#to').val();
          var line = $('#line').val();
          var page = $('#page').val();

          $.ajax({
            url   :"<?= URL::to('save') ?>",
            type  :"POST",
            async : false,
            data  :{
                'from'  : from,
                'to'    : to,
                'line'  : line,
                'page'  : page,
                '_token': '{{ csrf_token() }}'
            },
            success:function(re){
              $("#"+re).css("background-color", "yellow");
              if(line == 15){
                $( "<br>========="+page+"=========<br>" ).insertAfter( "#"+to );
                $('#page').val(++page);
                $('#line').val(1);
                $("span").css('font-family', 'QCF_P'+pad(page,3));
              }else
                $('#line').val(++line);

              $('#from').val(++to);
            }
          }); 
          return false;
        }
        $(".save").click(function(){
          save();
          return false;
        });
        $(function(){$('#resizeDiv').resizable();});

        $('#font').change(function () {
          var font = $(this).find('option:selected').val();
          $("span").css('font-family', font);
        
        }).trigger('change');

        $("#width").bind("mousewheel", function(event, delta) {
          var oEvent = event.originalEvent,
            delta  = oEvent.deltaY || oEvent.wheelDelta;
          if (delta > 0) {
              this.value = parseInt(this.value) + 1;
              $("#resizeDiv").width( parseInt(this.value));
          } else {
                  this.value = parseInt(this.value) - 1;
                  $("#resizeDiv").width( parseInt(this.value));
          }
          return false;
       });
  
    </script>

  </body>
</html>