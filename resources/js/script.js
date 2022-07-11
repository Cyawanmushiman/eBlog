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

  //モーダル
  let winScrollTop;
  $('.js_modal_open').each(function(){//.js_modal_openが複数あるので、どのjs_modal_openがクリックされたかわかるようにする。
    // alert('aaaaaaaa');
    $(this).on("click",function(){
      winScrollTop = $(window).scrollTop();//winScrollTop = スクロール位置の値
      let target = $(this).data('target');//dataメソッドで、クリックした「js＿modal＿open」の「data-target」属性を取得し、変数「target」に代入している。つまり target = modal01 or modal02になる。
      let modal = document.getElementById(target);//指定したIDにマッチする要素を取得できる。
      //modal = 表示したいもの
      $(modal).fadeIn(50);
      return false;//clickイベントを中断する
    });
  });
  $('.js_modal_close').on("click",function(){//js_modal_closeがクリックされたら
    $('.js_modal').fadeOut(50);//js_modalをフェードアウトして消す。
    $('body,html').stop().animate({scrollTop:winScrollTop},100);//winScrollTopの位置まで、アニメーションさせながら、0.1秒かけて移動する。
    return false;
  });

});

