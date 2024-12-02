/*=============== SHOW HIDE PASSWORD LOGIN ===============*/
const passwordAccess = (loginPass, loginEye) => {
   const input = document.getElementById(loginPass),
         iconEye = document.getElementById(loginEye);

   iconEye.addEventListener('click', () => {
      // Change password to text
      input.type = input.type === 'password' ? 'text' : 'password';

      // Icon change
      iconEye.classList.toggle('ri-eye-fill');
      iconEye.classList.toggle('ri-eye-off-fill');
   });
};
passwordAccess('password', 'loginPassword');

/*=============== SHOW HIDE PASSWORD CREATE ACCOUNT ===============*/
const passwordRegister = (loginPass, loginEye) => {
   const input = document.getElementById(loginPass),
         iconEye = document.getElementById(loginEye);

   iconEye.addEventListener('click', () => {
      // Change password to text
      input.type = input.type === 'password' ? 'text' : 'password';

      // Icon change
      iconEye.classList.toggle('ri-eye-fill');
      iconEye.classList.toggle('ri-eye-off-fill');
   });
};
passwordRegister('passwordCreate', 'loginPasswordCreate');

/*=============== SHOW HIDE LOGIN & CREATE ACCOUNT ===============*/
const loginAccessRegister = document.getElementById('loginAccessRegister'),
      buttonRegister = document.getElementById('loginButtonRegister'),
      buttonAccess = document.getElementById('loginButtonAccess');

// Função para mostrar o formulário de registrar
buttonRegister.addEventListener('click', () => {
   loginAccessRegister.classList.add('active');
});

// Função para mostrar o formulário de login
buttonAccess.addEventListener('click', () => {
   loginAccessRegister.classList.remove('active');
});
