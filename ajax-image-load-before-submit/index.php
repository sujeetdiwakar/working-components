<!DOCTYPE html>
<html lang="en">
<head>
  <title>PDF Generate using ajax</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.js-botton',function(){

      $(this).parent().children('#loadingDiv').show();
      $(this).attr("disabled","disabled");
        $.ajax({
          url: 'ajax.php',
          method: 'POST',
          success: function(response){

            if ( response ) {
          
              $('#cat-brochure').removeAttr("disabled");
              $('#loadingDiv').hide();
              var today = new Date();
              var dd = today.getDate();
              var mm = today.getMonth()+1; //January is 0!
              var yyyy = today.getFullYear();

              if(dd<10) {
                  dd = '0'+dd
              }

              if(mm<10) {
                  mm = '0'+mm
              }

              today = yyyy + '-' + mm + '-' + dd;
              var uA = window.navigator.userAgent,
              isIE = /msie\s|trident\/|edge\//i.test(uA) && !!(document.uniqueID || document.documentMode || window.ActiveXObject || window.MSInputMethodContext),
        checkVersion = (isIE && +(/(edge\/|rv:|msie\s)([\d.]+)/i.exec(uA)[2])) || NaN;
              if(isIE==true)
              {
                document.getElementById('mybrochre').href=response;
                document.getElementById('mybrochre').click(); 
              }
              else
              {
                var link = document.createElement( 'a' );
                link.href = response;
                link.download = 'Ajax-Pdf-'+today+'.pdf';
                link.dispatchEvent( new MouseEvent( 'click' ) );
              }
          
          
        }

        else {
          console.log( 'error' );
        }
      }
    })
    });
});
</script>
<body>

<div class="container">
  <h1>PDF generate usng ajax</h1>
  <a id="mybrochre" href="#"></a>
   <button id="brochre" class="js-botton btn btn-lg btn-success">Pdf Generate</button>
   <div id="loadingDiv" class="loadinghide"><img src="images/ajax-loader.gif" alt=""></div>
</div>
   
</body>
</html>
