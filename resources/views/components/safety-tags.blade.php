@props(['beverage', 'mode' => 'compact'])

@php
    // Safety tags per bevande basate su proprietà del modello
    $safetyTags = [];
    
    // Verifica alcohol_free
    if (empty($beverage->is_alcoholic) || $beverage->is_alcoholic == false) {
        $safetyTags[] = [
            'key' => 'alcohol_free',
            'label' => 'Analcolica',
            'icon' => 'No Alcol',
            'color' => 'success',
            'description' => 'Bevanda senza alcol, sicura per tutti'
        ];
    }
    
    // Verifica gluten_free - se la bevanda non ha allergeni specifici o è esplicitamente gluten-free
    $hasGluten = false;
    if ($beverage->allergens && $beverage->allergens->count() > 0) {
        $hasGluten = $beverage->allergens->where('name', 'like', '%glutine%')->count() > 0;
    }
    
    if (!$hasGluten && (
        stripos($beverage->name, 'senza glutine') !== false ||
        stripos($beverage->description ?? '', 'gluten free') !== false ||
        in_array(strtolower($beverage->name), ['acqua', 'coca cola', 'aranciata', 'sprite', 'tè', 'caffè'])
    )) {
        $safetyTags[] = [
            'key' => 'gluten_free',
            'label' => 'Senza Glutine',
            'icon' => 'No Glutine',
            'color' => 'info',
            'description' => 'Bevanda priva di glutine, sicura per celiaci'
        ];
    }
    
    // Verifica nut_free - controllo allergeni per frutta a guscio
    $hasNuts = false;
    if ($beverage->allergens && $beverage->allergens->count() > 0) {
        $hasNuts = $beverage->allergens->where('name', 'like', '%frutta a guscio%')
                                     ->orWhere('name', 'like', '%arachidi%')
                                     ->orWhere('name', 'like', '%mandorle%')
                                     ->orWhere('name', 'like', '%noci%')
                                     ->count() > 0;
    }
    
    if (!$hasNuts) {
        $safetyTags[] = [
            'key' => 'nut_free',
            'label' => 'Senza Frutta a Guscio',
            'icon' => 'Noci',
            'color' => 'warning',
            'description' => 'Bevanda priva di frutta a guscio e arachidi'
        ];
    }
    
    // Verifica allergen_free - se non ha allergeni specificati
    $hasAllergens = $beverage->allergens && $beverage->allergens->count() > 0;
    if (!$hasAllergens) {
        $safetyTags[] = [
            'key' => 'allergen_free',
            'label' => 'Sicura',
            'icon' => 'OK',
            'color' => 'success',
            'description' => 'Bevanda senza allergeni principali identificati'
        ];
    }
@endphp

<div class="safety-tags" role="region" aria-label="Informazioni di sicurezza per {{ $beverage->name }}">
    @if(count($safetyTags) > 0)
        @if($mode === 'full')
            {{-- Modalità completa con tutte le informazioni --}}
            <div class="safety-tags-full">
                <div class="small text-success fw-bold mb-2">
                    <i class="fas fa-shield-check me-1" aria-hidden="true"></i>
                    Sicurezza bevanda:
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($safetyTags as $tag)
                        <div class="badge bg-{{ $tag['color'] }} bg-opacity-10 border border-{{ $tag['color'] }} d-flex align-items-center px-3 py-2"
                             data-bs-toggle="tooltip"
                             data-bs-placement="top"
                             title="{{ $tag['description'] }}"
                             aria-label="{{ $tag['description'] }}">
                            <span class="me-2">{{ $tag['icon'] }}</span>
                            <span class="fw-semibold">{{ $tag['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif($mode === 'compact')
            {{-- Modalità compatta per card view --}}
            <div class="safety-tags-compact">
                <div class="small text-muted mb-1">
                    <i class="fas fa-shield-alt me-1" aria-hidden="true"></i>Sicurezza:
                </div>
                <div class="d-flex flex-wrap gap-1">
                    @foreach(array_slice($safetyTags, 0, 3) as $tag)
                        <span class="badge bg-{{ $tag['color'] }} bg-opacity-20 text-{{ $tag['color'] }}"
                              data-bs-toggle="tooltip"
                              title="{{ $tag['description'] }}"
                              aria-label="{{ $tag['description'] }}">
                            {{ $tag['icon'] }} {{ $tag['label'] }}
                        </span>
                    @endforeach
                    
                    @if(count($safetyTags) > 3)
                        <span class="badge bg-secondary bg-opacity-20"
                              data-bs-toggle="tooltip"
                              title="Altri {{ count($safetyTags) - 3 }} tag di sicurezza"
                              aria-label="Altri {{ count($safetyTags) - 3 }} tag di sicurezza">
                            +{{ count($safetyTags) - 3 }}
                        </span>
                    @endif
                </div>
            </div>
        @else
            {{-- Modalità minimal per elenco --}}
            <div class="safety-tags-minimal d-flex align-items-center gap-1">
                @foreach(array_slice($safetyTags, 0, 2) as $tag)
                    <span class="safety-tag-icon"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top" 
                          title="{{ $tag['description'] }}"
                          aria-label="{{ $tag['description'] }}">
                        {{ $tag['icon'] }}
                    </span>
                @endforeach
                
                @if(count($safetyTags) > 2)
                    <small class="text-success ms-1"
                           data-bs-toggle="tooltip"
                           title="Altri {{ count($safetyTags) - 2 }} tag di sicurezza"
                           aria-label="Altri {{ count($safetyTags) - 2 }} tag di sicurezza">
                        +{{ count($safetyTags) - 2 }}
                    </small>
                @endif
            </div>
        @endif
    @else
        {{-- Nessun tag di sicurezza disponibile --}}
        <span class="badge bg-light text-muted border"
              data-bs-toggle="tooltip"
              title="Informazioni di sicurezza non disponibili per questa bevanda"
              aria-label="Informazioni di sicurezza non disponibili">
            <i class="fas fa-question me-1" aria-hidden="true"></i>
            Da verificare
        </span>
    @endif
</div>