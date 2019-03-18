<?php
include_once "lib/mpdf/vendor/autoload.php";
$mpdf = new \Mpdf\Mpdf();

$output='	
<style>
@import url("css/pdf.css");
</style>

<div class="container">
  <h2>Basic Table</h2>
  <p>The .table class adds basic styling (light padding and only horizontal dividers) to a table:</p>            
  <table class="table">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
</div>';
$mpdf->WriteHTML($output);
$mpdf->AddPage();

$postimage= '<img src="images/cat.jpg">';
$mpdf->WriteHTML($postimage);
$loop2 = '';
for ($i=1; $i < 5; $i++) { 
	$postresults= '
			<div class="information">
				<div class="container">
  <h2>Basic Table'.$i.' &euro; €</h2>
  <p>The .table class adds basic styling (light padding and only horizontal dividers) to a table:</p>            
  <table class="table">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
</div>
			</div>
			';


if($loop2>0){
	$mpdf->AddPage();
}

$mpdf->WriteHTML($postresults);
$loop2++;
}



$pdfpath="Ajax-Pdf-".date('Y-m-d').".pdf";

$mpdf->Output($pdfpath);

echo "Ajax-Pdf-".date('Y-m-d').".pdf";


?>