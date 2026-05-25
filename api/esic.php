<?php
require __DIR__.'/db.php';
require __DIR__.'/common.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($method === 'GET') {
    $stmt = $pdo->query('SELECT * FROM esic_requests ORDER BY created_at DESC, id DESC');
    json_response(['ok'=>true,'data'=>$stmt->fetchAll()]);
}

if ($method === 'POST') {
    $d = get_json_input();
    $protocol = 'ESIC-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));
    $stmt = $pdo->prepare('INSERT INTO esic_requests (protocol, requester_name, requester_email, requester_phone, subject, message, status) VALUES (?,?,?,?,?,?,?)');
    $stmt->execute([
        $protocol,
        $d['requester_name'] ?? '',
        $d['requester_email'] ?? null,
        $d['requester_phone'] ?? null,
        $d['subject'] ?? '',
        $d['message'] ?? '',
        $d['status'] ?? 'novo'
    ]);
    json_response(['ok'=>true,'id'=>(int)$pdo->lastInsertId(),'protocol'=>$protocol],201);
}

if ($method === 'PUT') {
    if (!$id) json_response(['ok'=>false,'error'=>'ID obrigatório'],400);
    $d = get_json_input();
    $stmt = $pdo->prepare('UPDATE esic_requests SET status=?, response=?, updated_at=NOW() WHERE id=?');
    $stmt->execute([$d['status'] ?? 'em_andamento', $d['response'] ?? null, $id]);
    json_response(['ok'=>true]);
}

json_response(['ok'=>false,'error'=>'Método inválido'],405);
