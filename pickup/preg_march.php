<?php
$html=file_get_contents('https://app.apptweak.com/users/sign_in');
preg_match_all("/value=\"[^\"]*\"/i", $html, $matches);
echo '<pre>';
print_r($matches);
echo '</pre>';
echo 'utf8='.substr($matches[0][0],6).'&authenticity_token='.substr($matches[0][1],6).'&user[email]letangjacquie@gmail.com&user[password]=lt@147258369.&user[remember_me]=0&commit=Log+in';
?>