<?php
$username = !empty($_POST['userName']) ? $_POST['userName'] : false;
if ($username) {
  echo "Hello, {$username}";
}
else {
  echo "Who's there?";
}		