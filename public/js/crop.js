jQuery(function($) {

    var p = $("#previewimage");
    $("body").on("change", "#image", function() {

        var imageReader = new FileReader();
        imageReader.readAsDataURL(document.getElementById("image").files[0]);

        imageReader.onload = function(oFREvent) {
            p.attr('src', oFREvent.target.result).fadeIn();
        };
    });

    $('#previewimage').imgAreaSelect({
        onSelectEnd: function(img, selection) {
            $('input[name="x1"]').val(selection.x1);
            $('input[name="y1"]').val(selection.y1);
            $('input[name="w"]').val(selection.width);
            $('input[name="h"]').val(selection.height);
        }
    });
});