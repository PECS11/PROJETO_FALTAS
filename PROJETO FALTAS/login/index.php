<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
   <link rel="stylesheet" href="assets/css/styles.css">
   <title>Login</title>
</head>
<body>
   <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
      <mask id="mask0" mask-type="alpha">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
      </mask>
      <g mask="url(#mask0)">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
         <image class="login__img" href="assets/img/mc-img.jpg"/>
      </g>
   </svg>

   <div class="login container grid" id="loginAccessRegister">
      <!-- Login Access -->
      <div class="login__access">
         <h1 class="login__title">Acesse sua conta</h1>
         
         <!-- Exibir mensagem de erro ou sucesso -->
         <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert">
                <?= $_SESSION['mensagem']; ?>
                <?php unset($_SESSION['mensagem']); ?>
            </div>
         <?php endif; ?>

         <form class="login__form" action="logar.php" method="POST">
            <div class="login__content grid">
                <div class="login__box">
                    <input type="email" name="email" id="inputEmail" required placeholder=" " class="login__input">
                    <label for="email" class="login__label">Email</label>
                    <i class="ri-mail-fill login__icon"></i>
                </div>
                <div class="login__box">
                    <input type="password" name="senha" id="inputPassword" required placeholder=" " class="login__input">
                    <label for="password" class="login__label">Senha</label>
                    <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                </div>
            </div>
            <button type="submit" class="login__button">Login</button>
         </form>

      
         </div>
      </div>
   </div>

   <script src="assets/js/main.js"></script>
</body>
</html>
