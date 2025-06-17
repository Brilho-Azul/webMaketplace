// Alternar entre Login e Cadastro
const loginToggle = document.getElementById('login-toggle');
const signupToggle = document.getElementById('signup-toggle');
const loginForm = document.getElementById('login-form');
const signupForm = document.getElementById('signup-form');

loginToggle.addEventListener('click', () => {
    loginToggle.classList.add('active');
    signupToggle.classList.remove('active');
    loginForm.style.display = 'flex';
    signupForm.style.display = 'none';
});

signupToggle.addEventListener('click', () => {
    signupToggle.classList.add('active');
    loginToggle.classList.remove('active');
    signupForm.style.display = 'flex';
    loginForm.style.display = 'none';
});

// Mostrar/Ocultar Senha
document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', () => {
        const input = document.querySelector(icon.getAttribute('toggle'));
        input.type = input.type === 'password' ? 'text' : 'password';
    });
});

// Valida cadastramento
document.getElementById('signup-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const email = form.email.value.trim();
    const confirmEmail = form.confirm_email.value.trim();
    const password = form.password.value;
    const confirmPassword = form.confirm_password.value;

    if (email !== confirmEmail) {
        alert('Emails não conferem!');
        return;
    }
    if (password !== confirmPassword) {
        alert('Senhas não conferem!');
        return;
    }

    const data = new FormData(form);

    const response = await fetch(form.action, {
        method: 'POST',
        body: data
    });

    const result = await response.json();

    alert(result.message);

    if (result.success) {
        form.reset();
        loginToggle.click();
    }
});

// Login
document.getElementById('login-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: data
        });

        const result = await response.json();

        alert(result.message);

        if (result.success) {
            if (result.redirect) {
                window.location.href = result.redirect;
            } else {
                window.location.href = 'dashboard_cliente.php';
            }
        }
    } catch (error) {
        alert('Erro na conexão com o servidor.');
    }
});
