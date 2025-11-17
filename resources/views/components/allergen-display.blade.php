@props([
    'allergens' => null,
    'mode' => 'compact', // compact, full, simple, minimal
    'maxVisible' => 3
])

@php
    // OTTIMIZZAZIONE: Collezione allergeni unificata con cache-aware loading
    $allergenCollection = collect();
    
    if($allergens && method_exists($allergens, 'getAllAllergens')) {
        // Per modelli con getAllAllergens() (Pizza, Appetizer, etc.) - ORA OTTIMIZZATO
        $allergenCollection = $allergens->getAllAllergens();
    } elseif($allergens && is_object($allergens) && !empty($allergens->manual_allergens)) {
        // Per bevande con allergeni manuali JSON
        $manual = json_decode($allergens->manual_allergens, true);
        if(is_array($manual) && count($manual) > 0) {
            $allergenCollection = \App\Models\Allergen::whereIn('id', $manual)->get();
        }
    } elseif($allergens && is_iterable($allergens)) {
        // Collection diretta di allergeni
        $allergenCollection = collect($allergens);
    }
    
    $hasAllergens = $allergenCollection->isNotEmpty();
    $totalCount = $allergenCollection->count();
    
    // Performance: se non ci sono allergeni, esci subito
    if($allergenCollection->isEmpty()) {
        // Non fare return qui, mostra badge "sicuro"
    }
    
    // Limita il numero di allergeni visibili per performance
    $visibleAllergens = $allergenCollection->take($maxVisible);
    $hiddenCount = max(0, $allergenCollection->count() - $maxVisible);
    
    // Icone semantiche per allergeni comuni
    $allergenIcons = [
        'glutine' => 'Glutine',
        'latte' => 'Latte', 
        'lattosio' => 'Lattosio',
        'uova' => 'Uova',
        'pesce' => 'Pesce',
        'crostacei' => 'Crostacei',
        'frutta a guscio' => 'Frutta guscio',
        'arachidi' => 'Arachidi',
        'soia' => 'Soia',
        'sedano' => 'Sedano',
        'senape' => 'Senape',
        'sesamo' => 'Sesamo',
        'solfiti' => 'Solfiti',
        'nichel' => 'Nichel',
        'molluschi' => 'Molluschi',
        'lupini' => 'Lupini'
    ];
@endphp

<div class="allergen-display" role="region" aria-label="Informazioni allergeni">
    @if(!$hasAllergens)
        {{-- Stato sicuro - nessun allergene --}}
        @if($mode === 'full')
            <div class="allergen-safe">
                <span class="badge badge-success d-flex align-items-center">
                    <i class="fas fa-shield-check me-2" aria-hidden="true"></i>
                    <span>Sicuro per Allergeni</span>
                </span>
            </div>
        @else
            <span class="badge badge-success">
                <i class="fas fa-check me-1" aria-hidden="true"></i>Sicuro
            </span>
        @endif
    @else
        {{-- Ha allergeni - visualizzazione smart --}}
        @if($mode === 'full')
            {{-- Modalità completa con tutti gli allergeni --}}
            <div class="allergen-full">
                <div class="small text-warning fw-bold mb-2">
                    <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i>
                    Contiene {{ $totalCount }} {{ $totalCount === 1 ? 'allergene' : 'allergeni' }}:
                </div>
                <div class="d-flex flex-wrap gap-1">
                    @foreach($allergenCollection as $allergen)
                        @php
                            $name = strtolower($allergen->name);
                            $icon = 'Allergene'; // default
                            foreach($allergenIcons as $key => $value) {
                                if(str_contains($name, $key)) {
                                    $icon = $value;
                                    break;
                                }
                            }
                        @endphp
                        <span class="badge badge-warning d-flex align-items-center" 
                              title="Allergene: {{ $allergen->name }}">
                            <span class="me-1">{{ $icon }}</span>
                            <span>{{ $allergen->name }}</span>
                        </span>
                    @endforeach
                </div>
            </div>
        @elseif($mode === 'compact')
            {{-- Modalità compatta con preview + conteggio --}}
            <div class="allergen-compact">
                <div class="small text-warning mb-1">
                    <i class="fas fa-shield-alt me-1" aria-hidden="true"></i>Allergeni:
                </div>
                <div class="d-flex flex-wrap gap-1 align-items-center">
                    @foreach($allergenCollection->take($maxVisible) as $allergen)
                        @php
                            $name = strtolower($allergen->name);
                            $icon = 'Allergene';
                            foreach($allergenIcons as $key => $value) {
                                if(str_contains($name, $key)) {
                                    $icon = $value;
                                    break;
                                }
                            }
                        @endphp
                        <span class="badge badge-warning-subtle" 
                              title="Allergene: {{ $allergen->name }}">
                            {{ $icon }} {{ \Illuminate\Support\Str::limit($allergen->name, 8) }}
                        </span>
                    @endforeach
                    
                    @if($totalCount > $maxVisible)
                        <span class="badge badge-secondary" 
                              title="Altri {{ $totalCount - $maxVisible }} allergeni">
                            +{{ $totalCount - $maxVisible }}
                        </span>
                    @endif
                </div>
            </div>
        @elseif($mode === 'minimal')
            {{-- Modalità minimalista per viste elenco - solo icone --}}
            <div class="allergen-minimal d-flex align-items-center gap-1">
                @foreach($allergenCollection->take($maxVisible) as $allergen)
                    @php
                        $name = strtolower($allergen->name);
                        $icon = 'Allergene';
                        foreach($allergenIcons as $key => $value) {
                            if(str_contains($name, $key)) {
                                $icon = $value;
                                break;
                            }
                        }
                    @endphp
                    <span class="allergen-icon" 
                          title="Contiene: {{ $allergen->name }}"
                          aria-label="Allergene {{ $allergen->name }}">
                        {{ $icon }}
                    </span>
                @endforeach
                
                @if($totalCount > $maxVisible)
                    <small class="text-warning ms-1" 
                           title="Contiene altri {{ $totalCount - $maxVisible }} allergeni"
                           aria-label="Altri {{ $totalCount - $maxVisible }} allergeni">
                        +{{ $totalCount - $maxVisible }}
                    </small>
                @endif
            </div>
        @else
            {{-- Modalità semplice - solo conteggio smart --}}
            <span class="badge badge-warning" 
                  title="Contiene {{ $totalCount }} {{ $totalCount === 1 ? 'allergene' : 'allergeni' }}">
                <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i>
                {{ $totalCount }} allergeni
            </span>
        @endif
    @endif
</div>