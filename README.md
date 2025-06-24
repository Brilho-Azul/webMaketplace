# 💻 Projeto - Sistema de Login, Cadastro e Futuro Marketplace

## 📑 Descrição
Este projeto está sendo desenvolvido como parte do trabalho da disciplina de **Programação para Web**, um minisistema. Atualmente, consiste em um sistema de **Login e Cadastro responsivo**, utilizando HTML, CSS, JavaScript e PHP. 

O sistema possui uma interface intuitiva com alternância entre as telas de login e cadastro, além de um design moderno e adaptável a diferentes tamanhos de tela.

---

## 🚀 Instruções para Iniciar o Projeto Localmente

### ✅ Pré-requisitos

- ✔️ Instalar o [XAMPP](https://www.apachefriends.org/pt_br/download.html) no seu computador.

---

### 🔥 Passo a Passo

1. **Instale o XAMPP** no seu computador.

2. **Abra o XAMPP Control Panel**:
   - Clique em **Start** no **Apache**.
   - Clique em **Start** no **MySQL**.

3. **Acesse a pasta onde o XAMPP está instalado**:
   - Normalmente em:  
   `C:\xampp`

4. **Abra a pasta `htdocs`** dentro da pasta do XAMPP:
   - Caminho:  
   `C:\xampp\htdocs`

5. **Copie a pasta do projeto para dentro de `htdocs`**:
   - Exemplo:  
   `C:\xampp\htdocs\webMarketplace`

6. **Entre no site.**:
   - No navegador, acesse:  
   [http://localhost/webMarketplace/index.php](http://localhost/webMarketplace/conexao.php)  
   → Isso criará o banco de dados e todas as tabelas automaticamente, mas você pode importar também.

### 🔑 Dados de Acesso (Gerente padrão)

- **Email:** gerente@admin.com  
- **Senha:** gerente123 
- Acesse para usar os princípios CRUD.
- Crie uma conta para ver o dashboard do cliente (opcional).




### ⚙️ Acesso ao phpMyAdmin (opcional)

- Link:  
[http://localhost/phpmyadmin](http://localhost/phpmyadmin)  
→ Aqui você pode visualizar o banco, tabelas e dados do sistema.

---

## ❗ Observações Importantes

- 🔸 Sempre mantenha o **Apache** e **MySQL** ativos no XAMPP enquanto usa o sistema.
- 🔸 Se desejar alterar a senha do gerente, pode fazer pelo **phpMyAdmin** ou diretamente no sistema (caso tenha criado essa funcionalidade).
- 🔸 Caso apareça algum erro como `Warning: Undefined array key`, verifique se:
  - O banco foi criado corretamente.
  - O arquivo `conexao.php` foi executado antes.

---

## 🚀 Funcionalidades atuais
- [x] Tela de **Login**
- [x] Tela de **Cadastro**
- [x] Alternância entre Login e Cadastro
- [x] Validação visual dos campos
- [x] Layout responsivo
- [x] Efeito de mostrar/ocultar senha

---

## 🔥 Funcionalidades futuras (Em desenvolvimento)
- [x] Tela de **Dashboard** (Gerente)
- [x] Controle de acesso (Admin e Cliente comum)
- [x] Sistema completo de **CRUD**:
  - [x] **Cadastro** de usuários, produtos e servicos
  - [x] **Listagem** de dados (produtos e servicos)
  - [x] **Edição** de dados (produtos e servicos)
  - [x] **Exclusão** de dados (produtos e servicos)
- [x] Integração com **PHP e SQL Lite**
- [x] Implementação de **Login funcional** com verificação no banco de dados
- [x] Sistema de **sessões e autenticação** (Opcional)
- [x] Criptografia de senhas 

---

## 🗂️ Tecnologias Utilizadas
- ✅ **Frontend:**
  - HTML5
  - CSS3
  - JavaScript
- ✅ **Backend (Futuro):**
  - PHP
  - MySQL
- ✅ **Versionamento:**
  - Git e GitHub

---

