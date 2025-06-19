<php 
function validate_input($data){

$data = tris ($data);

$data = stripeslashes ($data);
$data = htmlspecialchars ($data);
return $data;
}