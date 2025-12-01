# 👥 Gerenciador de Pessoas - Integração IBGE

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

Sistema robusto de gerenciamento de pessoas (CRUD) desenvolvido com **Laravel**, focado em **Clean Code**, **PSR-12** e **Alta Performance**. O projeto conta com integração automática à API do IBGE para carregamento dinâmico de Estados e Cidades, utilizando estratégias avançadas de cache.

---

## 📑 Índice

- [Funcionalidades](#-funcionalidades)
- [Pré-requisitos](#-pré-requisitos)
- [Instalação](#-instalação)
  - [Windows (WSL2)](#windows-wsl2)
  - [Linux](#linux)
  - [macOS](#macos)
- [Configuração](#-configuração)
- [Uso](#-uso)
- [Tecnologias e Padrões](#%EF%B8%8F-tecnologias-e-padrões)
- [Arquitetura](#%EF%B8%8F-arquitetura)
- [Comandos Úteis](#-comandos-úteis)
- [Troubleshooting](#-troubleshooting)

---

## 🚀 Funcionalidades

- ✅ **CRUD Completo:** Criação, Leitura, Edição e Exclusão de pessoas
- 🌎 **Integração IBGE:** Consumo da API de localidades do IBGE via Service Pattern
- ⚡ **Select Dinâmico:** Campo "Cidade" carregado via AJAX (Vanilla JS) baseado no "Estado"
- 🚄 **Alta Performance:** Cacheamento inteligente das requisições do IBGE em banco de dados
- 🎨 **UX/UI Moderna:** Interface responsiva, semântica e com feedback visual de erros
- 🛡️ **Zona de Perigo:** Confirmação segura para exclusão de registros

---

## 📋 Pré-requisitos

Escolha seu sistema operacional abaixo:

<details>
<summary><strong>Windows (WSL2)</strong></summary>

### Requisitos
- Windows 10 versão 2004+ ou Windows 11
- WSL2 instalado e configurado
- Docker Desktop 4.0+

### Instalação do WSL2

```powershell
# Execute no PowerShell como Administrador
wsl --install
```

Após a instalação, reinicie o computador e configure seu usuário Linux.

### Instalação do Docker Desktop

1. Baixe o [Docker Desktop para Windows](https://www.docker.com/products/docker-desktop/)
2. Execute o instalador
3. Após instalação, abra o Docker Desktop
4. Vá em **Settings** → **Resources** → **WSL Integration**
5. Ative a integração com sua distribuição WSL2

### Verificação

```bash
# No terminal WSL2
docker --version
docker compose version
```

</details>

<details>
<summary><strong>Linux (Ubuntu/Debian)</strong></summary>

### Instalação do Docker

```bash
# Atualizar repositórios
sudo apt-get update

# Instalar dependências
sudo apt-get install ca-certificates curl gnupg

# Adicionar chave GPG oficial do Docker
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

# Adicionar repositório
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Instalar Docker
sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

# Adicionar seu usuário ao grupo docker (para não precisar de sudo)
sudo usermod -aG docker $USER
newgrp docker
```

### Verificação

```bash
docker --version
docker compose version
```

</details>

<details>
<summary><strong>Linux (Fedora/RHEL)</strong></summary>

### Instalação do Docker

```bash
# Remover versões antigas
sudo dnf remove docker docker-client docker-client-latest docker-common docker-latest docker-latest-logrotate docker-logrotate docker-selinux docker-engine-selinux docker-engine

# Instalar repositório
sudo dnf -y install dnf-plugins-core
sudo dnf config-manager --add-repo https://download.docker.com/linux/fedora/docker-ce.repo

# Instalar Docker
sudo dnf install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

# Iniciar serviço
sudo systemctl start docker
sudo systemctl enable docker

# Adicionar usuário ao grupo
sudo usermod -aG docker $USER
newgrp docker
```

</details>

<details>
<summary><strong>Linux (Arch)</strong></summary>

### Instalação do Docker

```bash
# Instalar Docker
sudo pacman -S docker docker-compose

# Iniciar serviço
sudo systemctl start docker.service
sudo systemctl enable docker.service

# Adicionar usuário ao grupo
sudo usermod -aG docker $USER
newgrp docker
```

</details>

<details>
<summary><strong>macOS</strong></summary>

### Usando Homebrew (Recomendado)

```bash
# Instalar Docker Desktop
brew install --cask docker

# Ou instalar via download direto:
# https://www.docker.com/products/docker-desktop/
```

Após instalação, abra o Docker Desktop pela primeira vez para finalizar a configuração.

### Verificação

```bash
docker --version
docker compose version
```

</details>

---

## 🔧 Instalação

### Método 1: Instalação Padrão (Com Composer Local)

```bash
# 1. Clonar o repositório
git clone https://github.com/seu-usuario/gerenciador-pessoas-ibge.git
cd gerenciador-pessoas-ibge

# 2. Instalar dependências
composer install

# 3. Copiar arquivo de ambiente
cp .env.example .env

# 4. Iniciar containers Docker
./vendor/bin/sail up -d

# 5. Gerar chave da aplicação
./vendor/bin/sail artisan key:generate

# 6. Rodar migrations
./vendor/bin/sail artisan migrate

# 7. Acessar aplicação
# http://localhost
```

### Método 2: Instalação Sem Composer Local (Recomendado para iniciantes)

```bash
# 1. Clonar o repositório
git clone https://github.com/seu-usuario/gerenciador-pessoas-ibge.git
cd gerenciador-pessoas-ibge

# 2. Copiar arquivo de ambiente
cp .env.example .env

# 3. Instalar dependências via Docker
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# 4. Iniciar containers
./vendor/bin/sail up -d

# 5. Gerar chave da aplicação
./vendor/bin/sail artisan key:generate

# 6. Rodar migrations
./vendor/bin/sail artisan migrate

# 7. Acessar aplicação
# http://localhost
```

---

## ⚙️ Configuração

### Configuração do Banco de Dados

O Laravel Sail já vem pré-configurado, mas é importante verificar o arquivo `.env`:

```env
# Configuração do MySQL (via Docker)
DB_CONNECTION=mysql
DB_HOST=mysql          # ⚠️ IMPORTANTE: Use "mysql", não "localhost" ou "127.0.0.1"
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

**Por que `DB_HOST=mysql`?**
- O Laravel roda dentro de um container Docker
- Precisa acessar o MySQL que está em **outro** container
- `mysql` é o nome do serviço no `docker-compose.yml`
- Usar `localhost` ou `127.0.0.1` fará a aplicação buscar o MySQL no próprio container (onde ele não existe)

### Configuração de Cache

O sistema usa cache em banco de dados para as requisições do IBGE:

```env
CACHE_DRIVER=database
CACHE_PREFIX=laravel_cache
```

### Porta da Aplicação (Opcional)

Por padrão, a aplicação roda na porta 80. Para mudar:

```env
APP_PORT=8000  # Acesse via http://localhost:8000
```

---

## 💻 Uso

### Iniciando a Aplicação

```bash
# Iniciar containers em background
./vendor/bin/sail up -d

# Ver logs em tempo real
./vendor/bin/sail logs -f

# Parar containers
./vendor/bin/sail down
```

### Alias para Facilitar (Recomendado)

Adicione ao seu `~/.bashrc` ou `~/.zshrc`:

```bash
alias sail='./vendor/bin/sail'
```

Depois disso, você pode usar apenas:

```bash
sail up -d
sail artisan migrate
sail composer install
```

### Acessando o Sistema

1. Abra o navegador em `http://localhost`
2. Você verá a listagem de pessoas
3. Clique em **"Nova Pessoa"** para adicionar
4. Selecione um estado e veja as cidades carregarem automaticamente
5. Preencha os dados e clique em **"Salvar"**

---

## 🛠️ Tecnologias e Padrões

### Stack Tecnológica

| Tecnologia | Versão | Uso |
|------------|--------|-----|
| **Laravel** | 10/11 | Framework PHP |
| **PHP** | 8.2+ | Linguagem backend |
| **MySQL** | 8.0 | Banco de dados |
| **Docker** | 24.0+ | Containerização |
| **Blade** | - | Template engine |
| **JavaScript** | ES6+ | Frontend interativo |

### Padrões de Código

- ✅ **PSR-12:** Padrão de código PHP seguido via Laravel Pint
- ✅ **Strict Types:** `declare(strict_types=1)` em arquivos críticos
- ✅ **Service Pattern:** Lógica de negócio isolada em Services
- ✅ **Dependency Injection:** Injeção via construtor
- ✅ **Form Requests:** Validação dedicada e reutilizável
- ✅ **Repository Pattern:** Abstração da camada de dados
- ✅ **SOLID Principles:** Código orientado a princípios sólidos

---

## 🏗️ Arquitetura

### Estrutura de Diretórios

```
app/
├── Http/
│   ├── Controllers/
│   │   └── PersonController.php    # Controller principal
│   └── Requests/
│       ├── StorePersonRequest.php  # Validação de criação
│       └── UpdatePersonRequest.php # Validação de atualização
├── Models/
│   └── Person.php                  # Model Eloquent
└── Services/
    └── IbgeService.php             # Service de integração IBGE

resources/
├── views/
│   ├── people/
│   │   ├── index.blade.php         # Listagem
│   │   ├── create.blade.php        # Formulário de criação
│   │   └── edit.blade.php          # Formulário de edição
│   └── layouts/
│       └── app.blade.php           # Layout base
└── css/
    └── layout.css                  # Estilos personalizados

public/
└── js/
    └── city-loader.js              # Script AJAX para cidades

routes/
└── web.php                         # Rotas da aplicação
```

### Service Layer: IbgeService

O `IbgeService` é responsável por:

1. **Buscar estados** da API do IBGE
2. **Buscar cidades** de um estado específico
3. **Cachear** os resultados em banco de dados
4. **Garantir resiliência** caso a API do IBGE fique indisponível

```php
// Exemplo de uso
$estados = $ibgeService->getEstados();
$cidades = $ibgeService->getCidadesPorEstado(35); // São Paulo
```

### Estratégia de Cache

- **Driver:** `database` (tabela `cache`)
- **TTL:** 30 dias para estados e cidades
- **Benefícios:**
  - Reduz latência de 500ms para ~10ms
  - Elimina dependência da API externa
  - Melhora experiência do usuário

### Frontend: Select Dinâmico

O JavaScript (`city-loader.js`) escuta mudanças no select de estados:

```javascript
// Quando o estado muda
estadoSelect.addEventListener('change', async (e) => {
  const estadoId = e.target.value;
  
  // Faz requisição AJAX
  const response = await fetch(`/api/cidades/${estadoId}`);
  const cidades = await response.json();
  
  // Popula o select de cidades
  // ...
});
```

---

## 🧪 Comandos Úteis

### Artisan

```bash
# Limpar todos os caches
sail artisan optimize:clear

# Limpar apenas cache de aplicação
sail artisan cache:clear

# Rodar migrations
sail artisan migrate

# Reverter última migration
sail artisan migrate:rollback

# Recriar banco do zero
sail artisan migrate:fresh

# Rodar seeders
sail artisan db:seed

# Criar nova migration
sail artisan make:migration create_exemplo_table

# Criar novo controller
sail artisan make:controller ExemploController

# Criar novo model
sail artisan make:model Exemplo -m  # -m cria migration junto
```

### Composer

```bash
# Instalar dependências
sail composer install

# Atualizar dependências
sail composer update

# Adicionar pacote
sail composer require pacote/nome

# Remover pacote
sail composer remove pacote/nome
```

### Code Quality

```bash
# Verificar estilo de código (PSR-12)
sail pint --test

# Corrigir estilo de código automaticamente
sail pint

# Rodar testes (se houver)
sail artisan test
```

### Docker

```bash
# Ver containers rodando
sail ps

# Entrar no container da aplicação
sail shell

# Entrar no MySQL
sail mysql

# Ver logs
sail logs

# Ver logs de um serviço específico
sail logs mysql

# Reiniciar containers
sail restart

# Parar e remover containers
sail down
```

---

## 🐛 Troubleshooting

### Problema: "SQLSTATE[HY000] [2002] Connection refused"

**Causa:** O Laravel está tentando conectar ao MySQL em `localhost` em vez do container.

**Solução:**
```bash
# Verifique o .env
DB_HOST=mysql  # ✅ Correto
# DB_HOST=localhost  # ❌ Errado
# DB_HOST=127.0.0.1  # ❌ Errado

# Limpe o cache de configuração
sail artisan config:clear
```

### Problema: "Permission denied" ao rodar `./vendor/bin/sail`

**Solução:**
```bash
chmod +x vendor/bin/sail
```

### Problema: Porta 80 já está em uso

**Solução 1:** Parar o serviço que está usando a porta
```bash
# No Windows
# Parar IIS ou Apache se estiver rodando

# No Linux
sudo systemctl stop apache2
# ou
sudo systemctl stop nginx
```

**Solução 2:** Mudar a porta no `.env`
```env
APP_PORT=8000
```

Depois acesse via `http://localhost:8000`

### Problema: Containers não sobem no WSL2

**Solução:**
```bash
# Reiniciar o Docker Desktop no Windows

# Ou reiniciar o WSL2
wsl --shutdown
# Depois abra novamente o terminal WSL
```

### Problema: Cidades não carregam ao selecionar estado

**Verificações:**

1. **Verificar se a rota API existe:**
```bash
sail artisan route:list | grep cidades
```

2. **Verificar console do navegador:**
- Abra as DevTools (F12)
- Veja se há erros JavaScript
- Verifique a aba Network para ver a requisição AJAX

3. **Verificar cache do IBGE:**
```bash
sail artisan cache:clear
```

### Problema: Layout/CSS não carrega

**Solução:**
```bash
# Limpar cache de views
sail artisan view:clear

# Republicar assets se necessário
sail artisan vendor:publish
```

---

<p align="center">
Desenvolvido com 💚 por <strong>Gustavo</strong>
</p>
