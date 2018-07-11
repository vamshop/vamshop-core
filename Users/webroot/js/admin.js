/**
 * Users
 *
 * for UsersController
 */
var Users = {};

/**
 * functions to execute when document is ready
 *
 * only for NodesController
 *
 * @return void
 */
Users.documentReady = function () {
};

Users.statusControl = function() {
  $('#status').on('change', function (e) {
    var $passwords = $('#passwords');
    var $elements = $passwords.find(':input');
    $elements.prop('disabled', !this.checked);
    if (this.checked) {
      $passwords.slideDown('fast');
    } else {
      $passwords.slideUp('fast');
    }
  });
  $('#notification').on('change', function (e) {
    var $status = $('#status');
    $status.attr('checked', false);
    $status.trigger('change').closest('.checkbox').slideToggle('fast');
  });
};

/**
 * document ready
 *
 * @return void
 */
$(document).ready(function () {
  if (Vamshop.params.controller == 'Users') {
    Users.documentReady();

    if (Vamshop.params.action == 'add' && Vamshop.params.prefix == 'admin') {
      Users.statusControl();
    }
  }

  Admin.toggleRowSelection('#UsersCheckAll');
});
