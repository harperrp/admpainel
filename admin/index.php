<?php
require __DIR__ . '/../api/db.php';

$logged = !empty($_SESSION['user']);
if ($logged) {
    readfile(__DIR__ . '/index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login Admin</title>
  <link rel="stylesheet" href="./assets/admin.css">
  <style>
    body{display:flex;min-height:100vh;align-items:center;justify-content:center;background:#0b1220}
    .card{width:min(420px,92vw);padding:24px;border-radius:12px;background:#121a2b;border:1px solid #25314d;color:#fff}
    .card h1{margin:0 0 16px;font-size:1.3rem}
    .card input{width:100%;margin:8px 0;padding:10px;border-radius:8px;border:1px solid #324467;background:#0d1526;color:#fff}
    .card button{width:100%;margin-top:10px;padding:10px;border:0;border-radius:8px;background:#2ecc40;color:#04220a;font-weight:700;cursor:pointer}
    .msg{margin-top:10px;font-size:.9rem;color:#f87171;min-height:20px}
  </style>
</head>
<body>
  <form class="card" id="login-form">
    <h1>Painel Administrativo</h1>
    <input type="email" id="email" placeholder="E-mail" required>
    <input type="password" id="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
    <div class="msg" id="msg"></div>
  </form>
<script>
document.getElementById('login-form').addEventListener('submit', async function(e){
  e.preventDefault();
  const msg = document.getElementById('msg');
  msg.textContent = '';
  const res = await fetch('../api/auth.php', {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    credentials:'same-origin',
    body: JSON.stringify({email:email.value,password:password.value})
  });
  if(res.ok){ window.location.href = './'; return; }
  const data = await res.json().catch(()=>({error:'Falha no login'}));
  msg.textContent = data.error || 'Falha no login';
});
</script>
</body>
</html>
