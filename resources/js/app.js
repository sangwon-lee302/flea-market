import './bootstrap';

window.previewImage = function (event) {
    const file = event.target.files[0];

    if (!file) return;

    const maxSize = 2 * 1024 * 1024;
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

    if (!allowedTypes.includes(file.type) || file.size > maxSize) {
        alert('JPEG/JPG/PNG形式で、2MB以内の画像を選択してください。');
        event.target.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function () {
        const output = document.getElementById('preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(file);
};
