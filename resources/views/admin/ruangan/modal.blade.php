<div class="modal fade" id="ruanganModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formRuangan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="POST">

                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gedung</label>
                        <input type="text" class="form-control" name="gedung" id="gedung" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" name="kapasitas" id="kapasitas" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="gambar_type" id="gambar_file" value="file" checked>
                            <label class="form-check-label" for="gambar_file">Upload File</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="gambar_type" id="gambar_url_radio" value="url">
                            <label class="form-check-label" for="gambar_url_radio">URL Gambar</label>
                        </div>
                        
                        <div id="file_upload_section">
                            <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
                        </div>
                        
                        <div id="url_input_section" style="display:none;">
                            <input type="url" class="form-control" name="gambar_url" id="gambar_url" 
                                   placeholder="https://example.com/image.jpg">
                        </div>

                        <div id="current_image" class="mt-2" style="display: none;">
                            <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('gambar').onchange = function(evt) {
    const [file] = this.files;
    if (file) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
}

document.querySelectorAll('input[name="gambar_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const fileSection = document.getElementById('file_upload_section');
        const urlSection = document.getElementById('url_input_section');
        
        if (this.value === 'file') {
            fileSection.style.display = 'block';
            urlSection.style.display = 'none';
            document.getElementById('gambar_url_input').value = '';
        } else {
            fileSection.style.display = 'none';
            urlSection.style.display = 'block';
            document.getElementById('gambar').value = '';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formRuangan');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch(this.action, {
                method: this.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const result = await response.json();
            
            if (response.ok) {
                window.location.reload();
            } else {
                alert(result.message || 'Terjadi kesalahan saat menyimpan data');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data');
        }
    });
});
</script>
@endpush