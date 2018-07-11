$(function() {
  $('.selector').on('click', function (e) {
    e.preventDefault();
    var slug = $(this).data('slug');

    Vamshop.Wysiwyg.choose(slug);
  });
});
