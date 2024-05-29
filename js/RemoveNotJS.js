$(document).ready(function() {
    var elems = document.querySelectorAll(".notJS");
    [].forEach.call(elems, function(el) {
        el.remove();
    });
});