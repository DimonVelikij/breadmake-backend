$(function() {
    try {
        var imageCropField = $('input[crop=image]'),
            imageCropParams = JSON.parse(imageCropField.val()),
            originalImage = $('img#image-crop-original'),
            imageCropPreview = $('div#image-crop-preview'),
            prop = imageCropParams.maxShowWidth / imageCropParams.width;

        originalImage.css({width: imageCropParams.maxShowWidth});
        $('img#image-crop').css({width: imageCropParams.showCropPreviewWidth});
        imageCropPreview.css({
            width: imageCropParams.showCropPreviewWidth,
            height: imageCropParams.cropHeight * (imageCropParams.showCropPreviewWidth / imageCropParams.cropWidth),
            backgroundSize: (imageCropParams.showCropPreviewWidth / (imageCropParams.cropWidth / imageCropParams.width)) + 'px'
        });

        originalImage.Jcrop({
            aspectRatio: imageCropParams.cropWidth / imageCropParams.cropHeight,
            minSize: [
                imageCropParams.cropWidth * prop,
                imageCropParams.cropHeight * prop
            ],
            setSelect: [
                imageCropParams.x1 * prop,
                imageCropParams.y1 * prop,
                imageCropParams.x2 * prop,
                imageCropParams.y2 * prop
            ],
            bgColor: '#',
            onChange: onChange,
            onSelect: onSelect
        });

        function onChange(c) {
            var cropWidth = imageCropParams.showCropPreviewWidth,
                cropHeight = cropWidth / (imageCropParams.cropWidth / imageCropParams.cropHeight);
            imageCropPreview.css({
                backgroundPosition: -parseInt(c.x / prop * (cropWidth / ((c.x2 - c.x) / prop))) + 'px ' + -parseInt(c.y / prop * (cropHeight / ((c.y2 - c.y) / prop))) + 'px',
                backgroundSize: parseInt(cropWidth / ((c.x2 - c.x) / prop / imageCropParams.width)) + 'px auto'
            });
        }

        function onSelect(c) {
            imageCropParams.x1 = parseInt(c.x / prop);
            imageCropParams.y1 = parseInt(c.y / prop);
            imageCropParams.x2 = parseInt(c.x2 / prop);
            imageCropParams.y2 = parseInt(c.y2 / prop);

            imageCropField.val(JSON.stringify(imageCropParams));
        }
    } catch (e) {}
});