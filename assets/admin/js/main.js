(function ($) {
	("use strict");

  var windowOn = $(window);
	////////////////////////////////////////////////////
	// PreLoader Js start
	windowOn.on("load", function () {
    $("#loading").fadeOut(500);
	});
  // PreLoader Js end

  // Quantity Js start
  $(".q-minus").click(function () {
    var $input = $(this).parent().find("input");
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    return false;
  });
  $(".q-plus").click(function () {
    var $input = $(this).parent().find("input");
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
  });
  // Quantity Js end

  // metismenu activation start 
  $("#metismenu").metisMenu();
  // metismenu activation end 
  
  // niceSelect activation start 
  $('select').niceSelect();
  // niceSelect activation end 
  
  // shortmenu Js start
  $("#shortmenu").on("click", function () {
    $(".eduman-quick-menu-dropdown").toggleClass("shortmenu-enable");
    $(".eduman-header-overlay").toggleClass("shortmenu-enable");
    $(".eduman-quick-lang-dropdown").removeClass("langmenu-enable");
    $(".eduman-notification-dropdown").removeClass("notifydropdown-enable");
    $(".eduman-email-dropdown").removeClass("emaildropdown-enable");
  });
  $(".eduman-header-overlay").on("click", function () {
    $(".eduman-quick-menu-dropdown").removeClass("shortmenu-enable");
    $(".eduman-header-overlay").removeClass("shortmenu-enable");
  });
  // shortmenu Js end

  // langdropdown Js start
  $("#langdropdown").on("click", function () {
    $(".eduman-quick-lang-dropdown").toggleClass("langmenu-enable");
    $(".eduman-header-overlay").toggleClass("langmenu-enable");
    $(".eduman-quick-menu-dropdown").removeClass("shortmenu-enable");
    $(".eduman-notification-dropdown").removeClass("notifydropdown-enable");
    $(".eduman-email-dropdown").removeClass("emaildropdown-enable");
  });
  $(".eduman-header-overlay").on("click", function () {
    $(".eduman-quick-lang-dropdown").removeClass("langmenu-enable");
    $(".eduman-header-overlay").removeClass("langmenu-enable");
  });
  // langdropdown Js end

  // notifydropdown Js start
  $("#notifydropdown").on("click", function () {
    $(".eduman-notification-dropdown").toggleClass("notifydropdown-enable");
    $(".eduman-header-overlay").toggleClass("notifydropdown-enable");
    $(".eduman-quick-menu-dropdown").removeClass("shortmenu-enable");
    $(".eduman-quick-lang-dropdown").removeClass("langmenu-enable");
    $(".eduman-email-dropdown").removeClass("emaildropdown-enable");
  });
  $(".eduman-header-overlay").on("click", function () {
    $(".eduman-notification-dropdown").removeClass("notifydropdown-enable");
    $(".eduman-header-overlay").removeClass("notifydropdown-enable");
  });
  // notifydropdown Js end
  
  // emaildropdown Js start
  $("#emaildropdown").on("click", function () {
    $(".eduman-email-dropdown").toggleClass("emaildropdown-enable");
    $(".eduman-header-overlay").toggleClass("emaildropdown-enable");
    $(".eduman-quick-menu-dropdown").removeClass("shortmenu-enable");
    $(".eduman-quick-lang-dropdown").removeClass("langmenu-enable");
    $(".eduman-notification-dropdown").removeClass("notifydropdown-enable");
  });
  $(".eduman-header-overlay").on("click", function () {
    $(".eduman-email-dropdown").removeClass("emaildropdown-enable");
    $(".eduman-header-overlay").removeClass("emaildropdown-enable");
  });
  // emaildropdown Js end

  // sidebarToggle js start
  $("#sidebarToggle").on("click", function() {
    $(".eduman-dashboard-sidebar").toggleClass("sidebar-enable");
    $(".eduman-dashboard-main").toggleClass("sidebar-enable");
    $(".eduman-menu-overlay").toggleClass("sidebar-enable");
  });
  $(".eduman-menu-overlay").on("click", function () {
    $(".eduman-dashboard-sidebar").removeClass("sidebar-enable");
    $(".eduman-dashboard-main").removeClass("sidebar-enable");
    $(".eduman-menu-overlay").removeClass("sidebar-enable");
  });
  // sidebarToggle js end

  // password show hide start 
  $(".toggle-password").click(function () {
    
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("formaction"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  // password show hide end


  // dropdown action start 
    $(".dropdown").click(function(){
      $(this).find(".dropdown-list").fadeToggle(100);
    });
  $(document).on("click", function(event){
    var $trigger = $(".dropdown");
    if($trigger !== event.target && !$trigger.has(event.target).length){
      $(".dropdown-list").fadeOut(100);
    }
  });
  // dropdown action end 

  // popup action start 
  $(".open").click(function (){
    $(".pop-outer").fadeIn("slow");
  });
  $(".close").click(function (){
      $(".pop-outer").fadeOut("slow");
  });
  $(".openA").click(function (){
    $(".pop-outerA").fadeIn("slow");
  });
  $(".closeA").click(function (){
      $(".pop-outerA").fadeOut("slow");
  });
  $(".openB").click(function (){
    $(".pop-outerB").fadeIn("slow");
  });
  $(".closeB").click(function (){
      $(".pop-outerB").fadeOut("slow");
  });
  // popup action end

  // custom tab action start 
  $(document).ready(function () {
    $('.tab-a').click(function () {
      $(".tab").removeClass('tab-active');
      $(".tab[data-id='" + $(this).attr('data-id') + "']").addClass("tab-active");
      $(".tab-a").removeClass('active-a');
      $(this).parent().find(".tab-a").addClass('active-a');
    });
  });
  $(document).ready(function () {
    $('.tab-b').click(function () {
      $(".tab").removeClass('tab-activeA');
      $(".tab[data-id='" + $(this).attr('data-id') + "']").addClass("tab-activeA");
      $(".tab-b").removeClass('active-b');
      $(this).parent().find(".tab-b").addClass('active-b');
    });
  });
  // custom tab action end 

  $(document).ready(function(){

  $(':checkbox.selectall').on('click', function(){
    $(':checkbox[name=' + $(this).data('checkbox-name') + ']').prop("checked", $(this).prop("checked"));
  });
  // Individual checkboxes
  $(':checkbox.checkme').on('click', function(){ // 1

    var _this = $(this); // 2
    var _selectall = _this.prop("checked"); //3

    if ( _selectall ) { // 4
      // 5
      $( ':checkbox[name=' + _this.attr('name') + ']' ).each(function(i){
        // 6
        _selectall = $(this).prop("checked");
        return _selectall; // 7
      });

    }

    // 8
    $(':checkbox[name=' + $(this).data('select-all') + ']').prop("checked", _selectall);
  });

});
})(jQuery);