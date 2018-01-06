function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#product-image')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    var levelClass = $('#category').find('option:selected').attr('class');
    $('#subcategory option').each(function () {
        var self = $(this);
        if (self.hasClass(levelClass)) {
            self.show();
        } else {
            self.hide();
            $('#none').prop('selected', true);
        }
    });
});

$(function(){
    $("#category").on("change",function(){
        var levelClass = $('#category').find('option:selected').attr('class');
        $('#subcategory option').each(function () {
            var self = $(this);
            if (self.hasClass(levelClass)) {
                self.show();
            } else {
                self.hide();
                $('#none').prop('selected', true);
            }
        });
    });
});