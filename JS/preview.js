function previewImage(event, querySelector){
    const input = event.target;
    $imgPreview = document.querySelector(querySelector);
    if(!input.files.length) return;
    file = input.files[0];
    objectURL = URL.createObjectURL(file);
    $imgPreview.src = objectURL;
}