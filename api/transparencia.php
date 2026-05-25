<?php
require __DIR__.'/db.php';
require __DIR__.'/common.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($method === 'GET') {
    if ($id) {
        $stmt = $pdo->prepare('SELECT * FROM transparency_links WHERE id=? LIMIT 1');
        $stmt->execute([$id]);
        json_response(['ok'=>true,'data'=>$stmt->fetch()]);
    }
    $admin = isset($_GET['admin']) && $_GET['admin'] === '1';
    $sql = $admin
      ? 'SELECT * FROM transparency_links ORDER BY display_order, title'
      : 'SELECT * FROM transparency_links WHERE active=1 ORDER BY display_order, title';
    json_response(['ok'=>true,'data'=>$pdo->query($sql)->fetchAll()]);
}

if ($method === 'POST') {
    $d = get_json_input();
    $stmt = $pdo->prepare('INSERT INTO transparency_links (title,description,url,category,display_order,active) VALUES (?,?,?,?,?,?)');
    $stmt->execute([
        $d['title'] ?? '', $d['description'] ?? null, $d['url'] ?? '', $d['category'] ?? null,
        (int)($d['display_order'] ?? 0), isset($d['active']) ? (int)$d['active'] : 1
    ]);
    json_response(['ok'=>true,'id'=>(int)$pdo->lastInsertId()],201);
}

if ($method === 'PUT') {
    if (!$id) json_response(['ok'=>false,'error'=>'ID obrigatório'],400);
    $d = get_json_input();
    $stmt = $pdo->prepare('UPDATE transparency_links SET title=?,description=?,url=?,category=?,display_order=?,active=? WHERE id=?');
    $stmt->execute([
        $d['title'] ?? '', $d['description'] ?? null, $d['url'] ?? '', $d['category'] ?? null,
        (int)($d['display_order'] ?? 0), isset($d['active']) ? (int)$d['active'] : 1, $id
    ]);
    json_response(['ok'=>true]);
}

if ($method === 'DELETE') {
    if (!$id) json_response(['ok'=>false,'error'=>'ID obrigatório'],400);
    $stmt = $pdo->prepare('DELETE FROM transparency_links WHERE id=?');
    $stmt->execute([$id]);
    json_response(['ok'=>true]);
}

json_response(['ok'=>false,'error'=>'Método inválido'],405);
