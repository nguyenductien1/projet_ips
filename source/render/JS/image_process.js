function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#depose_image')
                .attr('src', e.target.result)
                .width(320)
                //.height(240);
        };

        reader.readAsDataURL(input.files[0]);
    }
}