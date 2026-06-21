@extends('layouts.client') @section('title', 'Tạo CV của bạn')

@section('content')
<div class="cv-builder-container" style="display: flex; height: calc(100vh - 70px); background: #f3f4f6;">
    
    <div class="builder-sidebar" style="width: 40%; background: #fff; padding: 20px; overflow-y: auto; border-right: 1px solid #e5e7eb;">
        @include('cvbuilder.form')
    </div>

    <div class="builder-preview" style="width: 60%; padding: 40px; display: flex; justify-content: center; overflow-y: auto;">
        <div class="a4-paper" style="width: 210mm; min-height: 297mm; background: white; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 20mm;">
            @include('cvbuilder.preview')
        </div>
    </div>

</div>

<script>
    // Khi gõ vào ô input, lập tức cập nhật bên preview
    document.addEventListener('input', function (e) {
        if (e.target.matches('.live-input')) {
            const targetId = e.target.getAttribute('data-target'); // Lấy id của thẻ cần cập nhật bên preview
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.innerText = e.target.value;
            }
        }
    });
</script>
@endsection