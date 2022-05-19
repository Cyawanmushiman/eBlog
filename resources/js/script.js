$(function () {
  // ハンバーガーメニュー（画面右上にボタン）
  var $nav = $("#navArea");
  var $btn = $(".toggle_btn");
  var $mask = $("#mask");
  var open = "open"; // class

  // menu open close
  $btn.on("click", function () {
    if (!$nav.hasClass(open)) {
      //navAreaクラスにopenクラスが付いてなければ
      $nav.addClass(open); //navAreaクラスにopenクラスをつける。
    } else {
      $nav.removeClass(open); //そうでなければ、openクラスをとる。
    }
  });

  // mask close
  $mask.on("click", function () {
    $nav.removeClass(open);
  });
});
