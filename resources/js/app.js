import axios from 'axios';
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

window.toggleLike = function (itemId) {
    const button = event.currentTarget;
    if (button.disabled) return;

    button.disabled = true;

    const icon = document.getElementById('like-icon');
    const countSpan = document.getElementById('like-count');

    axios
        .post(`/likes/${itemId}/toggle`)
        .then((response) => {
            const isAttached = response.data.isAttached;
            const likesCount = response.data.likesCount;

            icon.src = isAttached
                ? '/images/likes_on.png'
                : '/images/likes_off.png';

            countSpan.innerText = likesCount;
        })
        .catch((error) => {
            console.error(error);
        })
        .finally(() => {
            button.disabled = false;
        });
};

document.addEventListener('alpine:init', () => {
    Alpine.store('checkout', {
        paymentMethod: '',
        labels: {},
    });
});

Alpine.start();
