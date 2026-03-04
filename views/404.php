<!-- error404.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Erro 404 - Página não encontrada</title>
  <style>
    body {
      background: #1e1e2f;
      color: #fff;
      font-family: Arial, sans-serif;
      text-align: center;
      padding-top: 10%;
    }
    .error {
      font-size: 120px;
      font-weight: bold;
      animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
      0% { color: #ff4c4c; }
      50% { color: #ff9999; }
      100% { color: #ff4c4c; }
    }
    img {
      width: 200px;
      animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
      100% { transform: translateY(0); }
    }
    a {
      color: #00c3ff;
      text-decoration: none;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <div class="error">404</div>
  <p>Página não encontrada</p>
  <img src="https://via.placeholder.com/200x200?text=404" alt="Erro 404">
  <p><a href="/">Voltar para a página inicial</a></p>
</body>
</html>