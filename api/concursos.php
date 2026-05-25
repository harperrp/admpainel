<?php
require __DIR__.'/db.php';
require __DIR__.'/common.php';
$method=$_SERVER['REQUEST_METHOD'];
$id=isset($_GET['id'])?(int)$_GET['id']:null;
if($method==='GET'){
 if($id){$s=$pdo->prepare('SELECT * FROM public_tenders WHERE id=? LIMIT 1');$s->execute([$id]);json_response(['ok'=>true,'data'=>$s->fetch()]);}
 $admin=isset($_GET['admin'])&&$_GET['admin']==='1';
 $sql=$admin?'SELECT * FROM public_tenders ORDER BY opening_date DESC,id DESC':"SELECT * FROM public_tenders WHERE status IN ('publicado','aberto','andamento') ORDER BY opening_date DESC,id DESC";
 json_response(['ok'=>true,'data'=>$pdo->query($sql)->fetchAll()]);
}
if($method==='POST'){
 require_login();
 $d=get_json_input();$s=$pdo->prepare('INSERT INTO public_tenders (title,tender_number,modality,description,file_url,opening_date,status) VALUES (?,?,?,?,?,?,?)');$s->execute([$d['title']??'',$d['tender_number']??null,$d['modality']??null,$d['description']??null,$d['file_url']??null,$d['opening_date']??date('Y-m-d'),$d['status']??'publicado']);json_response(['ok'=>true,'id'=>(int)$pdo->lastInsertId()],201);} 
if($method==='PUT'){
 require_login();
 if(!$id)json_response(['ok'=>false,'error'=>'ID obrigatório'],400);
 $d=get_json_input();$s=$pdo->prepare('UPDATE public_tenders SET title=?,tender_number=?,modality=?,description=?,file_url=?,opening_date=?,status=? WHERE id=?');$s->execute([$d['title']??'',$d['tender_number']??null,$d['modality']??null,$d['description']??null,$d['file_url']??null,$d['opening_date']??date('Y-m-d'),$d['status']??'publicado',$id]);json_response(['ok'=>true]);}
if($method==='DELETE'){
 require_login();
 if(!$id)json_response(['ok'=>false,'error'=>'ID obrigatório'],400);
 $s=$pdo->prepare('DELETE FROM public_tenders WHERE id=?');
 $s->execute([$id]);
 json_response(['ok'=>true]);
}
json_response(['ok'=>false,'error'=>'Método inválido'],405);
