import './bootstrap'

// is it possible to check the file type before showing preview?
window.previewImage = function (event) {
    const output = document.getElementById('preview')
    const file = event.target.files[0]

    if (file && file.type.startsWith('image/')) {
        output.src = URL.createObjectURL(file)

        output.onload = () => URL.revokeObjectURL(output.src)
    }
}
