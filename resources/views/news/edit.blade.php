<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full flex-col gap-3">
            <h1 class="text-3xl font-semibold text-slate-900 dark:text-white">Edit News</h1>
            <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span>/</span>
                <a href="{{ route('news.index') }}" class="hover:text-indigo-600">News</a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200">Edit</span>
            </nav>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="block">
                            <span class="text-sm text-slate-700 dark:text-slate-300">Title</span>
                            <input 
                                type="text" 
                                name="title" 
                                id="title"
                                value="{{ old('title', $news->title) }}" 
                                class="mt-1 w-full rounded-md border-slate-200 px-3 py-2" 
                                required>
                        </label>
                        <label class="block">
                            <span class="text-sm text-slate-700 dark:text-slate-300">Slug (opsional)</span>
                            <input 
                                type="text" 
                                name="slug" 
                                id="slug"
                                value="{{ old('slug', $news->slug) }}" 
                                class="mt-1 w-full rounded-md border-slate-200 px-3 py-2" 
                                placeholder="custom-slug-optional">
                        </label>
                    </div>

                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Tags</span>
                        <div class="mt-1">
                            <div class="tag-picker" data-available-tags='{{ json_encode($allTags->map(fn($t)=>['id'=>$t->id,'name'=>$t->name])->all()) }}' data-old-tags='{{ json_encode(old('tags', $selectedTags ?? [])) }}'>
                                <div class="flex flex-wrap gap-2 mb-2 tag-list"></div>
                                <input type="text" class="w-full rounded-md border-slate-200 px-3 py-2 tag-input" placeholder="Tambah tag (ketik lalu Enter)">
                                <div class="mt-2 text-sm text-slate-500">Tekan Enter untuk menambah tag baru atau pilih dari saran.</div>
                                <div class="tag-suggestions mt-1 z-50"></div>
                                <div class="tag-hidden-inputs"></div>
                            </div>
                        </div>
                    </label>

                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Subtitle</span>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $news->subtitle) }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">
                    </label>

                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Author</span>
                        <input type="text" name="author" value="{{ old('author', $news->author) }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">
                    </label>

<label class="block">
    <span class="text-sm text-slate-700 dark:text-slate-300">Deskripsi</span>
    <textarea id="deskripsi" name="deskripsi" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">
        {{ old('deskripsi', $news->deskripsi ?? '') }}
    </textarea>
</label>

<!-- CKEditor + Style -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<style>
.ck-editor__editable_inline {
    min-height: 200px;
    border-radius: 0.5rem;
    padding: 1rem;
}
.ck-content ul {
    list-style-type: disc;
    margin-left: 1.5rem;
}
.ck-content ol {
    list-style-type: decimal;
    margin-left: 1.5rem;
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    ClassicEditor
        .create(document.querySelector('#deskripsi'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', 'undo', 'redo'
                ]
            }
        })
        .then(editor => {
            editor.model.document.on('change:data', () => {
                document.querySelector('#deskripsi').value = editor.getData();
            });
        })
        .catch(console.error);
});
</script>

                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Photo (opsional)</span>
                        <input type="file" name="photo" class="mt-1">
                        @if($news->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $news->photo) }}" alt="" class="h-24 w-32 object-cover rounded">
                            </div>
                        @endif
                    </label>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ request('redirect', route('news.index')) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800/80">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">
                            <i class="fa-solid fa-check"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script untuk auto generate slug --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            // Auto-update slug saat title diubah (selama user belum ubah slug manual)
            titleInput.addEventListener('input', function() {
                if (!slugInput.dataset.manual) {
                    slugInput.value = this.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                }
            });

            // Jika user ubah slug manual, hentikan auto-update
            slugInput.addEventListener('input', function() {
                this.dataset.manual = true;
            });
        });
    </script>
    {{-- Tag picker script --}}
    <script>
        (function(){
            function createChip(name, id){
                const chip = document.createElement('span');
                chip.className = 'inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-700';
                chip.textContent = name;
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'ml-2 text-slate-400 hover:text-rose-600';
                btn.innerHTML = '&times;';
                chip.appendChild(btn);
                return {chip, btn};
            }

            function initPicker(pickerEl){
                const available = JSON.parse(pickerEl.dataset.availableTags || '[]');
                const oldTags = JSON.parse(pickerEl.dataset.oldTags || '[]');
                const listEl = pickerEl.querySelector('.tag-list');
                const inputEl = pickerEl.querySelector('.tag-input');
                const suggestionsEl = pickerEl.querySelector('.tag-suggestions');
                const hiddenEl = pickerEl.querySelector('.tag-hidden-inputs');

                const selected = [];

                function addTagObj(obj){
                    if (obj.id) {
                        if (selected.some(s=>s.id && s.id == obj.id)) return;
                    } else {
                        if (selected.some(s=>s.name && s.name.toLowerCase() === obj.name.toLowerCase())) return;
                    }

                    const {chip, btn} = createChip(obj.name, obj.id);
                    listEl.appendChild(chip);
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'tags[]';
                    input.value = obj.id ? obj.id : obj.name;
                    hiddenEl.appendChild(input);
                    selected.push(obj);
                    btn.addEventListener('click', function(){
                        const idx = selected.indexOf(obj);
                        if (idx !== -1) selected.splice(idx,1);
                        hiddenEl.removeChild(input);
                        listEl.removeChild(chip);
                    });
                }

                function showSuggestions(q){
                    const ql = q.trim().toLowerCase();
                    suggestionsEl.innerHTML = '';
                    if (ql === '') return;
                    const matches = available.filter(t => t.name.toLowerCase().includes(ql) && !selected.some(s=>s.id && s.id==t.id));
                    if (matches.length === 0) return;
                    const ul = document.createElement('ul');
                    ul.className = 'bg-white border rounded shadow p-2 max-h-40 overflow-auto';
                    matches.forEach(m => {
                        const li = document.createElement('li');
                        li.className = 'p-1 hover:bg-slate-100 cursor-pointer';
                        li.textContent = m.name;
                        li.addEventListener('click', function(){
                            addTagObj(m);
                            inputEl.value = '';
                            suggestionsEl.innerHTML = '';
                        });
                        ul.appendChild(li);
                    });
                    suggestionsEl.appendChild(ul);
                }

                oldTags.forEach(t => {
                    const found = available.find(a=>String(a.id) === String(t));
                    if (found) addTagObj(found);
                    else if (typeof t === 'string' && t.trim() !== '') addTagObj({name: t});
                });

                inputEl.addEventListener('input', function(e){
                    showSuggestions(this.value);
                });

                inputEl.addEventListener('keydown', function(e){
                    if (e.key === 'Enter' || e.key === ','){
                        e.preventDefault();
                        const val = this.value.trim().replace(/,+$/,'');
                        if (!val) return;
                        const match = available.find(a => a.name.toLowerCase() === val.toLowerCase());
                        if (match) addTagObj(match);
                        else addTagObj({name: val});
                        this.value = '';
                        suggestionsEl.innerHTML = '';
                    }
                });

                document.addEventListener('click', function(ev){
                    if (!pickerEl.contains(ev.target)){
                        suggestionsEl.innerHTML = '';
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function(){
                document.querySelectorAll('.tag-picker').forEach(initPicker);
            });
        })();
    </script>
</x-app-layout>
