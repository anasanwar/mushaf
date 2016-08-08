<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mushaf</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
   
    <section id="mushaf">
        <div class="next"></div>
        <div class="back"></div>
    	<div class="container">
            
        	<div class="row">
        	 <div class="col-lg-6  col-lg-offset-0 col-xs-offset-3 col-xs-6 ">
                <div class="row header">
                    <div class="col-xs-6">
                       ﰸﰹ
                    </div>
                    <div class="col-xs-6">                
                       ﮌﮎ
                    </div>
                </div>
        	 	<div class="right" width="">
        	 		<?php 
        	 			$last = $rightWords[0]; 
        	 			$num_padded = sprintf("%03d", $last->p_ID);
                        $str = "";
        	 		?>
        	 		<?php $str .= "<span class='line". (($last->aya == 0 ) ? " title" : " " ) ."'>" ?>
        	 		@foreach ($rightWords as $word)
        	 		@if($word->l_ID > $last->l_ID)
        	 			<?php $str .= "</span><br><span class='line". (($word->aya == 0 ) ? " title" : " " ) ."'>" ?>
        	 		@endif
        	 		<?php $str .= "<span id='". $word->ID ."' style='font-family: QCF_". (($word->aya == 0 ) ? "BSML;'" : ("P".$num_padded.";'")) .">". $word->madina ."</span>"; ?>
        	 		<?php $last->l_ID = $word->l_ID; ?>
        	 		@endforeach
                    {!! $str !!}
        	 		</span>
        	 	</div>
                <div class="row footer">
                    <div class="col-xs-12  rightPageNo" lang="hi">
                        {{ $rightWords[0]->p_ID }}
                    </div>
                </div>
        	 </div>
             
        	 <div class="col-lg-6  col-lg-offset-0 col-lg-offset-0 col-xs-offset-3 col-xs-6 ">
                <div class="row header">             
                    <div class="col-xs-6">
                        ﰸﰹ
                    </div>
                    <div class="col-xs-6">                
                        ﮌﮎ
                    </div>
                </div>
        	 	<div class="left" width="">
        	 		<?php 
                        $last = $leftWords[0]; 
                        $num_padded = sprintf("%03d", $last->p_ID);
                        $str = "";
                    ?>
                    <?php $str .= "<span class='line". (($last->aya == 0 ) ? " title" : " " ) ."'>" ?>
                    @foreach ($leftWords as $word)
                    @if($word->l_ID > $last->l_ID)
                        <?php $str .= "</span><br><span class='line". (($word->aya == 0 ) ? " title" : " " ) ."'>" ?>
                    @endif
                    <?php $str .= "<span id='". $word->ID ."' style='font-family: QCF_". (($word->aya == 0 ) ? "BSML" : ("P".$num_padded)) .";'>". $word->madina ."</span>"; ?>
                    <?php $last->l_ID = $word->l_ID; ?>
                    @endforeach
                    {!! $str !!}
                    </span>
        	 	</div>
                <div class="row footer">
                    <div class="col-xs-12  leftPageNo" lang="hi">
                        {{ $leftWords[0]->p_ID }}
                    </div>
                </div>
        	 </div>
        	</div>
            
    	</div>
        
    </section>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script>
        function pad (str, max) {
          str = str.toString();
          return str.length < max ? pad("0" + str, max) : str;
        }

        function getHTML(re){
            var last = re[0];
            var title = ((last.aya == 0 ) ? "title" : " ");
            var num_padded = pad(last.p_ID,3);
            var str = "<span class='line "+title+"'>";
            var font = "";
            
            re.forEach(function(word,index,arr){
                font = ((word.aya == 0 ) ? "BSML" : ("P" + num_padded));
                title = ((word.aya == 0 ) ? "title" : " ");
                if(word.l_ID > last.l_ID){
                    str += "</span><br><span class='line"+title+"'>";
                }
                str += "<span id=" + word.ID + " style='font-family: QCF_" + font +";'>"+ word.madina +"</span>";
                //str+= "<span>" + word.without + "</span>";
                
                last = word;
            });
            str += "</span>"
            return str;
        }

        function getPage(page){
            $.ajax({
                url   :"<?= URL::to('getPage') ?>",
                type  :"GET",
                async : false,
                data: {
                    'page': page
                },
                success:function(re){
                    
                    $( ".right" ).html(getHTML(re.rightWords));
                    $( ".left" ).html(getHTML(re.leftWords));
                    $(".rightPageNo").text(re.rightWords[0].p_ID);
                    $(".leftPageNo").text(re.leftWords[0].p_ID);
                }
            });
        }
        $(document).ready(function(){
            $(".next").click(function(){
                getPage(parseInt($(".leftPageNo").text())+1);
            });
            $(".back").click(function(){
                getPage(parseInt($(".rightPageNo").text())-2);
            });
            return false;
        });



    </script>
  </body>
</html>