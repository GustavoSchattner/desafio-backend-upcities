<section class="form-container">
    <header class="form-header">
        <h2>{{ isset($person) ? 'Editar Pessoa' : 'Nova Pessoa' }}</h2>
    </header>

    <form action="{{ isset($person) ? route('people.update', $person->id) : route('people.store') }}" method="POST">
        @csrf
        @if(isset($person))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Nome Completo</label>
            <input type="text" id="name" name="name" 
                   value="{{ old('name', $person->name ?? '') }}" 
                   class="@error('name') input-error @enderror" required>
            @error('name') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-row"> 
            <div class="form-group half-width">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" 
                       value="{{ old('cpf', $person->cpf ?? '') }}" 
                       class="@error('cpf') input-error @enderror" required>
                @error('cpf') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group half-width">
                <label for="birth_date">Nascimento</label>
                <input type="date" id="birth_date" name="birth_date" 
                       value="{{ old('birth_date', $person->birth_date ?? '') }}" 
                       class="@error('birth_date') input-error @enderror" required>
                @error('birth_date') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group half-width">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       value="{{ old('email', $person->email ?? '') }}" 
                       class="@error('email') input-error @enderror" required>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group half-width">
                <label for="phone_number">Telefone</label>
                <input type="text" id="phone_number" name="phone_number" 
                       value="{{ old('phone_number', $person->phone_number ?? '') }}" 
                       class="@error('phone_number') input-error @enderror" required>
                @error('phone_number') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="address">Endereço</label>
            <input type="text" id="address" name="address" 
                   value="{{ old('address', $person->address ?? '') }}" 
                   class="@error('address') input-error @enderror" required>
            @error('address') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <div class="form-group half-width">
                <label for="uf_id">Estado</label>
                <select id="state_select" name="uf_id" class="@error('uf_id') input-error @enderror" required>
                    <option value="">Selecione o Estado</option>
                    @foreach($states as $state)
                        <option value="{{ $state['id'] }}" 
                            {{ (old('uf_id', $person->uf_id ?? '') == $state['id']) ? 'selected' : '' }}>
                            {{ $state['nome'] }} ({{ $state['sigla'] }})
                        </option>
                    @endforeach
                </select>
                @error('uf_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group half-width">
                <label for="city_id">Cidade</label>
                <select id="city_select" name="city_id" 
                        data-selected="{{ old('city_id', $person->city_id ?? '') }}"
                        class="@error('city_id') input-error @enderror" required disabled>
                    <option value="">Selecione um Estado primeiro...</option>
                </select>
                @error('city_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('people.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Dados</button>
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stateSelect = document.getElementById('state_select');
        const citySelect = document.getElementById('city_select');
        const selectedCityId = citySelect.getAttribute('data-selected');

        // Função para carregar cidades
        function loadCities(ufId) {
            if (!ufId) {
                citySelect.innerHTML = '<option value="">Selecione um Estado primeiro...</option>';
                citySelect.disabled = true;
                return;
            }

            // UI de carregamento
            citySelect.disabled = true;
            citySelect.innerHTML = '<option value="">Carregando cidades...</option>';

            // Chama a rota da API no Controller
            fetch(`/api/cities/${ufId}`)
                .then(response => response.json())
                .then(cities => {
                    citySelect.innerHTML = '<option value="">Selecione a cidade</option>';
                    
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id; 
                        option.textContent = city.nome;
                        
                        if (selectedCityId && (city.id == selectedCityId || city.nome == selectedCityId)) {
                            option.selected = true;
                        }
                        
                        citySelect.appendChild(option);
                    });
                    
                    citySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Erro ao carregar cidades:', error);
                    citySelect.innerHTML = '<option value="">Erro ao carregar</option>';
                });
        }

        // Evento de mudança
        stateSelect.addEventListener('change', function() {
            loadCities(this.value);
        });

        // Se já tiver um estado selecionado (Edição ou Erro de validação), carrega as cidades
        if (stateSelect.value) {
            loadCities(stateSelect.value);
        }
    });
</script>
