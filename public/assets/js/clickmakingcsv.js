function clickmakingcsv() {

    var nickname = [];
    var times = [];
    var nowlogin = [];
    let csvmaxvalue = document.getElementById("csvmaxvalue").textContent;

    for (let i = 1; i <= csvmaxvalue; i++) {
        nickname.push(document.getElementsByClassName("nickname-" + i)[0].textContent);
        times.push(document.getElementsByClassName("times-" + i)[0].textContent);
        nowlogin.push(document.getElementsByClassName("nowlogin-" + i)[0].textContent);
    }

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //DBから検索結果を取得
        url: "/clickmakingcsv",
        type: "post",
        data: {
            nickname: nickname,
            logintimes: times,
            previouslogin: nowlogin,
        },
        dataType: "json",
    }).done( function(response) {

    }).fail( function() {
        $("#collapsesearchbuttonid").html('<div id="fail">通信が失敗しました。もう一度検索してください。</div>');
    })

}