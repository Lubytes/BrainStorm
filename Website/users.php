<?php

#
# LOGINS
#
# Logins would typically be stored in MySQL, however multi-dimensional arrays
# serve as suitable substitutes when the login data does need to be changed.
#
#


$users[0]['username'] = 'admin';
$users[0]['password'] = 'd033e22ae348aeb5660fc2140aec35850c4da997';  //sha1('admin');
$users[0]['access'] = 1;

$users[1]['username'] = 'visitor';
$users[1]['password'] = '4ed0428505b0b89fe7bc1a01928ef1bd4c77c1be'; //sha1('visitor');
$users[1]['access'] = 5;

$users[2]['username'] = 'anonymous';
$users[2]['password'] = '0a92fab3230134cca6eadd9898325b9b2ae67998'; //sha1('anonymous');
$users[2]['access'] = 10;

$users[3]['username'] = 'gary';
$users[3]['password'] = 'f9023000f29773649f3850298becb9544b5fd6a9'; //sha1('gary');
$users[3]['access'] = 1;

?>