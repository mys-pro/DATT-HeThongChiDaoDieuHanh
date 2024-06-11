<?php
$route['default_controller'] = 'login';

$route['dang-nhap'] = 'login/login';
$route['quen-mat-khau'] = 'login/forgot';
$route['ma-xac-nhan'] = 'login/verify';
$route['doi-mat-khau'] = 'login/changePassword';
$route['kich-hoat-tai-khoan'] = 'login/activeAccount';

$route['ac/thong-ke'] = 'task/statistical';
$route['ac/bao-cao'] = 'task/report';
$route['ac/cong-viec'] = 'task/task';
$route['ac/xet-duyet'] = 'task/signature';

$route['kb/quan-tri-he-thong'] = 'admin/department';
$route['kb/co-cau-to-chuc'] = 'admin/department';
$route['kb/phong-ban'] = 'admin/department';
$route['kb/chuc-vu'] = 'admin/position';
$route['kb/nguoi-dung'] = 'admin/user';


$route['thiet-lap/thong-tin-ca-nhan'] = 'setting/userInfo';