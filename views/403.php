<!-- error403.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Erro 403 - Acesso negado</title>
  <style>
    body {
      background: #2f1e1e;
      color: #fff;
      font-family: Arial, sans-serif;
      text-align: center;
      padding-top: 10%;
    }
    .error {
      font-size: 120px;
      font-weight: bold;
      animation: shake 0.5s infinite;
    }
    @keyframes shake {
      0% { transform: translateX(0); }
      25% { transform: translateX(-10px); }
      50% { transform: translateX(10px); }
      75% { transform: translateX(-10px); }
      100% { transform: translateX(0); }
    }
    img {
      width: 200px;
      animation: lock 2s infinite;
    }
    @keyframes lock {
      0% { transform: rotate(0deg); }
      50% { transform: rotate(10deg); }
      100% { transform: rotate(0deg); }
    }
    a {
      color: #ffcc00;
      text-decoration: none;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <div class="error">403</div>
  <p>Acesso negado</p>
  <img src="https://via.placeholder.com/200x200?text=403" alt="Erro 403">
  <p><a href="/">Voltar para a página inicial</a></p>
</body>
</html>