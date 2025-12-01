# 👥 Gerenciador de Pessoas - Integração IBGE

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

Sistema robusto de gerenciamento de pessoas (CRUD) desenvolvido com **Laravel**, focado em **Clean Code**, **PSR-12** e **Alta Performance**. O projeto conta com integração automática à API do IBGE para carregamento dinâmico de Estados e Cidades, utilizando estratégias avançadas de cache.

---

## 🚀 Funcionalidades

- **CRUD Completo:** Criação, Leitura, Edição e Exclusão de pessoas.
- **Integração IBGE:** Consumo da API de localidades do IBGE via Service Pattern.
- **Select Dinâmico:** O campo "Cidade" é carregado via AJAX (Vanilla JS) baseado no "Estado" selecionado.
- **Performance:** Cacheamento das requisições do IBGE em Banco de Dados para evitar latência e dependência externa.
- **UX/UI:** Interface responsiva, semântica e com feedback visual de erros.
- **Zona de Perigo:** Confirmação segura para exclusão de registros.

---

## 🛠️ Tecnologias e Padrões

O projeto foi construído seguindo rigorosos padrões de qualidade:

- **Backend:** Laravel 10/11 (PHP 8.2+).
- **Frontend:** Blade Templates, CSS3 (Grid/Flexbox) e JavaScript Puro (Sem jQuery).
- **Ambiente:** Docker via Laravel Sail (WSL2).
- **Code Quality:**
  - **Strict Types:** `declare(strict_types=1)` em todos os arquivos críticos.
  - **Service Pattern:** Lógica de negócio e integração externa isoladas no `IbgeService`.
  - **Dependency Injection:** Injeção via construtor (Constructor Property Promotion).
  - **PSR-12:** Estilo de código padronizado via Laravel Pint.

---

## ⚙️ Instalação e Configuração

Este projeto utiliza **Laravel Sail** (Docker). Certifique-se de ter o Docker Desktop e o WSL2 instalados.

### 1. Clonar o repositório

```bash
git clone https://github.com/seu-usuario/nome-do-repo.git
cd nome-do-repo
```

### 2. Configurar Variáveis de Ambiente

```bash
cp .env.example .env
```

*Configure o banco de dados no .env se necessário, mas o padrão do Sail já funciona.*

### 3. Subir os Containers

```bash
./vendor/bin/sail up -d
```

### 4. Instalar Dependências e Gerar Key

```bash
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
```

### 5. Migrations e Cache

É essencial rodar as migrations para criar a tabela de cache e a estrutura de pessoas.

```bash
./vendor/bin/sail artisan migrate
```

### 6. Acessar

O projeto estará disponível em:
👉 **http://localhost**

---

## 🏗️ Decisões Arquiteturais

### Service Layer e Cache Strategy

Para não poluir o Controller e garantir resiliência, foi criado o `IbgeService`.

- **Request Time:** A primeira requisição busca na API do IBGE.
- **Persistence:** O retorno é salvo na tabela `cache` do banco de dados (Driver `database`).
- **Resilience:** Se a API do IBGE cair, o sistema continua funcionando com os dados cacheados.

### Frontend (No-Framework)

Optou-se por **CSS Puro** (`layout.css`) em vez de frameworks pesados (Bootstrap/Tailwind) para demonstrar domínio de CSS Grid, Flexbox e responsividade, mantendo o projeto extremamente leve.

### Validação e Segurança

- Uso de **Form Requests** (`StorePersonRequest`, `UpdatePersonRequest`) para validação.
- Proteção contra **Mass Assignment** no Model.
- Tratamento de tipos estritos (`string|int`) para garantir integridade dos IDs.

---

## 🧪 Comandos Úteis

**Limpar Cache (Otimização):**

```bash
./vendor/bin/sail artisan optimize:clear
```

**Verificar Padrão de Código (Lint):**

```bash
./vendor/bin/sail pint
```

---

## 📝 Licença

Este projeto está sob a licença MIT.

---

<p align="center">
Desenvolvido com 💚 por <strong>Gustavo</strong>
</p>
