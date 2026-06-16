{{-- Dùng chung cho Create & Edit --}}
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Tên Template <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name', $template->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">View Path <span class="text-danger">*</span></label>
        <input type="text" name="view_path" class="form-control"
               placeholder="templates.modern"
               value="{{ old('view_path', $template->view_path ?? '') }}" required>
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Thumbnail</label>
        <input type="file" name="thumbnail" class="form-control" accept="image/*">
        @if(!empty($template->thumbnail))
            <div class="mt-2">
                <img src="{{ Storage::url($template->thumbnail) }}"
                     alt="Thumbnail hiện tại" class="rounded" style="height:60px">
                <small class="text-muted ms-2">Thumbnail hiện tại</small>
            </div>
        @endif
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Default Styles <small class="text-muted">(JSON)</small></label>
        <textarea name="default_styles" class="form-control font-monospace" rows="4"
                  placeholder='{"color":"#1a2b4a","font":"Inter"}'
        >{{ old('default_styles', $template ? json_encode($template->default_styles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active"
                   value="1" id="is_active_{{ $template->id ?? 'new' }}"
                   {{ old('is_active', $template->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active_{{ $template->id ?? 'new' }}">
                Kích hoạt template
            </label>
        </div>
    </div>
</div>
