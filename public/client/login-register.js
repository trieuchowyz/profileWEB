document.addEventListener('DOMContentLoaded', function() {

    // ==========================================
    // 1. LOGIC ẨN/HIỆN MẬT KHẨU (CON MẮT)
    // ==========================================
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.previousElementSibling; // Lấy thẻ input ngay phía trước icon
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('ti-eye');
                this.classList.add('ti-eye-off'); // Đổi icon thành mắt nhắm
            } else {
                input.type = 'password';
                this.classList.remove('ti-eye-off');
                this.classList.add('ti-eye'); // Đổi lại thành mắt mở
            }
        });
    });

    // ==========================================
    // 2. LOGIC CHO FORM ĐĂNG NHẬP
    // ==========================================
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.querySelector('.btn-text');
        const btnSpinner = document.getElementById('btnSpinner');
        const generalError = document.getElementById('generalError');

        function clearErrors() {
            generalError.style.display = 'none';
            document.querySelectorAll('.form-error').forEach(el => { el.style.display = 'none'; el.innerText = ''; });
            document.querySelectorAll('.form-control').forEach(el => { el.style.borderColor = 'var(--pink-200)'; });
        }

        function setLoading(isLoading) {
            submitBtn.disabled = isLoading;
            btnText.style.display = isLoading ? 'none' : 'block';
            btnSpinner.style.display = isLoading ? 'block' : 'none';
        }

        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            clearErrors();
            setLoading(true);

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            // QUAN TRỌNG: Ép kiểu "Remember" thành true/false chuẩn JSON để backend ghi nhận
            data.remember = formData.has('remember');

            try {
                const response = await fetch('/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    window.location.href = '/';
                } else {
                    if (response.status === 422 && result.errors) {
                        for (const [field, messages] of Object.entries(result.errors)) {
                            const inputEl = document.getElementById(field);
                            const errorEl = document.getElementById(`${field}Error`);
                            if (inputEl && errorEl) {
                                inputEl.style.borderColor = '#ef4444';
                                errorEl.innerText = messages[0];
                                errorEl.style.display = 'block';
                            }
                        }
                    } else {
                        generalError.style.display = 'block';
                        if(result.message) generalError.querySelector('div').innerText = result.message;
                    }
                }
            } catch (error) {
                generalError.style.display = 'block';
                generalError.querySelector('div').innerText = 'Có lỗi xảy ra khi kết nối đến máy chủ.';
            } finally {
                setLoading(false);
            }
        });
    }

    // ==========================================
    // 3. LOGIC CHO FORM ĐĂNG KÝ
    // ==========================================
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        const submitBtnReg = document.getElementById('submitBtnReg');
        const btnTextReg = document.getElementById('btnTextReg');
        const btnSpinnerReg = document.getElementById('btnSpinnerReg');
        const generalErrorReg = document.getElementById('generalErrorReg');

        function clearErrorsReg() {
            generalErrorReg.style.display = 'none';
            registerForm.querySelectorAll('.form-error').forEach(el => { el.style.display = 'none'; el.innerText = ''; });
            registerForm.querySelectorAll('.form-control').forEach(el => { el.style.borderColor = 'var(--pink-200)'; });
        }

        function setLoadingReg(isLoading) {
            submitBtnReg.disabled = isLoading;
            btnTextReg.style.display = isLoading ? 'none' : 'block';
            btnSpinnerReg.style.display = isLoading ? 'block' : 'none';
        }

        registerForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            clearErrorsReg();
            setLoadingReg(true);

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Đăng ký thành công! Đang chuyển hướng đến trang đăng nhập...');
                    window.location.href = '/auth/login';
                } else {
                    if (response.status === 422 && result.errors) {
                        for (const [field, messages] of Object.entries(result.errors)) {
                            const inputEl = document.getElementById(field);
                            const errorEl = document.getElementById(`${field}Error`);
                            if (inputEl && errorEl) {
                                inputEl.style.borderColor = '#ef4444';
                                errorEl.innerText = messages[0];
                                errorEl.style.display = 'block';
                            }
                        }
                    } else {
                        generalErrorReg.style.display = 'block';
                        if(result.message) generalErrorReg.querySelector('div').innerText = result.message;
                    }
                }
            } catch (error) {
                generalErrorReg.style.display = 'block';
                generalErrorReg.querySelector('div').innerText = 'Có lỗi xảy ra khi kết nối đến máy chủ.';
            } finally {
                setLoadingReg(false);
            }
        });
    }
});
