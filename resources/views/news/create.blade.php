<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full flex-col gap-3">
            <h1 class="text-3xl font-semibold text-slate-900 dark:text-white">Buat News</h1>
            <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span>/</span>
                <a href="{{ route('news.index') }}" class="hover:text-indigo-600">News</a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200">Buat</span>
            </nav>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="block">
                            <span class="text-sm text-slate-700 dark:text-slate-300">Title</span>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ old('title') }}" 
                                class="mt-1 w-full rounded-md border-slate-200 px-3 py-2" 
                                required>
                        </label>
                        <label class="block">
                            <span class="text-sm text-slate-700 dark:text-slate-300">Slug (opsional)</span>
                            <input 
                                type="text" 
                                name="slug" 
                                id="slug" 
                                value="{{ old('slug') }}" 
                                class="mt-1 w-full rounded-md border-slate-200 px-3 py-2" 
                                placeholder="custom-slug-optional">
                        </label>
                    </div>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Tags</span>
                        <div class="mt-1">
                            <div class="tag-picker" data-available-tags='{{ json_encode($allTags->map(fn($t)=>['id'=>$t->id,'name'=>$t->name])->all()) }}' data-old-tags='{{ json_encode(old('tags', [])) }}'>
                                <div class="flex flex-wrap gap-2 mb-2 tag-list">
                                    <!-- chips inserted by JS -->
                                </div>
                                <input type="text" class="w-full rounded-md border-slate-200 px-3 py-2 tag-input" placeholder="Tambah tag (ketik lalu Enter)">
                                <div class="mt-2 text-sm text-slate-500">Tekan Enter untuk menambah tag baru atau pilih dari saran.</div>
                                <div class="tag-suggestions mt-1 z-50"></div>
                                <div class="tag-hidden-inputs"></div>
                            </div>
                        </div>
                    </label>

                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Subtitle</span>
                        <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">
                    </label>

                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Author</span>
                        <input type="text" name="author" value="{{ old('author') }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">
                    </label>

        {{-- Deskripsi pakai CKEditor --}}
        <label class="block">
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Deskripsi</span>
            <textarea id="deskripsi" name="deskripsi"
                class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">{{ old('deskripsi') }}</textarea>
        </label>
    {{-- CKEditor + Tailwind styling --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable_inline {
            min-height: 250px;
            border-radius: 0.5rem;
            padding: 1rem;
            background-color: white;
            color: #1e293b;
        }
        .ck-content ul {
            list-style-type: disc;
            margin-left: 1.5rem;
        }
        .ck-content ol {
            list-style-type: decimal;
            margin-left: 1.5rem;
        }
        .ck.ck-editor__main > .ck-editor__editable:not(.ck-focused) {
            border-color: rgb(226 232 240); /* slate-200 */
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            ClassicEditor.create(document.querySelector('#deskripsi'), {
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
                    </label>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ request('redirect', route('news.tags.index')) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800/80">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">
                            Simpan News
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

            titleInput.addEventListener('input', function() {
                // Jika user belum pernah ubah slug manual, isi otomatis
                if (!slugInput.dataset.manual) {
                    slugInput.value = this.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')   // hapus karakter aneh
                        .replace(/\s+/g, '-')        // ubah spasi jadi tanda "-"
                        .replace(/-+/g, '-');        // hapus tanda "-" ganda
                }
            });

            // Jika user ubah slug secara manual, hentikan auto-update
            slugInput.addEventListener('input', function() {
                this.dataset.manual = true;
            });
        });
    </script>
<script>
(function(){
    function createChipEl(displayName, key){
        const chip = document.createElement('span');
        chip.className = 'inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-700';
        chip.textContent = displayName;

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'ml-2 text-slate-400 hover:text-rose-600';
        btn.innerHTML = '&times;';
        chip.appendChild(btn);

        return { chip, btn };
    }

    function initPicker(pickerEl){
        // gunakan getAttribute agar aman dari HTML-escaping
        const rawAvailable = pickerEl.getAttribute('data-available-tags') || '[]';
        const rawOld = pickerEl.getAttribute('data-old-tags') || '[]';
        let available;
        let oldTags;
        try {
            available = JSON.parse(rawAvailable);
        } catch (e) {
            console.error('Gagal parse available-tags:', rawAvailable, e);
            available = [];
        }
        try {
            oldTags = JSON.parse(rawOld);
        } catch (e) {
            console.error('Gagal parse old-tags:', rawOld, e);
            oldTags = [];
        }

        const listEl = pickerEl.querySelector('.tag-list');
        const inputEl = pickerEl.querySelector('.tag-input');
        const suggestionsEl = pickerEl.querySelector('.tag-suggestions');
        const hiddenEl = pickerEl.querySelector('.tag-hidden-inputs');

        // selected akan menyimpan objek dalam bentuk normalized { id: ..., name: ... , key: 'id:12' / 'name:foo' }
        const selected = [];

        function makeKeyFromObj(obj){
            if (obj.id !== undefined && obj.id !== null) return 'id:' + String(obj.id);
            return 'name:' + String(obj.name).trim().toLowerCase();
        }

        function isSelected(obj){
            const key = makeKeyFromObj(obj);
            return selected.some(s => s.key === key);
        }

        function addTagObj(obj){
            if (!obj || !obj.name) return;
            const key = makeKeyFromObj(obj);
            if (selected.some(s => s.key === key)) {
                // sudah ada
                return;
            }

            const displayName = obj.name;
            const { chip, btn } = createChipEl(displayName, key);
            listEl.appendChild(chip);

            // buat hidden input (nilai = id jika ada, else nama)
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'tags[]';
            hidden.value = (obj.id !== undefined && obj.id !== null) ? obj.id : obj.name;
            hidden.setAttribute('data-tag-key', key);
            hiddenEl.appendChild(hidden);

            // simpan ke selected
            selected.push({ key, id: obj.id ?? null, name: obj.name });

            // bind delete
            btn.addEventListener('click', function(e){
                e.preventDefault();
                // hapus dari selected berdasarkan key
                const idx = selected.findIndex(s => s.key === key);
                if (idx !== -1) selected.splice(idx, 1);
                // hapus hidden input & chip
                const hid = hiddenEl.querySelector('input[data-tag-key="'+key+'"]');
                if (hid) hiddenEl.removeChild(hid);
                if (chip.parentNode) chip.parentNode.removeChild(chip);
            });
        }

        function showSuggestions(q){
            const ql = String(q || '').trim().toLowerCase();
            suggestionsEl.innerHTML = '';
            if (ql === '') return;
            const matches = available.filter(t => String(t.name || '').toLowerCase().includes(ql) && !isSelected(t));
            if (matches.length === 0) return;

            const ul = document.createElement('ul');
            ul.className = 'bg-white border rounded shadow p-2 max-h-40 overflow-auto';

            matches.forEach(m => {
                const li = document.createElement('li');
                li.className = 'p-1 hover:bg-slate-100 cursor-pointer';
                li.textContent = m.name;

                // gunakan pointerdown supaya dipanggil sebelum global click/blur
                li.addEventListener('pointerdown', function(e){
                    // hindari event bubbling yang menutup dropdown
                    e.preventDefault();
                    e.stopPropagation();
                    addTagObj(m);
                    inputEl.value = '';
                    suggestionsEl.innerHTML = '';
                    // fokus kembali ke input agar UX continous
                    setTimeout(() => inputEl.focus(), 0);
                });

                ul.appendChild(li);
            });

            suggestionsEl.appendChild(ul);
        }

        // tutup suggestions saat klik di luar picker
        document.addEventListener('click', function(ev){
            if (!pickerEl.contains(ev.target)){
                suggestionsEl.innerHTML = '';
            }
        });

        // init old tags (data lama bisa berisi id atau nama)
        oldTags.forEach(t => {
            if (t === null || t === undefined) return;
            // jika format number atau string number, coba match by id
            const foundById = available.find(a => String(a.id) === String(t));
            if (foundById) {
                addTagObj(foundById);
            } else if (typeof t === 'string' && t.trim() !== '') {
                addTagObj({ name: t });
            } else if (typeof t === 'number') {
                // numeric id but not found in available -> buat placeholder name same as id (optional)
                addTagObj({ id: t, name: String(t) });
            }
        });

        inputEl.addEventListener('input', function(){
            showSuggestions(this.value);
        });

        inputEl.addEventListener('keydown', function(e){
            if (e.key === 'Enter' || e.key === ','){
                e.preventDefault();
                const val = this.value.trim().replace(/,+$/,'');
                if (!val) return;
                // jika ada match exact name -> pakai id
                const match = available.find(a => String(a.name).toLowerCase() === val.toLowerCase());
                if (match) addTagObj(match);
                else addTagObj({ name: val });
                this.value = '';
                suggestionsEl.innerHTML = '';
            } else if (e.key === 'Escape') {
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
