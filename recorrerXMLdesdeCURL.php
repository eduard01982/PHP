<?
echo " <!DOCTYPE html>\n
<html>\n";
echo "<head>\n";
echo "<title>Reportes</title>\n";
echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"estilo.css\"/>\n";
echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
echo "<link rel=\"stylesheet\" href=\"bootstrap.min.css\">\n";
echo "<script src=\"popper.min.js\"></script>\n";
echo "<script src=\"bootstrap.min.js\"></script>\n";
echo "<script src=\"jquery-2.2.4.min.js\"></script>\n";

?>
<script type="text/javascript">
$(window).load(function() {
    $(".loader").fadeOut("slow");
});
</script>
<script>
function parametros(elemento_id,params,link) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById(elemento_id).innerHTML = "";
            document.getElementById(elemento_id).innerHTML = this.responseText;
            } 
        xhttp.open("GET", "menuParametrosAjax.php?params="+params+"&link="+link);
        xhttp.send();
}
</script>
<?
echo "</head>\n";
echo "<body>\n";
echo "<div class=\"loader\"></div>";
echo "<div align=\"center\">\n";
if(file_exists("menu.php")) { 
  include "menu.php";
  echo "  <br><br>\n";
  }
echo "<br><h2>Reportes</h2><br>\n";

function traerXML($u)
  {
  $url = 'https://xxxxxx/jasperserver/rest_v2/resources/'.$u;
  $request = "{$url}"; // create the request URL
  $headers = [
    'Authorization: Basic UEhQOlBIUENvbnN1bHRhMTIz',
    'Content-type: application/xml'
    ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,  $request);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FAILONERROR,1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $result = curl_exec($ch);
  curl_close($ch);

  //print_r($result);
  return simplexml_load_string($result);
  }

  $xml = traerXML("");
//print_r($xml);


echo "<div class=\"table-responsive-sm\">\n";
echo "     <table class=\"table  table-hover\" style=\"font-size:12px\">";
echo "      <tr  style=\"background:#e2f0fa;font-size:12px\">\n";
echo "          <th>Reporte</th><th>Descripción</th><th>Parametros</th>";
echo "      </tr>";
foreach ($xml->resourceLookup as $resourceLookup) 
	{
  if ($resourceLookup->label != 'Content Files') 
    {
    echo "      <tr>";
	

    $xml2 = traerXML($resourceLookup->uri);
    $cantparam = 0;
    $params = '';
    foreach ($xml2->inputControls[0]->inputControlReference as $inputControlReference) 
	    {
      $cantparam++;
      $params .= str_replace($resourceLookup->uri."_files/","",$inputControlReference->uri).";";
      }
    echo "<td><span style='font-size: 17px;'><b>";
    if ($cantparam > 0) echo "<a href=\"javascript:parametros('".$resourceLookup->label."','".$params."','".$resourceLookup->uri."')\">";
      else echo "<a href='reporte.php?reporte=".$resourceLookup->uri."' target='_blank'>";
    echo $resourceLookup->label."</a></b></span></td><td>".$resourceLookup->description."</td>";
    echo "<td>$params</td>";
    echo "</tr><tr><td colspan='3' id='".$resourceLookup->label."'></td></tr>";	
    }
  }
echo "    </table>";
echo "</div>";

  
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
?>
