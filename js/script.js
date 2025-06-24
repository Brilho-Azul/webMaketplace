// Alternar entre Login e Cadastro
const loginToggle = document.getElementById('login-toggle');
const signupToggle = document.getElementById('signup-toggle');
const loginForm = document.getElementById('login-form');
const signupForm = document.getElementById('signup-form');

if (loginToggle && signupToggle && loginForm && signupForm) {
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
}

// Mostrar/Ocultar Senha
document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', () => {
        const input = document.querySelector(icon.getAttribute('toggle'));
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    });
});

// Valida cadastramento
if (signupForm) {
    signupForm.addEventListener('submit', async function (e) {
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
}

// Login
if (loginForm) {
    loginForm.addEventListener('submit', async function (e) {
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
}

// Formata o campo de preco
document.addEventListener('DOMContentLoaded', function () {
    const precoInput = document.getElementById('preco');
    const formatoPreco = '0,00';
    const vazio = '';

    function formatarPreco(valor) {
        valor = valor.replace(/\D/g, vazio);
        if (!valor) return formatoPreco;

        const floatValue = (parseInt(valor) / 100).toFixed(2);
        const [inteira, decimal] = floatValue.split('.');
        const comPontos = inteira.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        return `${comPontos},${decimal}`;
    }

    if (precoInput) {
        precoInput.addEventListener('focus', function () {
            if (!this.value) this.value = formatoPreco;
        });

        precoInput.addEventListener('input', function () {
            this.value = formatarPreco(this.value);
        });

        precoInput.addEventListener('blur', function () {
            if (this.value === formatoPreco) this.value = vazio;
        });
    }
});
