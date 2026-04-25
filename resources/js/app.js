import axios from 'axios';
import './bootstrap';

axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            window.location.href = '/login';
        }
        return Promise.reject(error);
    },
);

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
        const preview = document.getElementById('preview');
        preview.src = reader.result;
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
            icon.src = response.data.isAttached
                ? button.dataset.onSrc
                : button.dataset.offSrc;

            countSpan.innerText = response.data.likesCount;
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

        initData(data) {
            if (data.paymentMethod) this.paymentMethod = data.paymentMethod;
            if (data.labels) this.labels = data.labels;
        },
    });
});

Alpine.start();
