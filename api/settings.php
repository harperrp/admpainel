<?php
require __DIR__.'/db.php';
require __DIR__.'/common.php';
$method=$_SERVER['REQUEST_METHOD'];
if($method==='GET'){
 $rows=$pdo->query('SELECT setting_key, setting_value FROM site_settings ORDER BY setting_key')->fetchAll();
 $out=[]; foreach($rows as $r){$out[$r['setting_key']]=$r['setting_value'];}
 json_response(['ok'=>true,'data'=>$out]);
}
if($method==='PUT' || $method==='POST'){
 require_login();
 $d=get_json_input();
 foreach($d as $k=>$v){
   $s=$pdo->prepare('INSERT INTO site_settings (setting_key, setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
   $s->execute([$k, is_scalar($v)?(string)$v:json_encode($v,JSON_UNESCAPED_UNICODE)]);
 }
 json_response(['ok'=>true]);
}
json_response(['ok'=>false,'error'=>'Método inválido'],405);
