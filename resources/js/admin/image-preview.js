import '../bootstrap.js'
const imagesSelectors = {
    imagesWrapper: '.images-wrapper',
    imagesInput: '#images',
    thumbnailPreview: '#thumbnail-preview',
    thumbnailInput: '#thumbnail'
};

$(document).ready(() => {password_reset_tokens
    if (window.FileReader){
        $(imagesSelectors.imagesInput).change(function(){
            let counter = 0, file;
            const template = '<div class="mb-4"><img src="__url__" style="width: 100%"></div>';

            $(imagesSelectors.imagesWrapper).html('');

            while(file = this.files[counter++]){
                const reader = new FileReader();
                reader.onloadend = (function () {
                    return function (e){
                        const img = template.replace('__url__', e.target.result);
                        $(imagesSelectors.imagesWrapper).append(img);
                    }
                })(file)
                reader.readAsDataURL(file)
            }

            $(imagesSelectors.thumbnailInput).change(function () {
                const reader = new FileReader();
                reader.onloadend = (e) => {
                    $(imagesSelectors.thumbnailPreview).attr('src', e.target.result)
                };
                reader.readAsDataURL(this.files[0]);
            })
        });
    }
})
