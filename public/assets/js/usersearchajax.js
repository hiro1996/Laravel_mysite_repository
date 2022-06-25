function usersearchajax() {

    let logintimes = document.getElementsByName("logintimes");
    let times = document.getElementsByName("times");

    $.ajax({

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //DBから検索結果を取得
        url: "/user_search/usersearch",
        type: "post",
        data: {
            logintimes: logintimes[0].value,
            times: times[0].value,
        },
        dataType: "json",

    }).done( function(response) {

        if (Object.keys(response["data"]).length != 0) {

            var createTable = ``;
            createTable = `<div class="selectmodal"><div class="form-group"><div class="text-class"><input onclick="allCheck()" type="button" class="btn btn-primary w-auto selectmodal" value="全選択"></div></div></div>`;

            createTable += `<div class="table"><table class="table-class" id="table-id"><tr class="tr-class"><th class="check-class"></th><th class="nickname-class">ニックネーム</th><th class="times-class">ログイン回数</th><th class="nowlogin-class">直前ログイン</th></tr>`;
            //必要パラメータ (検索結果数、#、作品名、カテゴリー、説明)
            //tr要素作成
            for (let i = 0;i < Object.keys(response["data"]).length;i++) {
                createTable += `<tr class="tr-class"><td class="check-` + (i+1) + `"><input type="checkbox" name="check" class="check" id=checkid` + i + `></td><label for="checkid` + i + `"><td class="nickname-` + (i+1) + `" id="checkid` + i + `">${response["data"][i]["nickname"]}</td><td class="times-` + (i+1) + `" id=checkid` + i + `>${response["data"][i]["login_number_of_times"]}</td><td class="nowlogin-` + i + `" id=checkid` + i + `>${response["data"][i]["next_display_login_time"]}</td></label></tr>`;
            }
            createTable += `</table></div>`;
            $("#collapsesearchbuttonid").html(createTable);

            let divElement = document.createElement("div");
            divElement.setAttribute("class","float-right");

            let divChildElement = document.createElement("div");
            divChildElement.setAttribute("class","d-flex");
            let imgChildElement = document.createElement("img");
            imgChildElement.src = 'assets/img/icon/admin/adminimg/csv_icon.png';
            imgChildElement.alt = '矢印';
            imgChildElement.width = 15;
            imgChildElement.height = 15;

            let csvElement = document.createElement("a");
            csvElement.href = '/csv';
            var f = "document.download.submit();return false;";
            csvElement.setAttribute('onclick',f);
            csvElement.innerText = 'CSV出力';

            let csvformElement = document.createElement("form");
            csvformElement.action = '/csv';
            csvformElement.name = 'download';
            csvformElement.method = 'GET';
            let csvinputElement = document.createElement("input");
            csvinputElement.type = 'hidden';
            csvinputElement.name = 'param';

            csvinputElement.value = 'para';
            csvformElement.appendChild(csvinputElement);
            divChildElement.appendChild(imgChildElement);
            divChildElement.appendChild(csvElement);
            divChildElement.appendChild(csvformElement);
            divElement.appendChild(divChildElement);
            $("#csvid").html(divElement);
        } else {
            $("#collapsesearchbuttonid").html('<div id="not-search">検索結果がありません。</div>');
        }

    }).fail( function() {
        $("#collapsesearchbuttonid").html('<div id="fail">通信が失敗しました。もう一度検索してください。</div>');
    })

}

function allCheck() {
    const checkbox = document.getElementsByName("check")
    for(i = 0; i < checkbox.length; i++) {
        checkbox[i].checked = true
    }
}