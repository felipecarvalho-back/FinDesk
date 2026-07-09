# 🖥️ FinDesk — Gerenciador Financeiro Desktop

O **FinDesk** é um gerenciador financeiro pessoal desenvolvido como um aplicativo desktop nativo. Ele foi construído utilizando o ecossistema Laravel combinado com o **NativePHP** para empacotamento desktop (Electron), fornecendo uma interface leve, rápida e offline para controle de despesas e rendimentos mensais.

---

## ✨ Funcionalidades

* 🔐 **Autenticação Segura:** Proteção por senha local ao iniciar o app, com expiração automática de sessão ao fechar a janela.
* 📊 **Dashboard Dinâmico:** Visão geral de todos os meses cadastrados com cálculos financeiros automáticos.
* ⚙️ **Configurações Globais:** Ajuste de valores padrão (Bolsa Auxílio, Ajuda de Custo Alimentação/Transporte, etc.) que servem como base para novos registros.
* 🧮 **Cálculos Automáticos Inteligentes:**
  * Cálculo do salário teórico proporcional aos dias trabalhados.
  * Cálculo do valor devido para condução/transporte diário e repasses familiares.
  * Cálculo do saldo líquido final após deduções de caixinha, investimentos e faturas de cartão.
* 💾 **Banco de Dados Local:** Armazenamento offline utilizando SQLite.

---

## 🛠️ Tecnologias Utilizadas

* **Framework Web:** [Laravel 13](https://laravel.com)
* **Interface Reativa:** [Livewire 4](https://livewire.laravel.com) & [Livewire Blaze](https://github.com/livewire/blaze)
* **Empacotador Desktop:** [NativePHP v2 (Electron)](https://nativephp.com)
* **Estilização:** [Tailwind CSS v4](https://tailwindcss.com) & [Vite](https://vite.dev)
* **Banco de Dados:** [SQLite](https://www.sqlite.org)
* **Testes:** [Pest PHP v4](https://pestphp.com)

---

## 🚀 Como Executar o Projeto Localmente

### Pré-requisitos
* **PHP 8.3 ou superior**
* **Composer**
* **Node.js (v22 ou superior) & npm**

### Passo a Passo

1. **Clonar o Repositório:**
   ```bash
   git clone <url-do-repositorio>
   cd FinDesk
   ```

2. **Instalar Dependências PHP e Node:**
   ```bash
   composer install
   npm install
   ```

3. **Configurar o Ambiente:**
   Copie o arquivo `.env.example` para `.env`:
   ```bash
   copy .env.example .env
   ```
   *Gere a chave da aplicação:*
   ```bash
   php artisan key:generate
   ```

4. **Executar Migrações e Seeders:**
   ```bash
   php artisan migrate --seed
   ```

5. **Iniciar o Servidor de Desenvolvimento Desktop:**
   Para rodar o app no modo de desenvolvimento:
   ```bash
   composer run native:dev
   ```
   ou rodando separadamente:
   ```bash
   php artisan native:run
   ```

---

## 📦 Como Compilar a Versão de Produção (Build)

Para gerar o instalador executável do aplicativo para Windows:

```bash
php artisan native:build win
```

O instalador gerado estará disponível na pasta `nativephp/electron/dist/`.

---

## 🧪 Testes Automatizados

A aplicação possui testes de lógica de cálculo e autenticação implementados com **Pest**. Para rodar a suíte de testes:

```bash
php artisan test
```

---

## 📄 Licença

Este projeto está sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para obter mais informações.
