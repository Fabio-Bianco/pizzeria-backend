<section>
    <div class="d-flex justify-content-center">
        <div class="w-100" style="max-width: 480px;">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="card p-4 shadow-sm border-0" enctype="multipart/form-data">
                @csrf
                @method('patch')

                {{-- Avatar --}}
                <div class="mb-4 text-center">
                    <div class="mb-3">
                        @if($user->avatar)
                            <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e5e7eb;">
                        @else
                            <div id="avatar-placeholder" class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px; border: 3px solid #e5e7eb;">
                                <i data-lucide="user" style="width: 60px; height: 60px; color: white;"></i>
                            </div>
                            <img id="avatar-preview" src="" alt="Avatar" class="rounded-circle d-none" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e5e7eb;">
                        @endif
                    </div>
                    <div>
                        <label for="avatar" class="btn btn-sm btn-outline-primary">
                            <i data-lucide="camera" style="width: 16px; height: 16px;"></i> Cambia foto
                        </label>
                        <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*" onchange="previewAvatar(event)">
                        <small class="text-muted d-block mt-2">JPG, PNG, GIF (max 2MB)</small>
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('avatar')" />
                    </div>
                </div>

                <script>
                function previewAvatar(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.getElementById('avatar-preview');
                            const placeholder = document.getElementById('avatar-placeholder');
                            
                            preview.src = e.target.result;
                            preview.classList.remove('d-none');
                            
                            if (placeholder) {
                                placeholder.classList.add('d-none');
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                }
                </script>

                <div class="mb-3">
                    <x-input-label for="name" value="Nome" />
                    <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
                </div>


                                                <div class="row g-2 mb-3 align-items-end">
                                                    <div class="col-12 col-md-6">
                                                        <x-input-label for="email" value="Email" />
                                                        <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username" />
                                                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />
                                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                                            <div class="form-text mt-1">
                                                                Email non verificata. <button form="send-verification" class="btn btn-link p-0 align-baseline">Invia verifica</button>
                                                            </div>
                                                            @if (session('status') === 'verification-link-sent')
                                                                <div class="form-text text-success mt-1">Un nuovo link di verifica è stato inviato al tuo indirizzo email.</div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <x-input-label for="phone" value="Telefono" />
                                                        <x-text-input id="phone" name="phone" type="text" class="form-control" :value="old('phone', $user->phone)" autocomplete="tel" />
                                                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('phone')" />
                                                    </div>
                                                </div>

                <div class="d-flex align-items-center gap-3 mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-4">
                        <i class="fas fa-save me-2" aria-hidden="true"></i> Salva
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
